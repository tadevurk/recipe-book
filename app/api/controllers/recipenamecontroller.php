<?php
require_once __DIR__ . '/../../services/recipenameservice.php';

class recipenamecontroller{
    private $recipeNameService;

    function __construct()
    {
        $this->recipeNameService = new RecipeNameService();
    }
    // router maps this to /api/recipename automatically
    public function index(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');

        // Respond to a POST request to /api/recipename
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // read JSON from the request, return as a string
            $body = file_get_contents('php://input');
            $object = json_decode($body);

            if (isset($object)){
                $recipeNames = $this->recipeNameService->getAllRecipeNames($object);
                header('Content-Type: application/json');
                // try get api end point code to check through insomnia
                echo json_encode($recipeNames);
            }
        }
    }
}
?>