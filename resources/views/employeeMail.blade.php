<!-- resources/views/payroll/mail/payslip-mail.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELLVUE</title>
</head>
<body>
    <p>Name: {{$name }}</p>
    <p>Email: {{$email }}</p>
    <p>Password: {{$password }}</p>
    <p>BASE_URL: {{$base_url}}</p>
    <p>This is the content of the email.</p>
</body>
</html>
