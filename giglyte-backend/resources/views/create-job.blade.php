<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Job</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- CSRF Token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Tailwind CSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    $('#jobForm').on('submit', function (e) {
      e.preventDefault();

      const token = 'sXSOtXNoAWUPuOywOQLmd8DKpcdmhSEkX0hv1ZBVGUnW0WaLzSBK6vFmbrpV'; 

      $.ajax({
        url: "{{ route('jobs.create') }}",
        method: 'POST',
        data: $(this).serialize(),
        headers: {
          'Authorization': 'Bearer ' + token
        },
        success: function (response) {
          alert('✅ ' + (response.message || 'Job created successfully!'));
          $('#response').html(
            `<div class="text-green-600">✅ ${response.message || 'Job created successfully!'}</div>`
          );
        },
        error: function (xhr) {
          const errorMsg = xhr.responseJSON?.message || 'Something went wrong';
          alert('❌ ' + errorMsg);
          $('#response').html(
            `<div class="text-red-600">❌ ${errorMsg}</div>`
          );
        }
      });
    });
  });
</script>
</head>

<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white shadow-xl p-6 rounded-xl">
    <h1 class="text-xl font-bold mb-4 text-center">Create New Job</h1>

    <form id="jobForm" class="space-y-4">
@csrf
      <input type="text" name="title" placeholder="Job Title" class="w-full border px-4 py-2 rounded">
      <input type="text" name="slug" placeholder="Job Slug" class="w-full border px-4 py-2 rounded">
      <input type="text" name="delivery_time" placeholder="Delivery Time" class="w-full border px-4 py-2 rounded">
      <input type="text" name="status" placeholder="Status (optional)" class="w-full border px-4 py-2 rounded">
      <input type="text" name="tags" placeholder="Tags (optional)" class="w-full border px-4 py-2 rounded">
      <textarea name="description" placeholder="Description" class="w-full border px-4 py-2 rounded"></textarea>
      <input type="number" name="price" placeholder="Price" class="w-full border px-4 py-2 rounded">
      <input type="number" name="client_id" placeholder="Client ID" class="w-full border px-4 py-2 rounded">
      
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full transition">Submit</button>
    </form>

    <div id="response" class="mt-4 text-center"></div>
  </div>
</body>
</html>