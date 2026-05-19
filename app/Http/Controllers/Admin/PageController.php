<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all()->keyBy('slug');
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrNew(['slug' => $slug]);
        $settings = $slug === 'home' ? Setting::pluck('value', 'key')->toArray() : [];
        return view('admin.pages.edit', compact('page', 'slug', 'settings'));
    }

    public function update(Request $request, string $slug)
    {
        $rules = [
            'hero_title'       => 'nullable|string|max:200',
            'hero_subtitle'    => 'nullable|string|max:300',
            'video_url'        => 'nullable|url|max:500',
            'hero_image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'section_title'    => 'nullable|string|max:200',
            'content'          => 'nullable|string',
            'vision'           => 'nullable|string',
            'mission'          => 'nullable|string',
            'features'         => 'nullable|array',
            'features.*.title' => 'nullable|string|max:100',
            'features.*.desc'  => 'nullable|string|max:300',
            'features.*.icon'  => 'nullable|string|max:60',
            'karir_bullets'           => 'nullable|array',
            'karir_bullets.*.icon'    => 'nullable|string|max:60',
            'karir_bullets.*.text'    => 'nullable|string|max:120',
        ];

        if ($slug === 'home') {
            $rules = array_merge($rules, [
                'stat_1_number' => 'nullable|string|max:20',
                'stat_1_label'  => 'nullable|string|max:50',
                'stat_2_number' => 'nullable|string|max:20',
                'stat_2_label'  => 'nullable|string|max:50',
                'stat_3_number' => 'nullable|string|max:20',
                'stat_3_label'  => 'nullable|string|max:50',
                'stat_4_number' => 'nullable|string|max:20',
                'stat_4_label'  => 'nullable|string|max:50',
                'whyus_title'        => 'nullable|string|max:150',
                'whyus_desc'         => 'nullable|string|max:400',
                'whyus_item_1_icon'  => 'nullable|string|max:50',
                'whyus_item_1_title' => 'nullable|string|max:80',
                'whyus_item_1_desc'  => 'nullable|string|max:200',
                'whyus_item_2_icon'  => 'nullable|string|max:50',
                'whyus_item_2_title' => 'nullable|string|max:80',
                'whyus_item_2_desc'  => 'nullable|string|max:200',
                'whyus_item_3_icon'  => 'nullable|string|max:50',
                'whyus_item_3_title' => 'nullable|string|max:80',
                'whyus_item_3_desc'  => 'nullable|string|max:200',
                'whyus_item_4_icon'  => 'nullable|string|max:50',
                'whyus_item_4_title' => 'nullable|string|max:80',
                'whyus_item_4_desc'  => 'nullable|string|max:200',
            ]);
        }

        $request->validate($rules);

        $page = Page::firstOrNew(['slug' => $slug]);
        $page->fill($request->only(['hero_title', 'hero_subtitle', 'video_url', 'section_title', 'content', 'vision', 'mission']));

        // Save features — filter out rows where title is blank
        if ($request->has('features')) {
            $features = collect($request->input('features'))
                ->filter(fn($f) => !empty($f['title']))
                ->values()
                ->toArray();
            $page->features = $features ?: null;
        }

        // Save karir bullets as features
        if ($slug === 'karir' && $request->has('karir_bullets')) {
            $bullets = collect($request->input('karir_bullets'))
                ->filter(fn($b) => !empty($b['text']))
                ->values()
                ->toArray();
            $page->features = $bullets ?: null;
        }

        if ($request->hasFile('hero_image')) {
            $page->hero_image = $request->file('hero_image')->store('pages', 'public');
        }

        $page->save();

        // Save home-specific settings (Stats Bar & Why Us)
        if ($slug === 'home') {
            $homeKeys = [
                'stat_1_number', 'stat_1_label', 'stat_2_number', 'stat_2_label',
                'stat_3_number', 'stat_3_label', 'stat_4_number', 'stat_4_label',
                'whyus_title', 'whyus_desc',
                'whyus_item_1_icon', 'whyus_item_1_title', 'whyus_item_1_desc',
                'whyus_item_2_icon', 'whyus_item_2_title', 'whyus_item_2_desc',
                'whyus_item_3_icon', 'whyus_item_3_title', 'whyus_item_3_desc',
                'whyus_item_4_icon', 'whyus_item_4_title', 'whyus_item_4_desc',
            ];
            foreach ($homeKeys as $key) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Halaman berhasil disimpan.');
    }
}
