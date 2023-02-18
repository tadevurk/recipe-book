<?php
session_start();

if (!isset($_SESSION['admin'])){
    header("Location: login");
    exit;
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
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index"><img src="/Homemade.png" alt="Logo" width="100" height="100"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index">Home</a>
                </li>
                <!-- Add the Add Recipe link if the user is logged in -->
                <?php if (isset($_SESSION['user'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="addrecipe">Add Recipe</a>
                    </li>
                    <?php
                }
                if (isset($_SESSION['admin'])){?>
                    <li class="nav-item">
                        <a class="nav-link" href="addrecipe">Add Recipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageeditors" style="text-decoration: underline">Editor Management</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="aboutme"">About Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- Add login and signup links here -->
                <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) { ?>
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
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1>Homemade Recipe Editor Register Page</h1>
    <form action="registerUser" method="POST">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter a first name" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter a last name" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter a username" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter a password" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm the password" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Submit</button>
        <button type="submit" class="btn btn-outline-success" name="loginPage">Login Page</button>
    </form>
</div>


<?php require_once "./footer.php";?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

