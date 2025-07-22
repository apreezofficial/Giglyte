

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <label>First Name</label>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"><br>

        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"><br>

        <label>Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}"><br>

        <label>Country</label>
        <input type="text" name="country" value="{{ old('country', $user->country) }}"><br>

        <label>Skills</label>
        <input type="text" name="skills" value="{{ old('skills', $user->skills) }}"><br>

        <label>Bio</label>
        <textarea name="bio">{{ old('bio', $user->bio) }}</textarea><br>

        <label>Profile Image (URL)</label>
        <input type="text" name="profile_image" value="{{ old('profile_image', $user->profile_image) }}"><br>

        <label>New Password</label>
        <input type="password" name="password"><br>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"><br>

        <button type="submit">Update Profile</button>
    </form>
</div>
@endsection