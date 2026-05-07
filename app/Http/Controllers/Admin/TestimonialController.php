<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderByDesc('id')->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $testimonial = new Testimonial();
        return view('admin.testimonials.create', compact('testimonial'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['nullable', 'string', 'max:255'],
            'content'    => ['required', 'string'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $data['is_active'] = $request->boolean('is_active', true);

        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['nullable', 'string', 'max:255'],
            'content'    => ['required', 'string'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo) Storage::disk('public')->delete($testimonial->photo);
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');

        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo) Storage::disk('public')->delete($testimonial->photo);
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
