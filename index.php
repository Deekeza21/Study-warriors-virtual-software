<?php
session_start();
$session = $_SESSION;
if (!isset($session['loggedin']) && !$session['loggedin']) {
    header("Location:signin.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Study Warriors</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 header-bg border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-bold"><img src="logo.jpg" class="img-fluid mr-2" /> Study Warriors</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark font-weight-bold" href="#">Subjects</a>
            <a class="p-2 text-dark font-weight-bold" href="#">Chat</a>
            <a class="p-2 text-dark font-weight-bold" href="#">Email</a>
            <a class="p-2 text-dark font-weight-bold" href="#">Create Group/Invite Member</a>
            <a class="p-2 text-dark font-weight-bold" href="/logout.php">Logout</a>
        </nav>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h4>Home</h4>
    </div>

    <div class="container">


    </div>

    <footer class=" border-top footer-bg mt-5 footer">
        <div class="d-flex justify-content-center">
            <div class="padding">
                <div class="social-icons">
                    <button type="button" class="btn btn-social-icon btn-facebook btn-rounded"><i class="fa fa-facebook"></i></button>
                    <button type="button" class="btn btn-social-icon btn-twitter btn-rounded"><i class="fa fa-twitter"></i></button>
                    <button type="button" class="btn btn-social-icon btn-linkedin btn-rounded"><i class="fa fa-linkedin"></i></button>
                    <button type="button" class="btn btn-social-icon btn-youtube btn-rounded"><i class="fa fa-youtube-play"></i></button>
                    <button type="button" class="btn btn-social-icon btn-instagram btn-rounded"><i class="fa fa-feed"></i></button>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/holder.min.js"></script>
    <script>
        Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
        });
    </script>
</body>

</html>