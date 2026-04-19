<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $branches = Category::whereNull('parent_id')->orderBy('name')->get(['id', 'name']);

        $query = Category::withCount('artisanProfiles')
            ->with('parent')
            ->whereNotNull('parent_id')
            ->orderBy('name');

        if ($request->filled('branch')) {
            $query->where('parent_id', $request->branch);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($request->filter === 'inactive') {
            $query->where('is_active', false);
        }

        $categories = $query->get();

        return view('admin.categories.index', compact('categories', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id'   => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return back()->with('success', 'Catégorie créée avec succès.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:categories,name,{$category->id}"],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        unset($validated['remove_image']);

        $category->update($validated);

        return back()->with('success', 'Catégorie mise à jour.');
    }

    public function toggle(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return back()->with('success', $category->is_active ? 'Catégorie activée.' : 'Catégorie désactivée.');
    }

    public function destroy(Category $category)
    {
        if ($category->artisanProfiles()->exists()) {
            return back()->with('error', 'Impossible de supprimer : cette catégorie est utilisée par au moins un artisan. Désactivez-la à la place.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }
}
