<form action="{{ route('jobs.create') }}" method="POST">
  @csrf
<input type="text" name="title">
<input type="submit">
</form>