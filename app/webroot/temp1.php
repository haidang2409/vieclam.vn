<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/home_style.css">
</head>
<body>
<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-sm-12 text-center">

            <div class="circle-loader">
                <div class="checkmark draw"></div>
            </div>

            <br>

            <div class="circle-confirm">
                <div class="circle-confirm-top"></div>
                <div class="circle-confirm-bottom"></div>
            </div>

            <p><button id="toggle" type="button" class="btn btn-success">Toggle Completed</button></p>
        </div>
    </div>
</div>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script>
    $(function () {
        /* Downloaded from https://www.codeseek.co/ */
        $('#toggle').click(function() {
            $('.circle-loader').toggleClass('load-complete');
            $('.checkmark').toggle();
        });
    })
</script>
</body>
</html>