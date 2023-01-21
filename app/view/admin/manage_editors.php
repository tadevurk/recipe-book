<?php
session_start();

require_once __DIR__ . '/../../controllers/usercontroller.php';
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/role.php';

$usercontroller = new usercontroller();

// check if the user session variable is set
if (isset($_SESSION['admin'])) {
    $user = $_SESSION['admin'];
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

<!--CSS Style -->
<style>
table {
    width: 100%;
}
thead th {
    font-weight: bold;
}
tbody td {
    text-align: center;
}
@media only screen and (max-width: 600px) {
    thead {
        display: none;
    }
    tr:nth-of-type(2n) {
        background-color: inherit;
    }
    tr td:first-child {
        background: #f0f0f0;
        font-weight: bold;
        font-size: 1.3em;
    }
    tbody td {
        display: block;
        text-align: left;
    }
    tbody td:before {
        content: attr(data-th);
        font-weight: bold;
        display: block;
    }
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

<!--Table-->
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
                        <td data-th="User ID"><?php echo $editor->id; ?></td>
                        <td data-th="Name"><?php echo $editor->firstName; ?></td>
                        <td data-th="Last Name"><?php echo $editor->lastName; ?></td>
                        <td data-th="Username"><?php echo $editor->username; ?></td>
                        <?php if ($editor->role == 1){
                            ?><td>Editor</td><?php
                        }?>
                        <td>
                            <form action="deleteUser" method="POST">
                                <button type="submit" name="delete_user" value="<?=$editor->id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                <a href="updateUser?id=<?php echo $editor->id ?>" class="btn btn-primary">Update</a>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- Add Editors button -->
            <div class="row mt-3" style="padding-right: 9%; padding-bottom: 1%">
                <div class="col-12 text-right">
                    <a href="register" class="btn btn-success btn-lg">Add Editor</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once "./footer.php";?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

