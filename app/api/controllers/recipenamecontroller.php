<?php
require __DIR__ . '/../../services/recipenameservice.php';

class RecipeNameController{
    private $recipeNameService;

    // initialize services
    function __construct()
    {
        $this->recipeNameService = new RecipeNameService();
    }

    // router maps this to /api/article automatically
    public function index(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');

        // Respond to a POST request to /api/article
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // read JSON from the request, return as a string
            $body = file_get_contents('php://input');
            $object = json_decode($body);

            if (isset($object)){
                $recipeNames = $this->recipeNameService->getAllRecipeByName($object);
                header('Content-Type: application/json');
                // try get api end point code to check through insomnia
                echo json_encode($recipeNames);
            }
        }

    }

}
?>