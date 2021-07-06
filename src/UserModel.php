<?php

class UserModel{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUsers($params){
        $show = isset($params['show']) ? $params['show'] : 10;
        $orderBy = 'users.created_at';
        $direction = 'DESC';
        $offset = isset($params['offset']) ? strval($params['offset']).',' : '';
        if (isset($params['direction'])){
            $direction = $params['direction'];
            $orderBy = $params['orderBy'];
        }
        $this->db->query(
            "SELECT users.*, ud.first_name, ud.last_name, ud.birth_date, ud.gender, roles.role
            FROM users_data as ud, users, roles 
            WHERE ud.user_id = users.id AND users.role_id = roles.id
            ORDER BY $orderBy $direction
            LIMIT $offset$show;"
        );

        return $this->db->results();
    }

    public function getAmount(){
        $this->db->query(
            "SELECT COUNT(*) as total
            FROM users_data as ud, users, roles 
            WHERE ud.user_id = users.id AND users.role_id = roles.id;"
        );

        return $this->db->result();
    }

    public function getRoles(){
        $this->db->query(
            "SELECT *
            FROM roles;"
        );

        return $this->db->results();
    }

    public function createUser($data){
        $this->db->query(
            "INSERT INTO users (login, password, role_id)
            VALUES (:login, :password, :role_id);"
        );

        $this->db->bind(':login', $data['login']);
        $this->db->bind(':password', md5($data['password']));
        $this->db->bind(':role_id', $data['role']);
        
        if ($this->db->execute()){
            $this->db->query("SELECT LAST_INSERT_ID() as id;");
            return $this->db->result()->id;
        } else 
            return false;
    }

    public function addUserData($id, $data){
        $this->db->query(
            "INSERT INTO users_data (first_name, last_name, birth_date, gender, user_id)
            VALUES (:first_name, :last_name, :birth_date, :gender, $id);"
        );

        $this->db->bind(':first_name', isset($data['first_name']) ? $data['first_name'] : null);
        $this->db->bind(':last_name', isset($data['last_name']) ? $data['last_name'] : null);
        $this->db->bind(':birth_date', isset($data['birth_date']) ? $data['birth_date'] : null);
        $this->db->bind(':gender', isset($data['gender']) ? $data['gender'] : null);
        
        if ($this->db->execute()){
            return true;
        } else 
            return false;
    }

    public function getUser($id){
        $this->db->query(
            "SELECT users.*, ud.first_name, ud.last_name, ud.birth_date, ud.gender, roles.role
            FROM users_data as ud, users, roles 
            WHERE users.id = $id AND ud.user_id = users.id AND users.role_id = roles.id;"
        );

        return $this->db->result();
    }

    public function deleteUser($id){
        $this->db->query(
            "DELETE u, ud 
            FROM users as u
            JOIN users_data as ud ON u.id = ud.user_id
            WHERE u.id = $id;"
        );
        
        if ($this->db->execute()){
            return true;
        } else 
            return false;
    }

    public function updateUser($data){
        $set = '';
        $set .= isset($data['login']) ? 'u.login = "'.$data['login'].'",' : '';
        $set .= isset($data['password']) ? 'u.password = "'.md5($data['password']).'",' : '';
        $set .= isset($data['role']) ? 'u.role_id = '.$data['role'].',' : '';

        $this->db->query(
            "UPDATE users as u, users_data as ud
            SET $set ud.first_name = :first_name, ud.last_name = :last_name, ud.birth_date = :birth_date, ud.gender = :gender
            WHERE u.id = :id AND ud.user_id = u.id;"
        );

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', isset($data['first_name']) ? $data['first_name'] : null);
        $this->db->bind(':last_name', isset($data['last_name']) ? $data['last_name'] : null);
        $this->db->bind(':birth_date', isset($data['birth_date']) ? $data['birth_date'] : null);
        $this->db->bind(':gender', isset($data['gender']) ? $data['gender'] : null);

        if ($this->db->execute()){
            return true;
        } else 
            return false;
    }
}