<?php

class CourseController {

    private CourseModel $courseModel;

    public function __construct(CourseModel $courseModel) {
        $this->courseModel = $courseModel;
    }

    public function index() { 
        return json_encode($this->courseModel->getAllCourses());
    }
    
    public function show(int $id) { 
        return json_encode($this->courseModel->getCourseById($id));
    }
    
    public function store(array $request) { 
        // Validate required fields
        if (empty($request['title']) || empty($request['description']) || empty($request['category_id'])) {
            return json_encode(['success' => false, 'message' => 'Missing required fields']);
        }

        // Attempt to add the course
        if ($this->courseModel->addCourse($request)) {
            return json_encode(['success' => true, 'message' => 'Course added successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to add course']);
        }
    }
    
    public function update(array $request, int $id) { 
        // Ensure ID is provided in the request
        if (empty($id)) {
            return json_encode(['success' => false, 'message' => 'Invalid course ID']);
        }

        // Attempt to update the course
        if ($this->courseModel->updateCourse(array_merge($request, ['id' => $id]))) {
            return json_encode(['success' => true, 'message' => 'Course updated successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update course']);
        }
    }
    
    public function destroy(int $id) { 
        // Ensure ID is provided
        if (empty($id)) {
            return json_encode(['success' => false, 'message' => 'Invalid course ID']);
        }

        // Attempt to delete the course
        if ($this->courseModel->deleteCourse($id)) {
            return json_encode(['success' => true, 'message' => 'Course deleted successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to delete course']);
        }
    }
}
?>
