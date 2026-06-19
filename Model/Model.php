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


    public function courseById(int $id): array|null {
        $stmt = $this->db->prepare("SELECT id, name, deadline FROM course WHERE id = ?");
        $stmt->execute([$id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$course) {
            return null;
        }

        $stmt2 = $this->db->prepare(
            "SELECT id, name, description, finished FROM exercise WHERE courseId = ?"
        );
        $stmt2->execute([$id]);

        $exercises = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $course['exercises'] = $exercises;

        return $course;
    }

    public function addNewCourse(string $name, ?string $deadline): int {
        $stmt = $this->db->prepare("INSERT INTO course (name, deadline) VALUES (?, ?)");
        $stmt->execute([$name, $deadline]);
        return (int) $this->db->lastInsertId();
    }

    public function deleteCourse(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM course WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }


     public function lateCourses(): array {
        $stmt = $this->db->prepare(
            "SELECT c.id, c.name, c.deadline,
                    COUNT(e.id) AS remaining_exercises
             FROM course c
             LEFT JOIN exercise e ON e.courseId = c.id AND e.finished = 0
             WHERE c.deadline < NOW()
             GROUP BY c.id, c.name, c.deadline"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>