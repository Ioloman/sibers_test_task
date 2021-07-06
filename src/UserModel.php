<?php

/**
 * class that incapsulates all the database actions
 */
class UserModel{
    /**
     * Database object
     *
     * @var Database
     */
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * method to fetch users depending on passed parameters such as order and pagination
     * returns array of object with fields that correspond to database fields
     *
     * @param array $params
     * @return array(object)
     */
    public function getUsers($params){
        // amount of entries needed
        $show = isset($params['show']) ? $params['show'] : 10;
        // default order values
        $orderBy = 'users.created_at';
        $direction = 'DESC';
        // offset - equivalent of page number
        $offset = isset($params['offset']) ? strval($params['offset']).',' : '';
        // custom order params
        if (isset($params['direction'])){
            $direction = $params['direction'];
            $orderBy = $params['orderBy'];
        }
        // the query itself
        $this->db->query(
            "SELECT users.*, ud.first_name, ud.last_name, ud.birth_date, ud.gender, roles.role
            FROM users_data as ud, users, roles 
            WHERE ud.user_id = users.id AND users.role_id = roles.id
            ORDER BY $orderBy $direction
            LIMIT $offset$show;"
        );

        return $this->db->results();
    }

    /**
     * method fetches amount of entries in the database
     *
     * @return object
     */
    public function getAmount(){
        $this->db->query(
            "SELECT COUNT(*) as total
            FROM users_data as ud, users, roles 
            WHERE ud.user_id = users.id AND users.role_id = roles.id;"
        );

        return $this->db->result();
    }

    /**
     * method that fetches all the users' roles from database
     *
     * @return array(object)
     */
    public function getRoles(){
        $this->db->query(
            "SELECT *
            FROM roles;"
        );

        return $this->db->results();
    }

    /**
     * method that creates a new user in the database
     * returns user's id if user is created successfully
     * returns false otherwise
     *
     * @param array $data
     * @return boolean|int
     */
    public function createUser($data){
        $this->db->query(
            "INSERT INTO users (login, password, role_id)
            VALUES (:login, :password, :role_id);"
        );

        // bind data to query
        $this->db->bind(':login', $data['login']);
        $this->db->bind(':password', md5($data['password']));
        $this->db->bind(':role_id', $data['role']);
        
        if ($this->db->execute()){
            // if executed successfully return id
            $this->db->query("SELECT LAST_INSERT_ID() as id;");
            return $this->db->result()->id;
        } else 
            return false;
    }

    /**
     * method to add user's data to users_data table
     *
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function addUserData($id, $data){
        $this->db->query(
            "INSERT INTO users_data (first_name, last_name, birth_date, gender, user_id)
            VALUES (:first_name, :last_name, :birth_date, :gender, $id);"
        );

        // bind data to query
        $this->db->bind(':first_name', isset($data['first_name']) ? $data['first_name'] : null);
        $this->db->bind(':last_name', isset($data['last_name']) ? $data['last_name'] : null);
        $this->db->bind(':birth_date', isset($data['birth_date']) ? $data['birth_date'] : null);
        $this->db->bind(':gender', isset($data['gender']) ? $data['gender'] : null);
        
        if ($this->db->execute()){
            return true;
        } else 
            return false;
    }

    /**
     * method fetches user with given id
     * and returns user object with fields that correspond to database fields
     *
     * @param int $id
     * @return object
     */
    public function getUser($id){
        $this->db->query(
            "SELECT users.*, ud.first_name, ud.last_name, ud.birth_date, ud.gender, roles.role
            FROM users_data as ud, users, roles 
            WHERE users.id = $id AND ud.user_id = users.id AND users.role_id = roles.id;"
        );

        return $this->db->result();
    }

    /**
     * method that deletes users with given id
     * returns true if successful
     *
     * @param int $id
     * @return boolean
     */
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

    /**
     * method that updates user with given id
     * all the data comes in single array
     * returns true if successful
     *
     * @param array $data
     * @return boolean
     */
    public function updateUser($data){
        // prepare required fields that cannot be nullified
        $set = '';
        $set .= isset($data['login']) ? 'u.login = "'.$data['login'].'",' : '';
        $set .= isset($data['password']) ? 'u.password = "'.md5($data['password']).'",' : '';
        $set .= isset($data['role']) ? 'u.role_id = '.$data['role'].',' : '';

        $this->db->query(
            "UPDATE users as u, users_data as ud
            SET $set ud.first_name = :first_name, ud.last_name = :last_name, ud.birth_date = :birth_date, ud.gender = :gender
            WHERE u.id = :id AND ud.user_id = u.id;"
        );

        // bind optional fields
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

    /**
     * method that fetches users with given credentials
     * if successful and user is admin modifies session
     *
     * @param [type] $credentials
     * @return boolean
     */
    public function login($credentials){
        $this->db->query(
            "SELECT *
            FROM users
            WHERE login = :login AND password = :password;"
        );

        $this->db->bind(':login', $credentials['login']);
        $this->db->bind(':password', md5($credentials['password']));

        // fetch user
        $result =  $this->db->result();

        // if users successfully fetched and role is admin - authenticate user
        // return true if successful false otherwise
        if ($result->role_id == 2){
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_data'] = [
                'id' => $result->id,
                'login' => $result->login
            ];
            return true;
        } else 
            return false;
    }

    /**
     * method to logout user
     * destroys session
     *
     */
    public function logout(){
        unset($_SESSION['user_data']);
        unset($_SESSION['is_logged_in']);
        session_destroy();
    }
}