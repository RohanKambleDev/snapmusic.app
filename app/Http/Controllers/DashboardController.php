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
        $query = $request->user()->videoJobs()->latest();

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $jobs = $query->paginate(10);

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