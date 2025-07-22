<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\User;
use App\Models\Jobs;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    // Freelancer applies for a job
    public function apply(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'freelancer_id' => 'required|exists:users,id',
            'cover_letter' => 'nullable|string',
        ]);

        $existing = JobApplication::where('job_id', $request->job_id)
                                  ->where('freelancer_id', $request->freelancer_id)
                                  ->first();

        if ($existing) {
            return response()->json(['status' => 'error', 'message' => 'Already applied for this job'], 409);
        }

        $application = JobApplication::create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Application submitted', 'application' => $application]);
    }

    // Client views applications for a job
    public function jobApplications($job_id)
    {
        $applications = JobApplication::where('job_id', $job_id)->with('freelancer')->get();

        return response()->json(['status' => 'success', 'applications' => $applications]);
    }

    // Accept or reject an application
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $app = JobApplication::findOrFail($id);
        $app->status = $request->status;
        $app->save();

        return response()->json(['status' => 'success', 'message' => 'Application updated']);
    }
}