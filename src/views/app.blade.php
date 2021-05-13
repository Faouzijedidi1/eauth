<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,700" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style type="text/css">
        body{
            margin: 0;
            font-family: "Roboto","Helvetica", "Arial", sans-serif;
        }
        .login_page{
            background-color: #424242;
            height: 100vh;
            overflow: hidden;
            width: 100%;
        }
        .login_wrapper{
          position: fixed;
          top: 30%;
          left: 50%;
          transform: translate(-50%,-30%);
        }
        .title{
              font-size: 30px;
              text-align: center;
              color: #ffffff;
              font-weight: 300;
        }
        .subtitle{
              font-size: 50px;
              text-align: center;
              color: #ffffff;
              margin: 20px 0 10px 0;
              font-weight: 700;
        }
        form{
          margin-top: 50px;
          text-align: center;
        }
        label{
          font-size: 16px;
          text-align: center;
          color: #ffffff;
          font-weight: 300;
        }
        .textinput{
          background-color: rgba(255,255,255,0.3);
          width: 280px;
          height: 35px;
          outline: none !important;
          color: #fff;
          border: none;
          margin-top: 5px;
          padding-left: 10px;
        }
        .submit{
          width: 180px;
          height: 35px;
          background-color: #ffffff;
          border: none;
          font-size: 16px;
          color: #424242;
          font-weight: 300;
          cursor: pointer;
          border-radius: 0;
        }
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255,255,255,0.3) inset;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>