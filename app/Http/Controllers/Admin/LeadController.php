<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::latest();

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $likePattern = "%{$searchTerm}%";
            $query->where(function ($builder) use ($likePattern) {
                $builder->where('name', 'like', $likePattern)
                        ->orWhere('email', 'like', $likePattern)
                        ->orWhere('phone', 'like', $likePattern);
            });
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead berhasil dihapus.');
    }
}
