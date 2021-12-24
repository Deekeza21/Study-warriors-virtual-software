<?php
// Include config file
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $username_err = "Please enter a email.";
    } elseif (!preg_match($emailPattern, trim($_POST["email"]))) {
        $username_err = "Invalid Email Format.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_username = trim($_POST["email"]);
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This email is already taken.";
                } else {
                    $username = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_first_name = trim($_POST['first_name']);
            $param_last_name = trim($_POST['last_name']);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to signin page
                header("location: signin.html");
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
        <h4>Sign up</h4>
    </div>

    <div class="container">
        <form class="form-group" method="POST" action="/signup.php">
            <div class="row mb-3">
                <div class="col-6">
                    <input type="text" id="firstName" name="first_name" class="form-control" placeholder="First Name" required autofocus>

                </div>
                <div class="col-6">
                    <input type="text" id="lastName" name="last_name" class="form-control" placeholder="Last Name" required>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="email" id="universityEmail" name="email" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="University Email" required>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="New Password" required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-8">
                    <input type="password" id="confirmPassword" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm New Password" required>
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="col-4">
                    <button class="btn btn-xs btn-success btn-block" type="submit">Join Now</button>
                </div>
            </div>


        </form>

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