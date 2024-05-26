<?php
/* NOTE THAT THIS FILE IS SUBJECT TO REVIEW
IT IS ESSENTIALLY COPY PASTED FROM TUTORIALS YOU MUST REVIEW */
// Define your routes

class Router {
    private $routes = [
        'GET' => [
            '/Grading_Module' =>'initController@home',
            '/Grading_Module/menu' =>'initController@courses',
        
        ],
        'POST' => [
            '/Grading_Module/delete' => 'cashRegisterController@deleteItemFromCart',
            '/Grading_Module/add' => 'cashRegisterController@addToCart',
            '/Grading_Module/cancel' => 'cashRegisterController@cancelActiveBill',
           
        ],
    ];

    public function __construct() {
        $this->load();
    }

    public function load() {
        // Get the requested path and method from the request
        $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request_method = $_SERVER['REQUEST_METHOD'];

        // Get the item name and quantity from the request
        $itemName = $_POST['menuItemInput'] ?? null; // Use $_POST or another method to get the actual value
        $quantity = $_POST['quantityInput'] ?? null;

        // Determine the controller and action based on the path and method
        $defaultController = 'initController'; // Default controller
        $defaultAction = 'home'; // Default action

        // Iterate through the routes
        foreach ($this->routes[$request_method] ?? [] as $route => $handler) {
            $pattern = '#^' . str_replace('/', '\/', $route) . '$#';

            if (preg_match($pattern, $request_path, $matches)) {
                list($controller, $action) = explode('@', $handler);
                array_shift($matches);

                // Pass the actual item name and quantity
                $new_con = $this->getController($controller);
                $new_con->$action($itemName, $quantity);

                exit();
            }
        }

        // If no route matches, use the default route
        $def = $this->getController($defaultController);
        $def->$defaultAction();
        exit();
    }

    // Requires the controller so that we can use it
    private function getController($controller_name = "") {
        require __DIR__."/../controllers/".$controller_name.".php";
        return new $controller_name();
    }
}
