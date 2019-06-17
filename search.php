<?php
include 'includes/header.php';
include 'config/db_config.php';

if (isset($_GET['q'])) {
    $query = $_GET['q'];
} else {
    $query = "";
}


if(isset($_GET['type'])) {
    $type = $_GET['type'];
}
else {
    $type = "name";
}
?>




<div class="main">
	<div class="content_resize">
	<div class="main_column column">
		

<?php
if ($query == "")
    echo 'Please enter to search';
else {
    $names = explode(" ", $query);
    
    // If there are two words, assume they are first and last names respectively
    if (count($names) == 2)
        $usersReturnedQuery = mysqli_query($con, "SELECT * FROM registered_employee WHERE first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%' LIMIT 8");
    // If query has one word only, search first names or last names
    else
        $usersReturnedQuery = mysqli_query($con, "SELECT * FROM registered_employee WHERE first_name LIKE '$query%' or last_name LIKE '$query%' or profile_name like '$query%' LIMIT 8");
        
        
    if(mysqli_num_rows($usersReturnedQuery) == 0)
        echo "We can't find anyone with a like: " .$query;
    else
        echo mysqli_num_rows($usersReturnedQuery) . " results found: <br> <br>";
   
       
   
    while($row = mysqli_fetch_array($usersReturnedQuery)) {
        $user_obj = new User($con, $user['profile_name']);
        $button = "";
        
        echo "<div class='search_result'>
					<div class='searchPageFriendButtons'>
						<form action='' method='POST'>
							" . $button . "
							<br>
						</form>
					</div>
        
        
					<div class='result_profile_pic'>
						<a href='" . $row['profile_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
					</div>
            
						<a href='" . $row['profile_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
						
						</a>
						<br>
						<br>
						    
				</div>
				<hr id='search_hr'>";
    }
    
   
        
}

//Check if results were found

        
        
       
        
        










?>
</div>			
</div>	
</div>

<?php include 'includes/footer.php';?>