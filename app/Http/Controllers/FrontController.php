<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Page;
use App\Models\Project;
use App\Models\Property;
use App\Models\Article;
use App\Models\Career;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\Testimonial;

class FrontController extends Controller
{
    private function nav(): array
    {
        return [
            'menu_home'    => Setting::get('menu_home', 'Beranda'),
            'menu_project' => Setting::get('menu_project', 'Proyek'),
            'menu_gallery' => Setting::get('menu_gallery', 'Galeri'),
            'menu_about'   => Setting::get('menu_about', 'Tentang Kami'),
            'menu_contact' => Setting::get('menu_contact', 'Kontak'),
            'site_name'    => Setting::get('site_name', 'Midland Properti'),
            'site_tagline' => Setting::get('site_tagline', 'Mitra Properti Terpercaya Anda'),
        ];
    }

    private function seo($title, $description, $og_image = null)
    {
        return [
            'title'               => $title,
            'meta_description'    => $description,
            'og_image'            => $og_image ?? asset('images/og-image.jpg'),
        ];
    }

    public function home()
    {
        $page         = Page::findBySlug('home');
        $featured     = Project::where('featured', true)->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $seo          = $this->seo(
            'Midland Properti - Agen Properti Terpercaya Jakarta',
            'Cari properti impian Anda di Midland Properti. Kami menawarkan rumah, apartemen, ruko, dan kavling berkualitas di lokasi strategis.',
            $page?->hero_image ? asset('storage/' . $page->hero_image) : null
        );
        return view('front.home', array_merge($this->nav(), compact('page', 'featured', 'testimonials'), $seo));
    }

    public function project()
    {
        $page     = Page::findBySlug('project');
        $projects = Project::orderBy('sort_order')->paginate(9);
        $seo      = $this->seo(
            'Daftar Proyek Properti - Midland Properti',
            'Temukan berbagai proyek properti terbaik dari Midland Properti. Pilihan lengkap rumah, apartemen, ruko, dan kavling di berbagai lokasi.'
        );
        return view('front.project', array_merge($this->nav(), compact('page', 'projects'), $seo));
    }

    public function projectShow(string $slug)
    {
        $project    = Project::where('slug', $slug)->firstOrFail();
        $properties = $project->properties()->orderBy('sort_order')->get();
        $related    = Project::where('id', '!=', $project->id)->where('type', $project->type)->take(3)->get();
        $seo        = $this->seo(
            $project->title . ' - Midland Properti',
            $project->description ? substr(strip_tags($project->description), 0, 160) : 'Lihat detail proyek ' . $project->title . ' di Midland Properti.',
            $project->image ? asset('storage/' . $project->image) : null
        );
        return view('front.project-detail', array_merge($this->nav(), compact('project', 'properties', 'related'), $seo));
    }

    public function propertyShow(string $slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();
        $project  = $property->project;
        $related  = $project->properties()->where('id', '!=', $property->id)->orderBy('sort_order')->take(4)->get();
        $seo      = $this->seo(
            $property->title . ' - Midland Properti',
            $property->description ? substr(strip_tags($property->description), 0, 160) : 'Lihat detail properti ' . $property->title . ' di Midland Properti.',
            $property->image ? asset('storage/' . $property->image) : null
        );
        return view('front.property-detail', array_merge($this->nav(), compact('property', 'project', 'related'), $seo));
    }

    public function gallery()
    {
        $page    = Page::findBySlug('gallery');
        $gallery = Gallery::orderBy('sort_order')->get();
        $seo     = $this->seo(
            'Galeri Properti Midland - Foto Proyek Terbaik',
            'Lihat galeri lengkap properti-properti terbaik dari Midland Properti. Ratusan foto proyek dan unit properti berkualitas.'
        );
        return view('front.gallery', array_merge($this->nav(), compact('page', 'gallery'), $seo));
    }

    public function articles()
    {
        $page = Page::findBySlug('articles') ?? (object)['hero_title' => 'Artikel Terbaru', 'hero_subtitle' => 'Tips dan informasi seputar properti', 'content' => ''];
        $articles = Article::where('status', 'published')->orderByDesc('published_at')->paginate(9);
        $seo = $this->seo(
            'Artikel Properti - Tips dan Tren Real Estate',
            'Baca artikel terkini tentang properti, tips investasi, dan tren real estate. Panduan lengkap dari ahli di Midland Properti.'
        );
        return view('front.articles', array_merge($this->nav(), compact('page', 'articles'), $seo));
    }

    public function articleShow(string $slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = Article::where('id', '!=', $article->id)->where('status', 'published')->orderByDesc('published_at')->take(3)->get();
        $seo = $this->seo(
            $article->title . ' - Midland Properti Blog',
            $article->excerpt ?: substr(strip_tags($article->content), 0, 160),
            $article->image ? asset('storage/' . $article->image) : null
        );
        return view('front.article-detail', array_merge($this->nav(), compact('article', 'related'), $seo));
    }

    public function about()
    {
        $page = Page::findBySlug('about');
        $organizations = \App\Models\Organization::orderBy('sort_order')->get();
        $seo = $this->seo(
            'Tentang Kami - Midland Properti',
            'Kenali tim profesional Midland Properti yang siap membantu Anda menemukan properti impian. Visi, misi, dan keunggulan kami.'
        );
        return view('front.about', array_merge($this->nav(), compact('page', 'organizations'), $seo));
    }

    public function contact()
    {
        $page = Page::findBySlug('contact');
        $seo = $this->seo(
            'Hubungi Kami - Midland Properti',
            'Hubungi kami untuk konsultasi gratis. Tim ahli kami siap membantu Anda menemukan properti yang tepat sesuai kebutuhan.'
        );
        return view('front.contact', array_merge($this->nav(), compact('page'), $seo));
    }

    public function simulasiCicilan()
    {
        $seo = $this->seo(
            'Simulasi Cicilan KPR - Midland Properti',
            'Hitung estimasi cicilan KPR properti Anda secara mudah dan cepat. Masukkan harga properti, DP, tenor, dan suku bunga untuk melihat skema cicilan.'
        );
        return view('front.simulasi-cicilan', array_merge($this->nav(), $seo));
    }

    public function karir()
    {
        $careers = Career::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get();
        $seo     = $this->seo(
            'Karir - Midland Properti',
            'Bergabunglah bersama tim profesional Midland Properti. Lihat lowongan pekerjaan terkini dan wujudkan karir impianmu di industri properti.'
        );
        return view('front.karir', array_merge($this->nav(), compact('careers'), $seo));
    }

    public function simulasiStoreLead(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['required', 'string', 'max:30'],
            'price_input' => ['nullable', 'integer', 'min:0'],
        ]);

        Lead::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'price_input' => $validated['price_input'] ?? null,
            'ip_address'  => $request->ip(),
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function simulasiRecommend(\Illuminate\Http\Request $request)    {
        $price = (float) $request->query('price', 0);

        if ($price <= 0) {
            return response()->json([]);
        }

        // Find up to 3 available properties within ±30% of the input price
        $margin = 0.30;
        $min    = $price * (1 - $margin);
        $max    = $price * (1 + $margin);

        $properties = Property::where('status', 'available')
            ->whereBetween('price', [$min, $max])
            ->orderByRaw('ABS(price - ?)', [$price])
            ->take(3)
            ->get();

        return response()->json(
            $properties->map(function ($p) {
                return [
                    'id'          => $p->id,
                    'title'       => $p->title,
                    'price'       => (float) $p->price,
                    'price_fmt'   => 'Rp ' . number_format($p->price, 0, ',', '.'),
                    'location'    => $p->location,
                    'type_label'  => $p->getTypeLabel(),
                    'status'      => $p->status,
                    'status_label'=> $p->getStatusLabel(),
                    'image'       => $p->image ? asset('storage/' . $p->image) : null,
                    'url'         => route('property.show', $p->slug),
                ];
            })
        );
    }
}
