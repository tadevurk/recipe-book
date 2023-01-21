<?php
session_start();
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../controllers/usercontroller.php';

if (isset($_POST['updateUserButton'])) {
    $_SESSION['message'] = "Updated successfully";
}
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>


<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="/Homemade.png" sizes="16x16" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Homemade Recipe</title>
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
                    <a class="nav-link" href="manageEditors" style="text-decoration: underline">Editor Management</a>
                </li>
                <?php
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="aboutme">About Me</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact">Contact</a>
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

<form action="updateUser" method="POST">
    <div class="form-group">
        <label for="userID">User ID</label>
        <input type="text" class="form-control" id="userID" name="userID" value="<?php echo $user->id; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $user->firstName; ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $user->lastName; ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <input type="text" class="form-control" id="role" name="role" value="<?php if ($user->role == 1){
            ?> Editor <?php
        }?>" readonly>
    </div>
    <button type="submit" class="btn btn-primary" name="updateUserButton">Update User</button>
</form>

<?php require_once "./footer.php";?>

</body>
