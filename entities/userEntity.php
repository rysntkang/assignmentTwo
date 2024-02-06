<?php 

class UserEntity extends Dbh {
	private $userId;
	private $username;
    private $password;
    private $name;
    private $surname;
	private $phoneNum;
    private $emailAddress;
    private $userProfileId;

    public function __construct(){
        
    }

    public function set_userId($userId) {
		$this->userId = $userId;
	}

	public function get_userId() {
		return $this->userId;
	}

	public function set_username($username) {
		$this->username = $username;
	}

	public function get_username() {
		return $this->username;
	}

	public function set_password($password) {
		$this->password = $password;
	}

	public function get_password() {
		return $this->username;
	}

	public function set_name($name) {
		$this->name = $name;
	}

	public function get_name() {
		return $this->name;
	}

	public function set_surname($surname) {
		$this->surname = $surname;
	}

	public function get_surname() {
		return $this->get_surname;
	}

	public function set_phoneNum($phoneNum) {
		$this->phoneNum = $phoneNum;
	}

	public function get_phoneNum() {
		return $this->phoneNum;
	}

	public function set_emailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	public function get_emailAddress() {
		return $this->get_emailAddress;
	}

	public function set_userProfileId($userProfileId) {
		$this->userProfileId = $userProfileId;
	}

	public function get_userProfileId() {
		return $this->userProfileId;
	}

	//Login
    protected function login() {
		$error;
		$conn = $this->connectDB();
        $sql = "SELECT userId, username, password, userProfileId FROM users WHERE username = '$this->username' AND password = '$this->password'";
        $result = $conn->query($sql);
        
		if ($result->num_rows > 0)
		{
			$users = $result->fetch_assoc();
			session_start();
			$_SESSION['currentUserId'] = $users["userId"];
			$_SESSION['currentUsername'] = $users["username"];
			$_SESSION['currentUserProfileId'] = $users["userProfileId"];

			$error = "Success";
			return $error;
		}

		$error = "Incorrect username or password!";
		return $error;
	}

	//Registeration
	protected function checkUsername($username)
    {
        $resultCheck;
        $conn = $this->connectDB();
        $sql = "SELECT userId FROM user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
		{
			$resultCheck = false;
		}
        else
        {
            $resultCheck = true;
        }
        return $resultCheck;
    }

	protected function checkPhoneNumber($phoneNum)
	{
		$resultCheck;
		$conn = $this->connectDB();
		$sql = "SELECT userId FROM user WHERE phoneNum = '$phoneNum'";
		$result = $conn->query($sql);

        if ($result->num_rows > 0)
		{
			$resultCheck = false;
		}
        else
        {
            $resultCheck = true;
        }
        return $resultCheck;
	}

    protected function register() {
        $error;
		$conn = $this->connectDB();

        if($this->checkUsername($this->username) == false || $this->checkPhoneNumber($this->phoneNum) == false) {
            $error = "Username or phoneNum number has already been used!";
            return $error;
        }

        $sql = "INSERT INTO users (username, password, name, surname, phoneNum, emailAddress, userProfileId) 
		VALUES ('$this->username', '$this->password', '$this->name', '$this->surname', '$this->phoneNum', '$this->emailAddress', '$this->userProfileId')";

        $result = $conn->query($sql);

		$error = "Success";
		return $error;
    }

	//Viewing Users
	protected function view()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(
                    'userId' => $row['userId'],
					'username' => $row['username'],
					'name' => $row['name'],
					'surname' => $row['surname'],
					'phoneNum' => $row['phoneNum'],
					'emailAddress' => $row['emailAddress']

                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

	//Searching for specific user from their username
	protected function search()
    {
        $error;
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM users WHERE username = '$this->username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            $error = "Success";
            array_push($array, $error);
            while ($row = $result->fetch_assoc())
            {
                $current = array(
                    'userId' => $row['userId'],
                    'username' => $row['username'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
					'phoneNum' => $row['phoneNum'],
					'emailAddress' => $row['emailAddress']
                );
                array_push($array, $current);
            }
            return $array;
        }
        else {
            $error = "No records found";
            array_push($array, $error);
            return $array;
        }
    }


}

?>