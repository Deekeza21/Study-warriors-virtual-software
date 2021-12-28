<?php
// Include config file
require_once "config1.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $username_err = "Please enter your email.";
    } else {
        $username = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, first_name, last_name, password FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_username = trim($_POST["email"]);

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["email"];
                        $fname = $row["first_name"];
                        $lname = $row["last_name"];
                        $hashed_password = $row["password"];

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $username;
                            $_SESSION["first_name"] = $fname;
                            $_SESSION["last_name"] = $lname;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
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
            <a class="p-2 text-dark font-weight-bold" href="/signup.php">Sign up</a>
            <a class="p-2 text-dark font-weight-bold" href="/signin.php">Sign in</a>
        </nav>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h4>Sign in</h4>
    </div>

    <div class="container">
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $login_err . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>';
        }
        ?>
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row mb-5">
                <div class="col-6">
                    <input type="email" id="email" name="email" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Email" required>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="col-6">
                    <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
            </div>
            <div class="padding"></div>
            <div class="row mb-3">
                <div class="col-6 text-center">
                    <a href="forgot.html">Forgot your password?</a>
                </div>
                <div class="col-2"></div>
                <div class="col-4">
                    <button class="btn btn-xs btn-success btn-block" type="submit">Sign in</button>
                </div>
            </div>


        </form>

    </div>

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