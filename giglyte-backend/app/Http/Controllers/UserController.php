<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationCodeMail;
use App\Models\User;

class UserController extends Controller
{
    public function type($type)
    {
        return User::where('type', $type)->get();
    }

    public function index()
    {
        return User::all();
    }

    public function create(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (!$email || !$password) {
            return response()->json(['status' => 'error', 'message' => 'Email and password required'], 400);
        }

        if (User::where('email', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Email already exists'], 409);
        }

        $password_hash = Hash::make($password);
        $code = random_int(1111, 9999);

        $item = new User();
        $item->email = $email;
        $item->password = $password_hash;
        $item->verification_code = $code;
        $item->save();

        try {
            Mail::to($email)->send(new VerificationCodeMail($code));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not send email: ' . $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'message' => "User created and verification code sent to $email"]);
    }

    public function verify(Request $request)
    {
        $email = $request->email;
        $code = $request->code;

        if (!$email || !$code) {
            return response()->json(['status' => 'error', 'message' => 'Fill in all fields'], 400);
        }

        $item = User::where('email', $email)->where('verification_code', $code)->first();

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'User does not exist or Code invalid'], 404);
        }

        $item->email_verified = 1;
        $item->verification_code = null;
        $item->save();

        return response()->json(['status' => 'success', 'message' => 'User email verified'], 200);
    }

    public function final(Request $request)
    {
        $email = $request->email;
        $item = User::where('email', $email)->first();

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'User does not exist'], 404);
        }

        if ($item->email_verified === 0) {
            return response()->json(['status' => 'error', 'message' => 'Verify your mail first'], 400);
        }

        if (!$request->username || !$request->first_name || !$request->last_name) {
            return response()->json(['status' => 'error', 'message' => 'Fill in all fields'], 400);
        }

        $item->username = $request->username;
        $item->first_name = $request->first_name;
        $item->last_name = $request->last_name;
        $item->country = $request->country;
        $item->profile_image = $request->profile_image;
        $item->skills = $request->skills;
        $item->bio = $request->bio;
        $item->type = $request->type;
        $item->save();

        return response()->json(['status' => 'success', 'message' => 'User data saved'], 200);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (!$email || !$password) {
            return response()->json(['status' => 'error', 'message' => 'Both fields are required'], 400);
        }

        $item = User::where('email', $email)->first();

        if (!$item || !Hash::check($password, $item->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Credentials'], 400);
        }

        if ($item->email_verified === 0) {
            return response()->json(['status' => 'error', 'message' => 'Verify your mail first'], 400);
        }

        $token = Str::random(60);
        $item->token = $token;
        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Login Successful',
            'user' => [
                'id' => $item->id,
                'email' => $item->email,
                'type' => $item->type,
                'token' => $item->token,
            ]
        ], 200);
    }

    public function delete($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return response()->json(['status' => 'success', 'message' => "User with ID $id deleted successfully"]);
    }

    public function update(Request $request)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !Str::startsWith($authHeader, 'Bearer ')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $token = Str::replaceFirst('Bearer ', '', $authHeader);
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Invalid token'], 401);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'country' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|url',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        foreach (['first_name', 'last_name', 'username', 'country', 'skills', 'bio', 'profile_image'] as $field) {
            if ($request->filled($field)) {
                $user->$field = $request->$field;
            }
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }
public function editForm(Request $request)
{
    $authHeader = $request->header('Authorization');

    if (!$authHeader || !Str::startsWith($authHeader, 'Bearer ')) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    $token = Str::replaceFirst('Bearer ', '', $authHeader);
    $user = User::where('token', $token)->first();

    if (!$user) {
        return response()->json(['status' => 'error', 'message' => 'Invalid token'], 401);
    }

    return view('update_profile', compact('user'));
}
public function dashboard(Request $request)
{
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json(['status' => 'error', 'message' => 'No token provided'], 401);
    }

    $user = User::where('token', $token)->first();

    if (!$user) {
        return response()->json(['status' => 'error', 'message' => 'Invalid token'], 401);
    }

    // You can adjust based on user type
    $jobs = [];
    if ($user->type === 'client') {
        $jobs = \App\Models\Jobs::where('client_id', $user->id)->get();
    } elseif ($user->type === 'freelancer') {
        $jobs = []; // Placeholder
    }

    return response()->json([
        'status' => 'success',
        'user' => $user,
        'jobs' => $jobs
    ]);
}
}