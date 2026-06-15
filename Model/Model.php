<?php

class Model {

    private $db; 

    public function __construct(bool $withErrors = false) { 
        $this->db = new PDO("mysql:host=localhost;dbname=weba-te03-2026;charset=UTF8", "root", "root"); 

        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
    }

    public function getCourses(): array {
        $stmt = $this->db->prepare("SELECT id, name, deadline FROM course");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>