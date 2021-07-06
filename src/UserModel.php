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

        return $this->db->results();
    }
}