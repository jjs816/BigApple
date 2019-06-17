<?php
include("includes/header.php");
//include("includes/class/Message.php");
//$message_obj = new Message($con, $userLoggedIn);
$friendship_status = 'None';
$same_user= false;
if(isset($_GET['profile_username'])) {
    
    $username = $_GET['profile_username'];
	if($username== $userLoggedIn)
	{
		$same_user= true;
	}
	else
	{
		$user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$username'");
		$user_array = mysqli_fetch_array($user_details_query);
		$user_sent = mysqli_query($con, "SELECT * FROM relationship WHERE sender_name='$username' AND receiver_name='$userLoggedIn'");
		$user_received = mysqli_query($con, "SELECT * FROM relationship WHERE sender_name='$userLoggedIn' AND receiver_name='$username'");
		if(mysqli_num_rows($user_sent) == 0 && mysqli_num_rows($user_received) == 0)
		{
			$friendship_status = 'Send request';
		}
		else if(mysqli_num_rows($user_received) == 0)
		{
			$friend_row = mysqli_fetch_array($user_sent);
			if($friend_row['friendship_status']== "Sent")
				$friendship_status = 'Request sent';
			else if($friend_row['friendship_status']== "Denied")
				$friendship_status = 'Request denied';
			else 
				$friendship_status = 'Friend';
		}
		else if(mysqli_num_rows($user_sent) == 0){
			$friend_row = mysqli_fetch_array($user_sent);
			if($friend_row['friendship_status']== "sent")
				$friendship_status = 'Respond to request';
			else if($friend_row['friendship_status']== "Denied")
				$friendship_status = 'Send request';
			else 
				$friendship_status = 'Friends';
		//$friendship_status = 'Respond to request';
		}
	}
}

?>

<style type="text/css">
	 	.wrapper {
	 		margin-left: 0px;
			padding-left: 0px;
	 	}

 	</style>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBqxdUPoWFPJa102IlgSSAmJLUffiCgDpA"></script> 	
<div class="main">
	<div class="content_resize"> 	
 	
 	<div class="user_details column">
 		<a href="<?php echo $userLoggedIn; ?>">
				<img src="<?php
			$user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$username'");
		$user_array = mysqli_fetch_array($user_details_query);
		  echo $user_array['profile_pic']; ?>">
			</a>

			<div class="user_details_left_right">
				<a href="<?php echo $userLoggedIn; ?>">
			<?php
			$user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$username'");
		$user_array = mysqli_fetch_array($user_details_query);
			echo $user_array['first_name'] . " " . $user_array['last_name'];

?>
			</a>
				
		</div>
 		<div>
 	
 			<p><?php echo "Posts: ". $post['tot_post'] . "<br>"  ?></p>
 			<p><?php echo "Likes: ". $likes['like_count']. "<br>"  ?></p>
 			
 		</div>
		
		<form action="<?php echo $username; ?>" method="POST">
		</form>
 		<input type="submit" data-toggle="modal" data-target="#post_form" value="Post Something">
		
		<?php if(!$same_user)
		{ ?>
			<input type="submit" data-toggle="modal" data-target="#friends_form" value= <?php echo $friendship_status; ?>>
		<?php 
		} ?>
 	</div>
 	
 	


	<div class="main_column column">

    <ul class="nav nav-tabs" role="tablist" id="profileTabs">
      <li role="presentation" class="active"><a href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a></li>
       <li role="presentation"><a href="#location_div" aria-controls="location_div" id="location_role" role="tab" data-toggle="tab">Location</a></li>
      
      
     
      
    </ul>

    <div class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="newsfeed_div">
        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">
      </div>

		<!-- To be used for about -->
		
	
		
		
	
    <!-- About end!-->
    
      
   	<div role="tabpanel" class="tab-pane fade" id="location_div"> 
   	<p id="demo">Click the button to get your position.</p>
   	<button onclick="getLocation()">Location Finder</button> 
   	
	<div id="mapholder"></div>
	<h4 id="locationstatus"></h4>
   	</div>
   	</div>



    </div>


 	










 	
 	</div>
</div>
 	
</div> 	
 	
 	<!-- Loading posts specific to user-->

 <!-- Modal -->
 <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">Post something!</h4>
      </div>

      <div class="modal-body">
      	<p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

      	<form class="post_form" action=" " method="POST">
				<textarea name="post_body" id="post_text"
					placeholder="Got something to say?"></textarea>
				<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
      			<input type="hidden" name="user_to" value="<?php echo $username; ?>">	
				
				  <input type="submit" name="post" id="submit_profile_post" value="Post"><br>
				  <input type="radio" name="privacy" value="P" checked> Public
  				  <input type="radio" name="privacy" value="S"> Private
  				  <input type="radio" name="privacy" value="T"> Team
				<br>



			</form>
      </div>


      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="friends_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">Friendship status!</h4>
      </div>

      <div class="modal-body">
      	<?php echo $friendship_status."<br><br>";
			$text = "You and ".$username."";
			if($friendship_status == "Friend")
				$text = "You and ".$username." are already friends.";
			else if($friendship_status== "Request sent")
				$text = $username." has not accepted your request yet.";
			else if ($friendship_status == "Respond to request")
				$text = $username." has sent you a request already.";
			else if($friendship_status == "Send request"){
				$relation_type = 'T';
				$date = date("Y-m-d"); // Current date
				$status= 'Sent';
				$query = "CALL insert_relationship('" . $userLoggedIn . "','" . $username . "','" . $relation_type. "','" . $date . "','" . $status . "')";
				
				if(mysqli_query($con, $query))
				{   
				   
					$text = "Request sent successfully.";
				}
			}
		echo $text;	
		?>

     
      </div>


      
    </div>
  </div>
</div>




<script>




  var userLoggedIn = '<?php echo $userLoggedIn; ?>';
  var profileUsername = '<?php echo $username; ?>';
   console.log(profileUsername);
  $(document).ready(function() {

	  if(userLoggedIn == profileUsername) {
			$('#location_role').show();
		} else {
			$('#location_role').hide();
		}
	
		
		
    $('#loading').show();

    //Original ajax request for loading first posts 
    $.ajax({
      url: "includes/handlers/ajax_load_profile_posts.php",
      type: "POST",
      data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
      cache:false,

      success: function(data) {
        $('#loading').hide();
        $('.posts_area').html(data);
      }
    });

    $(window).scroll(function() {
      var height = $('.posts_area').height(); //Div containing posts
      var scroll_top = $(this).scrollTop();
      var page = $('.posts_area').find('.nextPage').val();
      var noMorePosts = $('.posts_area').find('.noMorePosts').val();

      if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
        $('#loading').show();

        var ajaxReq = $.ajax({
          url: "includes/handlers/ajax_load_profile_posts.php",
          type: "POST",
          data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
          cache:false,

          success: function(response) {
            $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
            $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

            $('#loading').hide();
            $('.posts_area').append(response);
          }
        });

      } //End if 

      return false;

    }); //End (window).scroll(function())

    

  });

  </script>	
  

  <?php
include 'includes/footer.php';
?>