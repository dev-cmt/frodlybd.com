<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // -------------------------------
        // 1️⃣ Reset Roles & Permissions (keep users)
        // php artisan db:seed --class=RolePermissionSeeder
        // -------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // -------------------------------
        // 2️⃣ Define Modules & Single Permissions
        // -------------------------------
        $modules = [
            'pricing plans',
            'sales',
            'clients',
            'seo',
            'settings',
            'users',
            'roles',
        ];

        $singlePermissions = [
            'view dashboard',
            'view package',
            'view developer api',
        ];

        $allPermissions = [];

        // -------------------------------
        // 3️⃣ Create Module Permissions
        // -------------------------------
        foreach ($modules as $module) {
            foreach (['view','create','edit','delete'] as $action) {
                $permissionName = "{$action} {$module}";
                Permission::updateOrCreate(
                    ['name' => $permissionName],
                    ['guard_name' => 'web']
                );
                $allPermissions[] = $permissionName;
            }
        }

        // -------------------------------
        // 4️⃣ Create Single Permissions
        // -------------------------------
        foreach ($singlePermissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm],
                ['guard_name' => 'web']
            );
            $allPermissions[] = $perm;
        }

        // -------------------------------
        // 5️⃣ Create Roles
        // -------------------------------
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'client']);

        // -------------------------------
        // 6️⃣ Assign Permissions to Roles
        // -------------------------------
        $superAdminRole->syncPermissions($allPermissions);
        $adminRole->syncPermissions($allPermissions);

        // Customer: only view developer api & dashboard
        $customerPermissions = array_filter($allPermissions, function($p) {
            return str_starts_with($p, 'view') && (str_contains($p, 'developer api') || str_contains($p, 'dashboard'));
        });
        $customerRole->syncPermissions($customerPermissions);

        // -------------------------------
        // 7️⃣ Create Default Users & Assign Roles
        // -------------------------------
        $superAdmin = User::firstOrCreate(
            ['email' => 'super@gmail.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('super12345'), 'is_admin' => 1]
        );
        $superAdmin->syncRoles([$superAdminRole]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin User', 'password' => Hash::make('admin12345'), 'is_admin' => 1]
        );
        $admin->syncRoles([$adminRole]);

        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            ['name' => 'Customer User', 'password' => Hash::make('customer12345')]
        );
        $customer->syncRoles([$customerRole]);

        $this->command->info('✅ Roles & Permissions refreshed successfully!');
    }
}
