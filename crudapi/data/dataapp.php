<?php

/**
 * Class to handle all Mobile App db operations
 * This class will have CRUD methods for database tables
 *
 */

class dataApp {

    private $conn;
    private $db;

    function __construct() {
		require_once 'dataconnect.php';
        // opening db connection
        $this->db = new clsDataConnect();
        $this->conn = $this->db->connect();
    }
	
	public function disconnect(){
		$this->db->disconnect();
	}

	/**
     * Fetching all users
     * @return Array $users
     */
    public function getUsers() {
		$users = array();
    	$sql = "SELECT id, name, email, phone, created FROM users"; 
		$stmt = $this->conn->prepare($sql);
		
		if ($stmt->execute()) {
			$stmt->bind_result($id, $name, $email, $phone, $created);
			$cnt = 0;
			while($stmt->fetch()){
				$users[$cnt]['user_id'] = $id;
				$users[$cnt]['name'] = $name;
				$users[$cnt]['email'] = $email;
				$users[$cnt]['phone'] = $phone;
				$users[$cnt]['created'] = $created;
				$cnt++;
			}
			$stmt->close();
		}
		return $users;
    }
	
	/**
     * Fetching user details
     * @param Int $user_id
     */
    public function getUserDetails($user_id) {
	
        if(empty($user_id)) {
    		return FALSE;
        }
		
		$details = array();
        
        $sql = "SELECT id, name, email, phone, created FROM users WHERE id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $user_id);
		if ($stmt->execute()) {
			$stmt->bind_result($user_id,$name,$email,$phone,$created);
			if ($stmt->fetch()){
				$details = array(
						'user_id' => $user_id,
						'name' => $name,
						'email' => $email,
						'phone' => $phone,
						'created' => $created
				);
				$stmt->close();
			}
			return $details;
		}
		
    }// EO getUserDetails($user_id)
	
    /**
     * Creating new user
     * @param Array $details
    */
    public function registerUser($details) {
        if(empty($details['email']) || empty($details['phone'])) {
    		return array('result' => FALSE, 'error' => 'Missing Parameters');
    	}
		
		$name		=	!empty($details['name']) ? mysqli_real_escape_string($this->conn, $details['name']) : '';
		$email		=	mysqli_real_escape_string($this->conn, $details['email']);
		$phone		=	mysqli_real_escape_string($this->conn, $details['phone']);
		$created 	= 	date("Y-m-d H:i:s");
		
		// First check if user already exists in db
        $existing_user = $this->checkExistingUser($email,$phone);
		if ($existing_user === FALSE) {
        	// insert query
			$sql = "INSERT INTO users (name, email, phone, created) values(?, ?, ?, ?)";
			$stmt = $this->conn->prepare($sql);
			$bind = $stmt->bind_param("ssss", $name, $email, $phone, $created);
			$result = $stmt->execute();
			$stmt->close();
            
	    	// Check for successful insertion/updation
	    	if ($result) {
	    		// User created
	    		$user_id = $this->conn->insert_id;
	    		
	    		// User successfully created
	    		return array('result' => TRUE, 'user_id' => $user_id);
	    	}
	    	return array('result' => FALSE, 'error' => 'Internal Server Error');
	    	
        } else {
            // User with same email/phone already exists in db
			return array('result' => FALSE, 'error' => 'User already exists');
        }
    }

	/**
     * Updating user details
     * @param Int $user_id User id
     * @param Array $details User details
     */
    public function updateUserDetails($user_id, $details) {
    	if(empty($user_id) || empty($details['email']) || empty($details['phone'])) {
    		return array('result' => FALSE, 'error' => 'Missing Parameters');
    	}
    	
		$userdetails = $this->getUserDetails($user_id);
		if(empty($userdetails)) {
			return array('result' => FALSE, 'error' => 'No records');
		}
		
    	$name  = !empty($details['name']) ? mysqli_real_escape_string($this->conn, $details['name']) : '';
    	$email = mysqli_real_escape_string($this->conn, $details['email']);
    	$phone = mysqli_real_escape_string($this->conn, $details['phone']);
    
		// First check if user already exists in db
        /*$existing_user = $this->checkExistingUser($email,$phone);
		if ($existing_user === FALSE) {*/
			$sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
			$stmt = $this->conn->prepare($sql);
			$bind = $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
			$result = $stmt->execute();
			$stmt->close();
		
			if ($result) {
				return array('result' => TRUE);
			}
			return array('result' => FALSE, 'error' => 'Internal Server Error');
		/*} else {
            // User with same email/phone already exists in db
			return array('result' => FALSE, 'error' => 'User already exists');
        }*/
    	
    }
	
	/**
     * Deleting user
     * @param Int $user_id User id
     */
    public function deleteUser($user_id) {
    	if(empty($user_id)) {
    		return array('result' => FALSE, 'error' => 'Missing Parameters');
    	}
    	
		$userdetails = $this->getUserDetails($user_id);
		if(empty($userdetails)) {
			return array('result' => FALSE, 'error' => 'No records');
		}
		
		$sql = "DELETE FROM users WHERE id = ?";
		$stmt = $this->conn->prepare($sql);
		$bind = $stmt->bind_param("i", $user_id);
		$result = $stmt->execute();
		$stmt->close();
	
		if ($result) {
			return array('result' => TRUE);
		}
		return array('result' => FALSE, 'error' => 'Internal Server Error');
    	
    }
	
	/**
     * Checking if User already exists
     * @param Int $user_id App user id
     * @return boolean
     */
    public function checkExistingUser($email,$phone) {
    	$sql = "SELECT id from users WHERE email = '".$email."' OR phone = '".$phone."'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		return $num_rows > 0;
    }
    
}// class
?>