<?php
require __DIR__ . '/../../services/ingredientservice.php';

class IngredientController{
    private $ingredientService;

    // initialize services
    function __construct()
    {
        $this->ingredientService = new IngredientService();
    }
        // router maps this to /api/ingredient automatically
        public function index(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');

            // Respond to a POST request to /api/ingredient
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // read JSON from the request, return as a string
                $body = file_get_contents('php://input');
                $object = json_decode($body);

                if (isset($object)){
                    $ingredients = $this->ingredientService->getAllByName($object);
                    header('Content-Type: application/json');
                    // try get api end point code to check through insomnia
                    echo json_encode($ingredients);
                }

            }
    }
}
?>