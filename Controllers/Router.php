<?php
require_once("Views/Response.php");
require_once("Controllers/Controller.php");

class Router {

    public static function route(string $method, ?string $action): Response|null {

        if ($action == null) {
            return new Response(httpCode: 400, responseString: json_encode("Action required"));
        }

        $controller = new Controller();

        // TODO

        if($method === 'GET'){

            if($action === 'courses'){
                return $controller->courses();
            }
        }
        return null;
    }
}
?>