<?php
// Set the session cookie to expire after 10 seconds
session_set_cookie_params(1800);
// start a session to store any errors that may occur during the registration process
session_start();

// include the necessary files
require_once __DIR__ . '/../../repository/authrepository.php';
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/role.php';

// create a new instance of the authrepository
$registerRepository = new authrepository();

// check if the user session variable is set
if (isset($_SESSION['admin'])) {
    $user = $_SESSION['admin'];
    //TODO: How to access the whole object?
    $userID = $_SESSION["adminID"];

    if (isset($_POST["register"])) {
        // retrieve the form data , remove the whitespace with trim
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

        // basic form validation
        if (empty($firstName) || empty($lastName) || empty($username)) {
            $_SESSION['register_error'] = 'Please fill out all required fields.';
        } elseif ($password !== $confirm_password) {
            $_SESSION['register_error'] = 'Passwords do not match.';
        } else {
            // try to register the user
            try {
                $newEditor = $registerRepository->register($firstName,$lastName,$username,$password,$confirm_password);

                // registration was successful, redirect the user to the login page
                header("Location: manageEditors");
                exit;
            } catch (Exception $e) {
                // there was an error during registration, store it in the session and display it
                $_SESSION['register_error'] = $e->getMessage();
            }
        }
    }
}
else{
    header("location:login");
}


if (isset($_POST["loginPage"])){
    header("Location: login");
    exit;
}

// check if there is a register error in the session
if (isset($_SESSION['register_error'])) {
    // display the register error message
    echo '<div class="alert alert-danger mt-3" role="alert">';
    echo $_SESSION['register_error'];
    echo '</div>';
    // unset the register error from the session
    unset($_SESSION['register_error']);
}

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="/Homemade.png" sizes="16x16" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Homemade Recipe Register Page</title>
</head>


<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index"><img src="/Homemade.png" alt="Logo" width="100" height="100"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="recipe">Recipes</a>
            </li>
            <!-- Add the Add Recipe link if the user is logged in -->
            <?php if (isset($_SESSION['admin'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="addrecipe">Add Recipe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manageEditors">Editor Management</a>
                </li>
            <?php
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="aboutme">About Me</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav">
            <!-- Add login and signup links here -->
            <?php if (!isset($_SESSION['admin'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register">Sign Up</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout">Logout</a>
                </li>
            <?php } ?>
        </ul>
</nav>

<div class="container mt-5">
    <h1>Homemade Recipe Editor Register Page</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter a first name">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter a last name">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter a username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter a password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm the password">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Submit</button>
        <button type="submit" class="btn btn-outline-success" name="loginPage">Login Page</button>
    </form>
</div>


<!--Footer-->
<footer class="bg-dark py-3" style="left: 0; bottom: 0; width: 100%; margin-top: 10px;">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-auto mb-2">
                <p class="text-white bg-dark">Vedat Türk End Assignment</p>
            </div>
            <div class="col-auto mb-2">
                <ul class="list-inline text-primary">
                    <li class="list-inline-item"><a href="index">Home</a></li>
                    <li class="list-inline-item"><a href="aboutme">About</a></li>
                    <li class="list-inline-item"><a href="ContactMe">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

