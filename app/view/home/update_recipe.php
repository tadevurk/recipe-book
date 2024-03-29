<?php
session_start();
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

<form action="updateRecipe" method="POST">
    <div class="form-group">
        <label for="recipeID">Recipe ID</label>
        <input type="text" class="form-control" id="recipeID" name="recipeID" value="<?php echo $recipe->id; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="recipeCuisine">Cuisine</label>
        <input type="text" class="form-control" id="recipeCuisine" name="recipeCuisine" value="<?php echo $recipe->cuisine; ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="recipeName">Recipe Name</label>
        <input type="text" class="form-control" id="recipeName" name="recipeName" value="<?php echo $recipe->name; ?>" autocomplete="off">
    </div>
    <div class="form-group" id="ingredients">
        <label>Ingredients</label>
        <?php
        foreach ($recipe_ingredients as $key => $ingredient) {
            ?>
            <div class="input-group mb-3" id="ingredient-group-<?=$key?>">
                <input type="text" class="form-control ingredient-input" placeholder="Ingredient" name="ingredient[]" id="ingredient-<?=$key?>" list="suggestions-list-<?=$key?>" autocomplete="off" value="<?= $ingredient['name'] ?>">
                <datalist id="suggestions-list-<?=$key?>"></datalist>
                <input type="text" class="form-control" placeholder="Unit" name="unit[]" id="unit-0" value="<?= $ingredient['unit'] ?>">
                <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-0" value="<?= $ingredient['quantity'] ?>">
                <button type="button" class="btn btn-danger" id="delete-<?=$key?>">Delete</button>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="input-group-append">
        <button class="btn btn-outline-success" type="button" id="add-ingredient-button">Add Ingredient</button>
    </div>
    <div class="form-group">
        <label for="recipeInstructions">Instructions</label>
        <textarea class="form-control" id="recipeInstructions" name="recipeInstructions" style="height: 200px"><?php echo $recipe->instructions ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="updateRecipeButton">Update Recipe</button>
</form>

<?php require_once "./footer.php";?>

<script>
    let id_number = 0;
    const addIngredientButton = document.getElementById('add-ingredient-button');

    addIngredientButton.addEventListener('click', function() {
        const ingredients = document.getElementById("ingredients").children
        const lastIndex = ingredients.length - 1;
        const lastElement = ingredients[lastIndex];
        id_number = lastElement.id.split('-')[2];

        const ingredientGroup = ingredients.namedItem(`ingredient-group-${id_number}`)
        const newIngredientGroup = ingredientGroup.cloneNode(true);
        const delete_buttons = newIngredientGroup.getElementsByTagName('button')
        const inputs = newIngredientGroup.getElementsByTagName("input");
        id_number++

        delete_buttons[0].id = `${delete_buttons[0].id.split('-')[0]}-${id_number}`
        delete_buttons[0].addEventListener("click", function(event) {
            const delete_button_id = event.target.id
            const parent = document.getElementById(delete_button_id).parentNode
            parent.parentNode.removeChild(parent)
        });

        for (let i=0; i<inputs.length; i++){
            inputs[i].value = "";

            let id_name = inputs[i].id.split('-')[0];
            inputs[i].id = `${id_name}-${id_number.toString()}`;

            if(inputs[i].hasAttribute("list")){
                const datalist = newIngredientGroup.childNodes.item(3);
                const id_name = `${datalist.id.split('-')[0]}-${datalist.id.split('-')[1]}`;

                datalist.innerHTML = "";

                datalist.id = `${id_name}-${id_number.toString()}`;
                inputs[i].setAttribute("list", datalist.id);
            }
            const groupName = `${newIngredientGroup.id.split('-')[0]}-${newIngredientGroup.id.split('-')[1]}`
            newIngredientGroup.id = `${groupName}-${id_number}`
            ingredientGroup.parentNode.appendChild(newIngredientGroup);
        }
    });

    //Autocomplete
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    document.getElementById("ingredients").addEventListener("keyup", debounce(function(e) {
        e.preventDefault()
        if (e.target.id.startsWith("ingredient-")) {
            // Get the value of the form element
            const ingredient = e.target.value;
            const id_number = e.target.id.split("-")[1];
            if (ingredient){
                fetch('http://localhost/api/ingredient', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(ingredient)
                })
                    .then(result=> result.json())
                    .then(items => {
                        let suggestionsList = document.getElementById(`suggestions-list-${id_number.toString()}`);
                        console.log(id_number)
                        suggestionsList.innerHTML = "";
                        for (let ingredient of items) {
                            let option = document.createElement("option");
                            option.value = ingredient['name'];
                            option.setAttribute("data-value",  ingredient['id']);
                            suggestionsList.appendChild(option);
                        }
                    })
            }
        }
    }, 200));

    const ingredients = document.getElementById("ingredients");
    const deleteButtons = ingredients.querySelectorAll(".btn-danger");

    deleteButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            const delete_button_id = event.target.id
            const parent = document.getElementById(delete_button_id).parentNode
            ingredients.removeChild(parent);
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>