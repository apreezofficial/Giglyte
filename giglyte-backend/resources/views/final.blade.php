<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Final Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 50px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        input[type="text"],
        input[type="submit"] {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #responseMessage {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        #responseMessage.success {
            color: green;
        }

        #responseMessage.error {
            color: red;
        }
    </style>
</head>
<body>

    <form id="finalForm">
        @csrf
        <input type="text" name="first_name" placeholder="First Name">
        <input type="text" name="last_name" placeholder="Last Name">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="skills" placeholder="Skills (comma-separated)">
        <input type="text" name="profile_picture" placeholder="Profile Picture URL">
        <input type="text" name="bio" placeholder="Bio">
        <input type="text" name="type" placeholder="Type (freelancer/client)">
        <input type="submit" value="Update Profile">
    </form>

    <div id="responseMessage"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#finalForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('user.final') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#responseMessage')
                        .removeClass('error')
                        .addClass('success')
                        .html(response.message);
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    let message = res?.message || 'Something went wrong';
                    $('#responseMessage')
                        .removeClass('success')
                        .addClass('error')
                        .html(message);
                }
            });
        });
    </script>

</body>
</html>