<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Email</title>


    <style>
        body{
            padding: 50px;
        }
        .email-header{
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd
        }

        .email-header h1{
            font-size: 24px;
            color: #333333;
            margin: 0
        }

        .email-body {
            padding: 20px;
        }

        .email-body p{
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
            margin: 0 0 5px;
        }

        .email-body .name {
            font-weight: bold;
        }

        .email-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
        }

        .email-footer p{
            font-size: 14px;
            color: #999999;
            margin: 0;
        }

        .button{
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #1a41de;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

    </style>

</head>
<body>

    <div class="email-header">

        <h1>Welcome to Insta App!</h1>

    </div>

    <div class="email-body">

        <p class="name">Hello {{ $name }}, </p>
        <p>Thank you for signing up to Insta app. We're excited to have you on board!</p>
        <p>To get started, please confirm your email address by clicking the button below.</p>
        <p><a href="{{ $app_url }}" class="button">Confirm Email Address</a></p>
        <p>If you did not sign up for this account, you can ignore this email.</p>
        <p>Best regards, <br> The Team</p>

    </div>

    <div class="email-footer">
        <p>&copy; Kredo Insta App. All rights reserved.</p>
    </div>
   
</body>
</html>