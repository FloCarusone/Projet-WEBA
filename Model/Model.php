<?php

class Model {

    private $db; 

    public function __construct(bool $withErrors = false) { 
        $this->db = new PDO("mysql:host=localhost;dbname=weba-te03-2026;charset=UTF8", "root", "root"); 

        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
    }

    public function courses(): array {
        $stmt = $this->db->prepare("SELECT id, name, deadline FROM course");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function coursesWithExercises(): array {
        $stmt = $this->db->prepare("SELECT id, name, deadline FROM course");
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($courses as &$course) {
            $stmt2 = $this->db->prepare(
                "SELECT id, name, description, finished FROM exercise WHERE courseId = ?"
            );
            $stmt2->execute([$course['id']]);
            $course['exercises'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        }

        return $courses;
    }
}
?>