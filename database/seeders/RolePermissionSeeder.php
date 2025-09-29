<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
        // 2️⃣ Define Modules
        // -------------------------------
        $modules = [
            'packages',
            'developer api',
            'settings',
            'seo',
            'users',
            'roles',
        ];

        // -------------------------------
        // 3️⃣ Create Permissions
        // -------------------------------
        $permissions = [];
        foreach ($modules as $module) {
            foreach (['view', 'create', 'edit', 'delete'] as $action) {
                $permissionName = "{$action} {$module}";
                Permission::firstOrCreate(['name' => $permissionName]);
                $permissions[] = $permissionName;
            }
        }

        // -------------------------------
        // 4️⃣ Create Roles
        // -------------------------------
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // -------------------------------
        // 5️⃣ Assign Permissions
        // -------------------------------
        $adminRole->syncPermissions($permissions); // Admin: all permissions

        $editorPermissions = array_filter($permissions, function ($p) {
            return str_starts_with($p, 'view') || str_starts_with($p, 'blogs');
        });
        $editorRole->syncPermissions($editorPermissions);

        // -------------------------------
        // 6️⃣ Assign Roles to Existing Users (if exist)
        // -------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin User', 'password' => 'admin12345']
        );
        $admin->syncRoles([$adminRole]);

        $editor = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            ['name' => 'Editor User', 'password' => 'editor12345']
        );
        $editor->syncRoles([$editorRole]);

        $this->command->info('✅ Roles & Permissions refreshed successfully (users kept intact)!');
    }
}

?>
