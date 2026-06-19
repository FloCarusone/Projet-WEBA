<?php

include_once("Model/Model.php");
include_once("Views/Response.php");

class Controller {

    private $model;

    public function __construct() {
        $this->model = new Model(withErrors: true);
    }

    public function courses(): Response {

        $courses = $this->model->courses();

        return new Response(httpCode: 200, responseString: json_encode($courses));
    }

    public function coursesWithExercises(): Response {

        $courses = $this->model->coursesWithExercises();
        
        return new Response(httpCode: 200, responseString: json_encode($courses));
    }


    //fonction pour afficher les détails du cours 1
     public function courseDetails($id): Response {
        
        if ($id === null) {
            return new Response(httpCode: 400, responseString: json_encode("ID invalide"));
        }
        
        $course = $this->model->courseById($id);

        if ($course === null) {
            return new Response(httpCode: 404, responseString: json_encode("Cours non trouvé"));
        }

        return new Response(httpCode: 200, responseString: json_encode($course));
    }


    public function addNewCourse(): Response {
        // Données envoyées en formdata → on lit $_POST, pas le body JSON
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            return new Response(httpCode: 400, responseString: json_encode("Le nom est requis"));
        }

        $name = $_POST['name'];
        $deadline = $_POST['deadline'] ?? null;

        $newId = $this->model->addNewCourse($name, $deadline);

        return new Response(httpCode: 201, responseString: json_encode(["id" => $newId]));
    }


    public function deleteCourse($id): Response {
        if ($id === null) {
            return new Response(httpCode: 400, responseString: json_encode("ID invalide"));
        }

        $deleted = $this->model->deleteCourse($id);

        if (!$deleted) {
            return new Response(httpCode: 404, responseString: json_encode("Cours non trouvé"));
        }

        return new Response(httpCode: 200, responseString: json_encode("Cours supprimé"));
    }




}

?>