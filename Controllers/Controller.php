<?php

include_once("Model/Model.php");
include_once("Views/Response.php");

class Controller {

    private $model;

    public function __construct() {
        $this->model = new Model(withErrors: true);
    }

    public function getCourses(): Response {

        $courses = $this->model->getCourses();

        return new Response(httpCode: 200, responseString: json_encode($courses));
    }
}

?>