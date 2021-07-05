<?php

class User{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllUsers(){
        $this->db->query(
            "SELECT users.*, ud.first_name, ud.last_name, ud.birth_date, ud.gender 
            FROM users_data as ud, users 
            WHERE ud.user_id = users.id;"
        );
        
    }
}