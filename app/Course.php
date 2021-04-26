<?php
class Course
{
    private $db;

    public $course_id;
    public $user_id;
    public $course_name;
    public $course_code;
    public $course_desc;

    public $message = [
        'course_name' => '',
        'course_code' => '',
        'course_desc' => '',
        'success' => '',
    ];

    public function __construct($database)
    {
        $this->db = $database;
    }


    public function addCourse()
    {
        $this->course_name = $this->sanitize($this->course_name);
        $this->course_code = $this->sanitize($this->course_code);
        $this->course_desc = $this->sanitize($this->course_desc);

        if (empty($this->course_name)) {
            $this->message['course_name'] = 'This field is required';
        }

        if (empty($this->course_code)) {
            $this->message['course_code'] = 'This field is required';
        }

        if (empty($this->course_desc)) {
            $this->message['course_desc'] = 'This field is required';
        }

        if (empty($this->message['course_name']) && empty($this->message['course_code']) && empty($this->message['course_desc'])) {

            $this->db->query('INSERT INTO courses (name, user_id, code, description) VALUES(:name, :user_id, :code, :description)');

            $this->db->bind(':user_id', $this->user_id);
            $this->db->bind(':name', $this->course_name);
            $this->db->bind(':code', $this->course_code);
            $this->db->bind(':description', $this->course_desc);

            if ($this->db->execute()) {
                return true;
            }
        }
    }

    // Edits a course
    public function editCourse()
    {
        $this->course_id = $this->sanitize($this->course_id);
        $this->course_name = $this->sanitize($this->course_name);
        $this->course_code = $this->sanitize($this->course_code);
        $this->course_desc = $this->sanitize($this->course_desc);

        $this->db->query('UPDATE courses SET name = :name, code = :code, description = :description WHERE id = :id');

        $this->db->bind(':id', $this->course_id);
        $this->db->bind(':name', $this->course_name);
        $this->db->bind(':code', $this->course_code);
        $this->db->bind(':description', $this->course_desc);

        if ($this->db->execute()) {
            return true;
        }
    }

    // Deletes a course
    public function deleteCourse()
    {
        $this->db->query('DELETE FROM courses WHERE id = :id');
        $this->db->bind(':id', $this->course_id);
        if ($this->db->execute()) {
            return true;
        }
    }

    // Gets all courses added by a particular user
    public function getAllCourses()
    {
        $this->db->query('SELECT * FROM courses WHERE user_id = :user_id');
        $this->db->bind(':user_id', $this->user_id);
        $allCourses = $this->db->resultSet();
        return $allCourses;
    }

    // Gets data for a single course
    public function getOneCourse($id)
    {
        $this->db->query('SELECT * FROM courses WHERE id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }

    // 
    public function getUserByCourseId($id)
    {
        $this->db->query('SELECT user_id FROM courses WHERE id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }

    private function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}
