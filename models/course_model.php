<?php

class CourseModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCourses() {
        $query = "SELECT * FROM courses";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $query = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Ensure ID is an integer
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCourse($data) {
        // Insert course data into the database including multimedia paths
        try {
            // Prepare the insert statement
            $query = "INSERT INTO courses (title, description, category_id, image_path, pdf_path, video_path) VALUES (:title, :description, :category_id, :image_path, :pdf_path, :video_path)";
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT); // Ensure category ID is an integer
            
            // Bind multimedia paths or set to null if not provided
            $imagePath = isset($data['image_path']) ? $data['image_path'] : null;
            $pdfPath = isset($data['pdf_path']) ? $data['pdf_path'] : null;
            $videoPath = isset($data['video_path']) ? $data['video_path'] : null;

            // Bind multimedia paths
            $stmt->bindParam(':image_path', $imagePath);
            $stmt->bindParam(':pdf_path', $pdfPath);
            $stmt->bindParam(':video_path', $videoPath);

            return $stmt->execute(); // Execute the statement and return success status

        } catch (PDOException $e) {
            // Log the error message for debugging (optional)
            error_log("Database error: " . $e->getMessage());
            return false; // Return false on error 
       }
   }

   public function updateCourse($data) {
       // Update course data including multimedia paths
       try {
           // Prepare the update statement
           $query = "UPDATE courses SET title = :title, description = :description, category_id = :category_id, image_path = :image_path, pdf_path = :pdf_path, video_path = :video_path WHERE id = :id";
           $stmt = $this->conn->prepare($query);

           // Bind parameters
           if (isset($data['title'], $data['description'], $data['category_id'], $data['id'])) {
               // Bind parameters
               $stmt->bindParam(':title', $data['title']);
               $stmt->bindParam(':description', $data['description']);
               $stmt->bindParam(':category_id', intval($data['category_id']));  // Ensure category ID is an integer
               
               // Handle multimedia paths
               $imagePath = isset($data['image_path']) ? $data['image_path'] : null;
               $pdfPath = isset($data['pdf_path']) ? $data['pdf_path'] : null;
               $videoPath = isset($data['video_path']) ? $data['video_path'] : null;

               // Bind multimedia paths
               $stmt->bindParam(':image_path', $imagePath);
               $stmt->bindParam(':pdf_path', $pdfPath);
               $stmt->bindParam(':video_path', $videoPath);
               
               // Bind ID for the update
               $stmt->bindParam(':id', intval($data['id']));  // Ensure ID is an integer

               return $stmt->execute(); 
           }
           
           return false; // Return false if required fields are not set

       } catch (PDOException $e) {
           error_log("Database error: " . $e->getMessage());
           return false; 
       }
   }

   public function deleteCourse($id) {
       try {
           if (!is_numeric($id)) {
               return false; // Ensure ID is numeric before proceeding
           }
           
           // Delete course by ID
           $query = "DELETE FROM courses WHERE id = :id";
           $stmt = $this->conn->prepare($query); 
           
           // Bind ID parameter safely
           $stmt->bindParam(':id', intval($id)); 

           return $stmt->execute(); 
       } catch (PDOException $e) {  
           error_log("Database error: " . $e->getMessage());  
           return false; 
       }
   }
}
?>
