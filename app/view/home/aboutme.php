<?php
// Start the session
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="/Homemade.png" sizes="16x16" type="image/png">
    <link type="text/css" rel="stylesheet" href="styles.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Homemade Recipe</title>
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
                        <a class="nav-link" href="addrecipe" style="text-decoration: underline">Add Recipe</a>
                    </li>
                    <?php
                }
                if (isset($_SESSION['admin'])){?>
                    <li class="nav-item">
                        <a class="nav-link" href="addrecipe">Add Recipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageeditors">Editor Management</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="aboutme" style="text-decoration: underline">About Me</a>
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

<!-- Page Content -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
             <!--Add sidebar here-->
            <div class="sidebar bg-light p-3 mb-3">
                <!-- Add a profile picture here -->
                <img src="/photoAboutMe.jpg" alt="Profile Picture" class="img-fluid mb-3">
                <h3>Basic Information</h3>
                <ul class="list-unstyled">
                    <li>Name: Vedat</li>
                    <li>Surname: Türk</li>
                    <li>Student Number: 683343</li>
                    <li>School: InHolland University and Applied Sciences</li>
                    <li>Class: IT/2B</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <h1 class="text-center mb-5">About Me</h1>
            <!-- Add a short bio or introduction here -->
            <p> Hello, my name is Vedat, and I am currently in my second year at InHolland University and Applied Sciences, where I am studying software development and web design. I have always been passionate about creating and developing innovative software systems and websites, and in my spare time, I enjoy cooking and trying out new recipes.<br> <br>
                One of my passions is sharing my culinary creations with others, which is why I decided to create this website. On this site, you will find a collection of recipes that I have found and tried from various sources around the internet. I have also included some of my own original recipes that I have developed over the years. <br> <br>
                I hope that you will find something on this site that interests you and that you will enjoy my content. Thank you for taking the time to visit my site and I hope you come back again soon!</p>


        </div>
    </div>
</div>


<?php include 'footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>