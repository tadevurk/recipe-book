<?php
session_start();

// include the necessary files
require_once __DIR__ . '/../../controllers/authcontroller.php';
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/role.php';

// create a new instance of the authrepository
$authController = new authcontroller();

try {
    if (isset($_POST["registerNewUser"])){
        header("location:register");
    }

    if (isset($_POST["login"])){
        //retrieve the login data, remove the white space with trim
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        // check the login
        $loggedInUser = $authController->checkLogin($username, $password);
        if ($loggedInUser) {
            if ($loggedInUser->role === role::Admin){
                $_SESSION['admin'] =  $loggedInUser;
                $_SESSION['adminID'] = $loggedInUser->id;
                $_SESSION['role'] = $loggedInUser->role;
                $_SESSION['lastname'] = $loggedInUser->lastName;
                header("location:manageEditors");
            }
            if ($loggedInUser->role === role::Editor){
                $_SESSION['user'] =  $loggedInUser;
                $_SESSION['userID'] = $loggedInUser->id;
                $_SESSION['lastname'] = $loggedInUser->lastName;
                header("location:recipe");
            }
            return $loggedInUser;
        } else {
            // login failed
            $message =  "Invalid username or password";
        }
    }
}catch (PDOException $error){
    $message =$error->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="/Homemade.png" sizes="16x16" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Homemade Recipe Login</title>
</head>
<body>
<br />
<div class="container mt-5" style="width:500px;">
    <div class="card">
        <div class="card-header">
            <h3>Homemade Recipe Login Page</h3>
        </div>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" class="form-control" />
            <br />
            <label>Password</label>
            <input type="password" name="password" class="form-control" />
            <br />
            <input type="submit" name="login" class="btn btn-outline-success" value="Login" />
        </form>
    </div>

   <?php
    if(isset($message))
    {
        echo '<label class="text-danger">'.$message.'</label>';
    }
    ?>
</div>
<br />

</body>
</html>
