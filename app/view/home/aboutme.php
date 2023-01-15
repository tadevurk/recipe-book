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
            <?php if (isset($_SESSION['user'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="addrecipe">Add Recipe</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="aboutme" style="text-decoration: underline">About Me</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav">
            <!-- Add login and signup links here -->
            <?php if (!isset($_SESSION['user'])) { ?>
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


<!--Footer position is fixed in the about me page-->
<footer class="bg-dark py-3" style="left: 0; bottom: 0; width: 100%;">
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