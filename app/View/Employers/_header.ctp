<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if(isset($title)) { echo $title;}?> | <?php echo $_SERVER['HTTP_HOST'];?></title>
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <!-- Custom Theme Style -->
    <link href="/css/custom.css" rel="stylesheet">
    <script src="/js/jquery-2.1.4.min.js"></script>
    <style>
        body
        {
            overflow-y: scroll;
        }
        .login_wrapper
        {
            margin-top: 0 !important;
            max-width: 500px;
        }
        .login_content
        {
            margin: 25px auto !important;
            background-color: #ffffff;
            padding: 10px 25px;
            border-radius: 5px;
        }
        input.form-control
        {
            margin-bottom: 5px !important;
            margin-top: 20px !important;
        }
        div.error-message
        {
            text-align: left !important;
            color: #E74C3C !important;
        }
        div.error input
        {
            border: 1px dotted #E74C3C !important;
        }
        .btn-index
        {
            background-color: #199EB8 !important;
            border-color: #1998b2 !important;
            color: #ffffff;
        }
        .btn-index:hover
        {
            color: #ffffff;
            background-color: #19aac4 !important;
        }
        .btn[disabled]:focus, .btn[disabled]:hover, .btn[disabled]
        {
            background-color: #19aac4 !important;
            color: white;
        }
        h1
        {
            color: #199EB8 !important;
        }
        @media (max-width: 320px) {
            .login_wrapper
            {
                margin-top: 0 !important;
                max-width: 500px;
            }
            .login_content
            {
                margin: 10px auto !important;
                background-color: #ffffff;
                padding: 10px 10px;
            }
        }
    </style>
</head>
<body class="login">
<div style="padding: 0 5px">