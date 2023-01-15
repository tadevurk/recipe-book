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
}
else{
    header("location:login");
    session_destroy();
}?>

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
                    <a class="nav-link" href="manageEditors" style="text-decoration: underline">Editor Management</a>
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

<style>
    .container-fluid {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 30px;
    }
    .table {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
    }
    .btn {
        border-radius: 10px;
        box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
    }
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1.25rem;
        border-radius: 0.3rem;
    }
</style>

<div class="container-fluid">
    <h1 class="text-center mt-3">Manage Editors</h1>
    <div class="row mt-3">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- Display a table row for each editor -->
                <?php foreach ($editors as $editor) { ?>
                    <tr>
                        <td><?php echo $editor->id; ?></td>
                        <td><?php echo $editor->firstName; ?></td>
                        <td><?php echo $editor->lastName; ?></td>
                        <td><?php echo $editor->username; ?></td>
                        <?php if ($editor->role == 1){
                            ?><td>Editor</td><?php
                        }?>
                        <td>
                            <form action="deleteUser" method="POST">
                                <button type="submit" name="delete_user" value="<?=$editor->id;?>" class="btn btn-danger">Delete</button>
                                <a href="updateUser?id=<?php echo $editor->id ?>" class="btn btn-primary">Update</a>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- Add Editors button -->
            <div class="row mt-3">
                <div class="col-12 text-right">
                    <a href="register" class="btn btn-success btn-lg">Add Editor</a>
                </div>
            </div>
        </div>
    </div>
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

