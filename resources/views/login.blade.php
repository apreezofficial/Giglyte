    <form id="login" action="{{ route('user.login') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="password" placeholder="Enter your password" required>
        <input type="submit" value="login">
    </form>