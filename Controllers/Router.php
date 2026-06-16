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

        if ($action === 'courses') {

            if ($method === 'GET' && isset($_GET['id'])) {
                return $controller->courseDetails($_GET['id']);
            }

            if ($method === 'GET' && $_GET['withExercises'] === 'true') {
                return $controller->coursesWithExercises();
            }
        }
        return null;
    }
}
?>