<?php
// Start the session
session_start();

if (isset($_POST['updateRecipeButton'])) {
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
                <a class="nav-link" href="recipe" style="text-decoration: underline">Recipes</a>
            </li>
            <!-- Add the Add Recipe link if the user is logged in -->
            <?php if (isset($_SESSION['user'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="addrecipe">Add Recipe</a>
                </li>
            <?php } ?>
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

<form action="updateRecipe" method="POST">
    <div class="form-group">
        <label for="recipeID">Recipe ID</label>
        <input type="text" class="form-control" id="recipeID" name="recipeID" value="<?php echo $recipe->id; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="recipeCuisine">Cuisine</label>
        <input type="text" class="form-control" id="recipeCuisine" name="recipeCuisine" value="<?php echo $recipe->cuisine; ?>">
    </div>
    <div class="form-group">
        <label for="recipeName">Recipe Name</label>
        <input type="text" class="form-control" id="recipeName" name="recipeName" value="<?php echo $recipe->name; ?>">
    </div>
    <div class="form-group">
        <label for="recipeInstructions">Instructions</label>
        <textarea class="form-control" id="recipeInstructions" name="recipeInstructions" style="height: 200px"><?php echo $recipe->instructions ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="updateRecipeButton">Update Recipe</button>
</form>

<!--Footer-->
<footer class="bg-dark py-3" style="left: 0; bottom: 0; width: 100%; margin-top: 20px;">
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