<?php
include("../../config/db_config.php");
include("../../includes/class/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$names = explode(" ", $query);


//If there are two words, assume they are first and last names respectively
if(count($names) == 2)
	$usersReturnedQuery = mysqli_query($con, "SELECT * FROM registered_employee WHERE first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%' LIMIT 8");
//If query has one word only, search first names or last names 
else 
    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM registered_employee WHERE first_name LIKE '$query%' or last_name LIKE '$query%' or profile_name like '$query%' LIMIT 8");


if($query != ""){

	while($row = mysqli_fetch_array($usersReturnedQuery)) {
		$user = new User($con, $userLoggedIn);


		echo "<div class='resultDisplay'>
				<a href='search.php?q=". $row['profile_name'] . "' style='color: #1485BD'>
					<div class='liveSearchProfilePic'>
						<img src='" . $row['profile_pic'] ."'>
					</div>

					<div class='liveSearchText'>
						" . $row['first_name'] . " " . $row['last_name'] . "
						<p>" . $row['profile_name'] ."</p>
					</div>


				</a>
				</div>";

	}

}

?>