<?php

class User
{

    private $user;

    private $con;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getUserName()
    {
        return $this->user['profile_name'];
    }

    public function getFirstAndLastName()
    {
        $username = $this->user['profile_name'];
        $query = mysqli_query($this->con, "SELECT first_name, last_name FROM registered_employee WHERE profile_name='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
    
    
    public function getProfilePic() {
        $username = $this->user['profile_name'];
        $query = mysqli_query($this->con, "SELECT profile_pic FROM registered_employee WHERE profile_name='$username'");
        $row = mysqli_fetch_array($query);
        return $row['profile_pic'];
    }
    
}

?>