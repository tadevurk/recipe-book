<?php
// Start the session
session_start();

require_once __DIR__ . '/../../controllers/recipecontroller.php'; // TODO: delete this

$recipecontroller = new recipecontroller();
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
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index"><img src="/Homemade.png" alt="Logo" width="100" height="100"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index" style="text-decoration: underline">Home</a>
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
                        <a class="nav-link" href="manageeditors">Editor Management</a>
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

<div class="header-image" style="width: 100%; display: block">
    <img src="/recipe3.png" alt="Homemade Recipe Picture" style="width: 100%; height: auto;">
</div>

<!--Body of the page-->
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
                        $uniqueCuisines = array_unique(array_column($recipes,'cuisine'));
                        foreach ($uniqueCuisines as $cuisine)
                        {?>
                            <option value="<?=$cuisine?>"><?=$cuisine?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="filter-button">Filter</button>
            </form>
        </div>
        <div class="col-md-4">
            <form method="post" action=""">
                <div class="form-group">
                    <label for="recipeSearch">Search by Recipe Name:</label>
                    <input id="recipe-search" type="text" class="form-control" name="recipeName" list="suggestions-list" autocomplete="off">
                    <datalist id="suggestions-list"></datalist>
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
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $recipe_ingredients = $recipecontroller->getAllRecipeIngredients($recipe->id);
                                        foreach ($recipe_ingredients as $ingredient){?>
                                            <tr>
                                                <td><?= $ingredient['unit']?></td>
                                                <td><?= $ingredient['quantity']?></td>
                                                <td><?= $ingredient['name']?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h6 style="color: #17a2b8">Instructions:</h6>
                                    <p class="card-text"><?=nl2br($recipe->instructions)?></p>
                                </div>
                                <?php
                                // Check if the user is logged in
                                if (isset($_SESSION['user']) || isset($_SESSION['admin'])){
                                    // Display the update, delete, and add recipe buttons
                                    ?>
                                    <hr>
                                    <form action="deleteRecipe" method="POST">
                                        <!--<button type="submit" name="delete_recipe" value="<?php /*=$recipe->id;*/?>" class="btn btn-danger">Delete</button>-->
                                        <button type="submit" name="delete_recipe" value="<?=$recipe->id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</button>
                                        <a href="updateRecipe?id=<?php echo $recipe->id ?>" class="btn btn-primary">Update</a>
                                    </form>
                                    <?php
                                } ?>
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


<?php require_once "./footer.php";?>

<script>
    //Autocomplete
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    document.getElementById("recipe-search").addEventListener("keyup", debounce(function(e) {
        e.preventDefault()

            // Get the value of the form element
            const searchValue = e.target.value;

            if (searchValue){
                fetch('http://localhost/api/recipename', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(searchValue)
                })
                    .then(result=> result.json())
                    .then(items => {
                        let suggestionsList = document.getElementById("suggestions-list");
                        suggestionsList.innerHTML = "";
                        for (let recipe of items) {
                            let option = document.createElement("option");
                            option.value = recipe['name'];
                            suggestionsList.appendChild(option);
                        }
                    })
            }

    }, 200));
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>