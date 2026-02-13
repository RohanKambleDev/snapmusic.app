<?php

namespace App\Http\Controllers;

use App\Models\VideoJob;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with a list of video jobs.
     */
    public function index(Request $request)
    {
        $query = $request->user()->videoJobs();

        // Search by ID
        if ($request->filled('search')) {
            $search = $request->search;
            if (str_starts_with($search, '#')) {
                $search = substr($search, 1);
            }
            $query->where('id', 'like', "%{$search}%");
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        // Allow only specific fields for sorting to prevent SQL injection
        if (in_array($sortField, ['created_at', 'duration', 'status'])) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(12)->withQueryString();

        return view('dashboard', compact('jobs'));
    }

    /**
     * Display a specific video job.
     */
    public function show(VideoJob $videoJob)
    {
        if ($videoJob->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.show', compact('videoJob'));
    }
}