<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once '../includes/db.php';
include_once '../models/course_model.php';

$courseModel = new CourseModel($conn);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
   case 'GET':
      if (isset($_GET['id'])) {
          echo json_encode($courseModel->getCourseById($_GET['id']));
      } else {
          echo json_encode($courseModel->getAllCourses());
      }
      break;

   case 'POST':
      // Add a new course with file uploads
      $data = json_decode(file_get_contents("php://input"), true);

      // Initialize paths for uploaded files
      if (isset($_FILES['course_image'])) {
          $data['image_path'] = handleFileUpload($_FILES['course_image'], '../admin/uploads/images/');
      }
      if (isset($_FILES['course_pdf'])) {
          $data['pdf_path'] = handleFileUpload($_FILES['course_pdf'], '../uploads/pdfs/');
      }
      if (isset($_FILES['course_video'])) {
          $data['video_path'] = handleFileUpload($_FILES['course_video'], '../uploads/videos/');
      }

      // Attempt to add the course
      if ($courseModel->addCourse($data)) {
          echo json_encode(['success' => true, 'message' => 'Course added successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to add course']);
      }
      break;

   case 'PUT':
      // Update an existing course
      parse_str(file_get_contents("php://input"), $_PUT); // Parse PUT data
      if ($courseModel->updateCourse($_PUT)) {
          echo json_encode(['success' => true, 'message' => 'Course updated successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to update course']);
      }
      break;

   case 'DELETE':
      if (isset($_GET['id']) && $courseModel->deleteCourse($_GET['id'])) {
          echo json_encode(['success' => true, 'message' => 'Course deleted successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to delete course']);
      }
      break;

   default:
      echo json_encode(['message' => 'Method not allowed']);
      break;
}

// Function to handle file uploads
function handleFileUpload($file, string $targetDir): ?string {
   if ($file['error'] === UPLOAD_ERR_OK) {
       if (!is_dir($targetDir)) {
           mkdir($targetDir, 0777, true); // Create directory if it doesn't exist
       }
       // Define target file path
       $targetFile = rtrim($targetDir, '/') . '/' . basename($file['name']);
       
       if (move_uploaded_file($file['tmp_name'], $targetFile)) {
           return $targetFile; // Return the path to the uploaded file
       } else {
           return null; // Return null if the file couldn't be moved
       }
   }
   return null; // Return null if there was an error or no file uploaded
}

?>
