<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('created_at')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'slug'        => 'nullable|string|max:220|regex:/^[a-z0-9-]+$/|unique:projects,slug',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:200',
            'price'       => 'nullable|string|max:100',
            'type'        => 'nullable|string|max:50',
            'status'      => 'required|in:available,sold,upcoming',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'featured'    => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
            'pic_name'    => 'nullable|string|max:100',
            'pic_phone'   => 'nullable|string|max:20',
        ], [
            'slug.regex'  => 'Slug hanya boleh huruf kecil, angka, dan tanda minus.',
            'slug.unique' => 'Slug sudah digunakan oleh proyek lain.',
            'images.max' => 'Maksimal 10 foto',
            'images.*.max' => 'Masing-masing foto maksimal 5 MB',
        ]);

        $data['slug']     = Str::slug($data['slug'] ?? '') ?: Str::slug($data['title']);
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // Handle multiple images
        $storedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $storedImages[] = $file->store('projects', 'public');
            }
        }
        if (!empty($storedImages)) {
            $data['images'] = $storedImages;
        }

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'slug'        => 'nullable|string|max:220|regex:/^[a-z0-9-]+$/|unique:projects,slug,' . $project->id,
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:200',
            'price'       => 'nullable|string|max:100',
            'type'        => 'nullable|string|max:50',
            'status'      => 'required|in:available,sold,upcoming',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'featured'    => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
            'pic_name'    => 'nullable|string|max:100',
            'pic_phone'   => 'nullable|string|max:20',
        ], [
            'slug.regex'  => 'Slug hanya boleh huruf kecil, angka, dan tanda minus.',
            'slug.unique' => 'Slug sudah digunakan oleh proyek lain.',
            'images.max' => 'Maksimal 10 foto',
            'images.*.max' => 'Masing-masing foto maksimal 5 MB',
        ]);

        // Update slug only if explicitly provided; otherwise keep existing
        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            unset($data['slug']);
        }

        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // Handle multiple images
        $storedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $storedImages[] = $file->store('projects', 'public');
            }
        }
        if (!empty($storedImages)) {
            $data['images'] = $storedImages;
        }

        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
