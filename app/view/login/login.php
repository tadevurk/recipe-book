<?php
session_start();

// include the necessary files
require_once __DIR__ . '/../../controllers/authcontroller.php';
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/role.php';

// create a new instance of the authrepository
$authController = new authcontroller();

try {
    if (isset($_SESSION['admin'])) {
        header("Location: /home/manageeditors");
        exit();
    }

    if (isset($_SESSION['user'])) {
        header("Location: /home/recipe");
        exit();
    }

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

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="/Homemade.png"
                                         style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">Homemade Recipe</h4>
                                </div>

                                <form method="post">
                                    <p>Please login to your editor/admin account</p>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="username" class="form-control" />
                                        <label class="form-label" for="form2Example11">Username</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" class="form-control" />
                                        <label class="form-label" for="form2Example22">Password</label>
                                    </div>
                                        <input type="submit" name="login" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" value="Login" />
                                </form>
                                <?php
                                if(isset($message))
                                {
                                    echo '<label class="text-danger font-weight-bold">'.$message.'</label>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4" style="color: black">Welcome to Homemade Recipe</h4>
                                <p class="small mb-0" style="color: black">Welcome to the Homemade Recipe admin and editor portal.
                                    Here you can access and manage our collection of delicious and diverse recipes from all over the world.
                                    With our easy-to-use platform, you can add new recipes, and edit existing ones.
                                    Sign in to your account and start managing our recipe collection today!
                                </p>
                                <div class="text-center mt-3">
                                    <a href="recipe" class="btn btn-outline-secondary">Go to Homepage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #8BC34A;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, #8BC34A, #FDD835);

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, #8BC34A, #FDD835);
    }


    @media (min-width: 768px) {
        .gradient-form {
            height: 100vh !important;
        }
    }
    @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
    }
</style>
</body>
</html>
