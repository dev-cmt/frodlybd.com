<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\SeoTrait;
use App\Helpers\FrodlyHelper;
use App\Models\Page;


class HomeController extends Controller
{
    use SeoTrait;

    public function welcome()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seo_tags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.welcome', compact('seo_tags','breadcrumbs'));
    }

    public function pageFrodly()
    {
        return view('frontend.frodly-checker');
    }

    public function getFrodly(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\d{11}$/'
        ]);

        $phone = $request->input('phone');

        $results = [
            'Redx'       => FrodlyHelper::getRedx($phone),
            'SteadFast'  => FrodlyHelper::getSteadFast($phone),
            'Pathao'     => FrodlyHelper::getPathao($phone),
            'Paperfly'   => FrodlyHelper::getPaperfly($phone),
        ];

        $placeholderLogos = [
            'redx'       => asset('frodly/courier-logo/redx.jpg'),
            'steadfast'  => asset('frodly/courier-logo/steadfast.jpg'),
            'pathao'     => asset('frodly/courier-logo/pathao.jpg'),
            'paperfly'   => asset('frodly/courier-logo/paperfly.jpg'),
        ];

        $summaries = [];
        $total_all = $success_all = $cancel_all = 0;

        foreach ($results as $courier => $data) {
            $summaries[$courier] = [
                'logo'    => $placeholderLogos[strtolower($courier)] ?? '',
                'total'   => $data['total'],
                'success' => $data['success'],
                'cancel'  => $data['cancel']
            ];

            $total_all   += $data['total'];
            $success_all += $data['success'];
            $cancel_all  += $data['cancel'];
        }

        return response()->json([
            'status' => true,
            'message' => 'Courier info retrieved successfully.',
            'data' => [
                'Summaries'    => $summaries,
                'totalSummary' => [
                    'total'       => $total_all,
                    'success'     => $success_all,
                    'cancel'      => $cancel_all,
                    'successRate' => $total_all ? round(($success_all / $total_all) * 100) : 0,
                    'cancelRate'  => $total_all ? round(($cancel_all / $total_all) * 100) : 0
                ]
            ]
        ]);
    }
}
