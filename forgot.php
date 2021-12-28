<?php
// Include config file
require_once "config1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**To store error message in reset password process : By Default blank */
    $reset_err = "";
    if (empty(trim($_POST["email"]))) {
        /** Validation message if email address not entered in the front end. Front end also have validation for this */
        $username_err = "Please enter your email.";
    } else {
        /**Assigning the value the send via post method to $username variable */
        $username = trim($_POST["email"]);
    }
    /**This condition check the $username_err is blank or not: Indicates the email address is set */
    if (empty($username_err)) {
        /** Query to check whether the email address is in database or not */
        $sql = "SELECT id, email, first_name, last_name, password FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters for the query
            $param_username = trim($_POST["email"]);

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists
                if ($stmt->rowCount() == 1) {
                    $status = 200;
                    $reset = true;
                } else {
                    $status = 404;
                    /** Setting reset error message to $reset_err variable */
                    $reset_err = "User not found !";
                    $reset = false;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
} else {
    $reset = false;
    $status =  200;
    $reset_err = "";
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
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 header-bg border-bottom box-shadow">
        <!-- Logo Section -->
        <h5 class="my-0 mr-md-auto font-weight-bold"><img src="logo.jpg" class="img-fluid mr-2" /> Study Warriors</h5>
        <!-- Navigation Menus -->
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark font-weight-bold" href="/signup.php">Sign up</a>
            <a class="p-2 text-dark font-weight-bold" href="/signin.php">Sign in</a>
        </nav>
    </div>
    <?php if (!$reset) { ?>
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-left">
            <!-- Error alert -->
            <?php
            if (!empty($reset_err) && $status === 404) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $reset_err . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>';
            }
            ?>
            <h1>Forgot Your Password?</h1>
            <small class="text-left">If you forgot your password, no worries: enter your email address and we'll send you a link you can use
                to pick a new password</small>
        </div>

        <div class="pricing-header container">
            <!-- Forgot password HTML Form -->   
            <form class="form-forgot" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Email box -->
                <div class="row mb-4">
                    <label class="px-3">Email</label>
                    <div class="col-12">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                </div>
                <!-- Reset Password button -->
                <div class="row mb-3">
                    <div class="col-11 col-md-4">
                        <button class="btn btn-xs btn-dark btn-block font-weight-bold" type="submit">RESET PASSWORD</button>
                    </div>
                    <div class="col-1 col-md-8"></div>
                </div>
            </form>
        </div>
    <?php } else if ($reset && $status === 200) { ?>
        <!-- Reset password success message section -->
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="text-success"><i class="fa fa-envelope"></i></h1>
            <h1 class="text-success">Reset link sent to your email address</h1>
            <small class="text-center">Please check your inbox for more information</small>
            <div class="mt-3"><a href="/signin.php" class="btn btn-primary"><i class="fa fa-sign-in"></i> Go to Signin</a></div>
        </div>
    <?php }  ?>
    <!-- Footer section with Social Links -->
    <footer class=" border-top footer-bg mt-5 footer">
        <div class="d-flex justify-content-center">
            <div class="padding">
                <div class="social-icons">
                    <a target="_blank" href="https://www.facebook.com"><button type="button" class="btn btn-social-icon btn-facebook btn-rounded"><i class="fa fa-facebook"></i></button></a>
                    <a target="_blank" href="https://www.twitter.com"><button type="button" class="btn btn-social-icon btn-twitter btn-rounded"><i class="fa fa-twitter"></i></button></a>
                    <a target="_blank" href="https://www.linkedin.com"><button type="button" class="btn btn-social-icon btn-linkedin btn-rounded"><i class="fa fa-linkedin"></i></button></a>
                    <a target="_blank" href="https://www.youtube.com"><button type="button" class="btn btn-social-icon btn-youtube btn-rounded"><i class="fa fa-youtube-play"></i></button></a>
                    <a target="_blank" href="https://www.instagram.com"><button type="button" class="btn btn-social-icon btn-instagram btn-rounded"><i class="fa fa-feed"></i></button></a>
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