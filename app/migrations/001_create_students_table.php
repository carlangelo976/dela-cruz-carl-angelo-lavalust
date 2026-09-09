<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Migration_create_students_table extends Migration {
    public function up() {
        $this->db->query("
            CREATE TABLE students ( 
                id INT AUTO_INCREMENT PRIMARY KEY, 
                name VARCHAR(100), 
                course VARCHAR(100), 
                age INT, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
            )
        ");
    }

    public function down() {
        $this->db->query("DROP TABLE students");
    }
}