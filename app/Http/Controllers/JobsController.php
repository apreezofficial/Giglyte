<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    // 🔎 Get all jobs
    public function all()
    {
        return Jobs::all();
    }

    // 🚀 Create a new job
    public function create(Request $request)
    {
        // 1️⃣ Extract token from Authorization header
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !Str::startsWith($authHeader, 'Bearer ')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Please provide a valid Bearer token.'
            ], 401);
        }

        $token = Str::replaceFirst('Bearer ', '', $authHeader);
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token. Please login again.'
            ], 401);
        }

        // 2️⃣ Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'delivery_time' => 'required|string|max:50',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. Please correct the errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3️⃣ Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $count = 1;

        while (Jobs::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        // 4️⃣ Create the job
        $job = Jobs::create([
            'title' => $request->title,
            'slug' => $slug,
            'delivery_time' => $request->delivery_time,
            'status' => $request->status ?? 'pending',
            'description' => $request->description,
            'tags' => $request->tags,
            'price' => $request->price,
            'client_id' => $user->id,
        ]);

        // 5️⃣ Return beautiful response
        return response()->json([
            'status' => 'success',
            'message' => '🎉 Job created successfully!',
            'data' => [
                'id' => $job->id,
                'title' => $job->title,
                'slug' => $job->slug,
                'price' => $job->price,
                'client' => [
                    'id' => $user->id,
                    'email' => $user->email
                ]
            ]
        ], 201);
    }
}