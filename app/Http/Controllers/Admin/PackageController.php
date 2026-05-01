<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:packages,slug',
            'category' => 'required|in:umrah,halal_tour,corporate',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'max_pax' => 'required|integer|min:1',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
            'terms' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['includes'] = $validated['includes']
            ? array_map('trim', explode(',', $validated['includes']))
            : [];
        $validated['excludes'] = $validated['excludes']
            ? array_map('trim', explode(',', $validated['excludes']))
            : [];

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:packages,slug,' . $package->id,
            'category' => 'required|in:umrah,halal_tour,corporate',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'max_pax' => 'required|integer|min:1',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
            'terms' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['includes'] = $validated['includes']
            ? array_map('trim', explode(',', $validated['includes']))
            : [];
        $validated['excludes'] = $validated['excludes']
            ? array_map('trim', explode(',', $validated['excludes']))
            : [];

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

    public function toggleActive(Package $package)
    {
        $package->update(['is_active' => !$package->is_active]);

        return back()->with('success', "Package " . ($package->is_active ? 'activated' : 'deactivated') . ".");
    }

    public function toggleFeatured(Package $package)
    {
        $package->update(['is_featured' => !$package->is_featured]);

        return back()->with('success', "Package " . ($package->is_featured ? 'featured' : 'unfeatured') . ".");
    }
}
