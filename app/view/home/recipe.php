<?php
// Start the session
session_start();

require_once __DIR__ . '/../../repository/reciperepository.php';

$recipeRepository = new reciperepository();
if (isset($_POST['delete_recipe'])) {
    $_SESSION['message'] = "Deleted successfully";
}

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

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI library -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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

<div class="container mt-5">
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <form method="post" action="">
                <div class="form-group">
                    <label for="cuisineSelect">Filter by Cuisine:</label>
                    <select class="form-control" id="cuisineSelect" name="cuisine">
                        <option value="">All</option>
                        <?php
                        // Get the unique cuisines from the repository
                        foreach ($recipes as $recipe)
                        {?>
                            <option value="<?=$recipe->cuisine?>"><?=$recipe->cuisine?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="filter-button">Filter</button>
            </form>
        </div>
        <div class="col-md-4">
            <form method="post" action="">
                <div class="form-group">
                    <label for="recipeSearch">Search by Recipe Name:</label>
                    <input id="recipe-search" type="text" class="form-control" name="recipeName">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <div class="row mt-5">
        <?php
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter the recipes based on the selected cuisine or search term
            $filteredRecipes = array_filter($recipes, function($recipe) {
                if (isset($_POST['cuisine']) && !empty($_POST['cuisine'])) {
                    return $recipe->cuisine == $_POST['cuisine'];
                }
                if (isset($_POST['recipeName']) && !empty($_POST['recipeName'])) {
                    return stristr($recipe->name, $_POST['recipeName']);
                }
                return true;
            });
        } else {
            // If the form has not been submitted, display all recipes
            $filteredRecipes = $recipes;
        }?>


        <div class="container mt-5">
            <div class="row">
                <?php
                foreach ($filteredRecipes as $recipe)
                {?>
                    <div class="col-md-6">
                        <div class="card mb-3" style="width: auto;">
                            <div class="card-header">
                                <h5 class="card-title" style="color: #17a2b8;">Recipe Name: <?=$recipe->name?></h5>
                                <p class="card-text">Cuisine: <em><?=$recipe->cuisine?></em></p>
                            </div>

                            <div class="card-body">
                                <div class="col-md-8">
                                    <h6 style="color: #17a2b8">Ingredients:</h6>
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        $recipe_ingredients = $recipeRepository->getAllRecipeIngredients($recipe->id);
                                        foreach ($recipe_ingredients as $ingredient){?>
                                            <li class="list-group-item"><?= $ingredient['name']?></li>
                                            <li class="list-group-item"><?= $ingredient['quantity']?></li>
                                            <li class="list-group-item"><?= $ingredient['unit']?></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <h6 style="color: #17a2b8">Instructions:</h6>
                                    <p class="card-text"><?=nl2br($recipe->instructions)?></p>
                                </div>
                                <?php
                                // Check if the user is logged in
                                if (isset($_SESSION['user'])){
                                    // Display the update, delete, and add recipe buttons
                                    ?>
                                    <hr>
                                    <form action="deleteRecipe" method="POST">
                                        <button type="submit" name="delete_recipe" value="<?=$recipe->id;?>" class="btn btn-danger">Delete</button>
                                        <a href="updateRecipe?id=<?php echo $recipe->id ?>" class="btn btn-primary">Update</a>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>


<!--Footer-->
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