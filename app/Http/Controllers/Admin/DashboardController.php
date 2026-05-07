<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'featured'       => Project::where('featured', true)->count(),
            'gallery'        => Gallery::count(),
            'available'      => Project::where('status', 'available')->count(),
            'leads_total'    => Lead::count(),
            'leads_today'    => Lead::whereDate('created_at', today())->count(),
        ];
        $recentLeads = Lead::latest()->take(5)->get();
        $site_name = Setting::get('site_name', 'Midland Properti');
        return view('admin.dashboard', compact('stats', 'site_name', 'recentLeads'));
    }
}
