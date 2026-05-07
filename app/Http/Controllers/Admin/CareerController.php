<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::orderBy('sort_order')->orderByDesc('id')->paginate(20);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        $career = new Career();
        return view('admin.careers.create', compact('career'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'department'   => ['nullable', 'string', 'max:255'],
            'location'     => ['nullable', 'string', 'max:255'],
            'type'         => ['required', 'in:full-time,part-time,contract,internship'],
            'description'  => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'deadline'     => ['nullable', 'date'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer'],
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        Career::create($data);
        return redirect()->route('admin.careers.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'department'   => ['nullable', 'string', 'max:255'],
            'location'     => ['nullable', 'string', 'max:255'],
            'type'         => ['required', 'in:full-time,part-time,contract,internship'],
            'description'  => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'deadline'     => ['nullable', 'date'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $career->update($data);
        return redirect()->route('admin.careers.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return back()->with('success', 'Lowongan berhasil dihapus.');
    }
}
