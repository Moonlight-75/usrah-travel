<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __invoke(Request $request, string $page = 'home')
    {
        if ($page === 'home') {
            $featuredPackages = Package::where('is_featured', true)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            return view('public.home', compact('featuredPackages'));
        }

        $views = [
            'packages' => 'public.packages',
            'about' => 'public.about',
            'gallery' => 'public.gallery',
            'contact' => 'public.contact',
        ];

        return view($views[$page] ?? 'public.home');
    }

    public function packages()
    {
        $packages = Package::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $categories = ['all' => 'All', 'umrah' => 'Umrah', 'halal_tour' => 'Halal Tours', 'corporate' => 'Corporate'];
        return view('public.packages', compact('packages', 'categories'));
    }

    public function packageDetail($slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedPackages = Package::where('id', '!=', $package->id)
            ->where('category', $package->category)
            ->where('is_active', true)
            ->take(3)
            ->get();
        return view('public.package-detail', compact('package', 'relatedPackages'));
    }
}
