<form action="{{ route('user.create') }}" method="POST">
  @csrf
<input type="email" name="email"> <br>
<input type="password" name="password"><br>
<input type="submit">
</form>