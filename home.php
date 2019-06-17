<?php
include ("includes/header.php");
include 'debugger.php';
?>
<div class="main">
	<div class="content_resize">
		<div class="user_details column">
			<a href="<?php echo $userLoggedIn; ?>">
				<img src="<?php echo $user['profile_pic']; ?>">
			</a>

			<div class="user_details_left_right">
				<a href="<?php echo $userLoggedIn; ?>">
			<?php
echo $user['first_name'] . " " . $user['last_name'];

?>
			</a>
				<br>
			<?php

echo "Posts: " . $post['tot_post'] . "<br>";
echo "Likes: " . $likes['like_count'];

?>
		</div>
		</div>

		<div class="main_column column">
			<form class="post_form" action="home.php" method="POST">
				<textarea name="post_body" id="post_text"
					placeholder="Got something to say?"></textarea>
				<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
      			<input type="hidden" name="user_to" value="<?php echo $userLoggedIn; ?>">	

				<input type="submit" name="post" id="submit_profile_post" value="Post"><br>
				<input type="radio" name="privacy" value="P" checked> Public
  				<input type="radio" name="privacy" value="S"> Private
  				<input type="radio" name="privacy" value="T"> Team
				
				<br>
				
				<input type="checkbox" name="loca" id="share_loca"> Location Sharing
				


			</form>
			<br>
			<form action="upload_wall.php" method="post"
				enctype="multipart/form-data" class="wall_post">
				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload">
				
				<br>
				<input type="submit" value="Upload Image" name="submit_pic">
				<input type="text" name="image_title" placeholder="Image Title" required>
			</form>

			<hr>
			<div class="posts_area"></div>
			<img id="loading" src="assets/images/icons/loading.gif">


		</div>


		
	</div>
</div>

<script>
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';

	
	$(document).ready(function(){
		$('#loading').show();
		$.ajax({
			url:"includes/handlers/ajax_load_posts.php",
			type:"POST",
			data:"page=1&userLoggedIn=" + userLoggedIn,
			cache:false,

			success:function(data) {
				console.log(data);
				$("#loading").hide();
				$(".posts_area").html(data);
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
				url: "includes/handlers/ajax_load_posts.php",
				type: "POST",
				data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
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