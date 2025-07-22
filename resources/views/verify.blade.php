<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
        }

        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 400px;
            margin: 0 auto;
        }

        input[type="email"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #verifyMessage {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        #verifyMessage.success {
            color: green;
        }

        #verifyMessage.error {
            color: red;
        }
    </style>
</head>
<body>

    <form id="verifyForm">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="code" placeholder="Enter your verification code" required>
        <input type="submit" value="Verify Email">
    </form>

    <div id="verifyMessage"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#verifyForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('user.verify') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#verifyMessage')
                        .removeClass('error')
                        .addClass('success')
                        .html(response.message);
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    let message = res?.message || 'Verification failed';
                    $('#verifyMessage')
                        .removeClass('success')
                        .addClass('error')
                        .html(message);
                }
            });
        });
    </script>

</body>
</html>