<?php

class Post
{

    private $user_obj;

    private $con;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    // page=1&userLoggedIn=" + userLoggedIn,
    public function loadPostsFriends($data, $limit)
    {
        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();
        if ($page == 1)
            $start = 0;
        else
            $start = ($page - 1) * $limit;
        
        $post_query = "select * from wall where profile_name = '$userLoggedIn' and (access_id = 'T' or access_id='P') and deleted= 'no'or (profile_name in (select distinct receiver_name from relationship
where sender_name = '$userLoggedIn' and friendship_status = 'Accepted' or friendship_status = 'sent' and (relation_type = 'T' or relation_type = 'F')
) and deleted='no' and (access_id = 'T' or access_id='P')) order by post_id desc;";
        // $post_query = "CALL post_retrieval('". $userLoggedIn ."')";
        
        $str = ""; // String to return
        $data_query = mysqli_query($this->con, $post_query);
        
        if (mysqli_num_rows($data_query) > 0) {
            $num_iterations = 0; // Number of results checked (not necasserily posted)
            $count = 1;
            
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['post_id'];
                $added_by = $row['profile_name'];
                // Prepare user_to string so it can be included even if not posted to a user
                if ($row['profile_name'] == "none") {
                    $user_to = "";
                } else {
                    echo ("<script>console.log(success..." . $row['profile_name'] . ");</script>");
                    $user_to_obj = new User($this->con, $row['profile_name']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to = "<a href='" . $row['profile_name'] . "'>" . $user_to_name . "</a>";
                }
                
                $user_logged_obj = new User($this->con, $userLoggedIn);
                if ($num_iterations ++ < $start)
                    continue;
                
                // Once 10 posts have been loaded, break
                if ($count > $limit) {
                    break;
                } else {
                    $count ++;
                }
                
                if ($userLoggedIn == $added_by)
                    $delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
                else
                    $delete_button = "";
                
                $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM registered_employee WHERE profile_name='$added_by'");
                $user_row = mysqli_fetch_array($user_details_query);
                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];
                // echo("<script>console.log(".$last_name.");</script>");
                
                ?>
<script>
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block")
									element.style.display = "none";
								else
									element.style.display = "block";
							}
						}

				</script>

<?php
                $post_info = mysqli_query($this->con, "SELECT * from post where post_id = '$id'");
                $post_record = mysqli_fetch_array($post_info);
                $post_title = $post_record['post_title'];
                $post_desc = $post_record['post_desc'];
                $post_date = $post_record['post_time'];
                echo ("<script>console.log(" . $post_date . ");</script>");
                $comments_check = mysqli_query($this->con, "SELECT * FROM comment WHERE post_id='$id'");
                $comments_check_num = mysqli_num_rows($comments_check);
                echo ("<script>console.log(" . $comments_check_num . ");</script>");
                
                // Adding multimedia contents
                $multimedia_check = mysqli_query($this->con, "SELECT * FROM  multimedia_content WHERE post_id='$id' and deleted='no'");
                $multimedia_record = mysqli_fetch_array($multimedia_check);
                $multimedia_check_num = mysqli_num_rows($multimedia_check);
                echo ("<script>console.log(" . $multimedia_check_num . ");</script>");
                $multimedia_title = '';
                $multmedia_content = '';
                if ($multimedia_check_num > 0) {
                    $multimedia_title = $multimedia_record['multimedia_name'];
                    $multmedia_content = $multimedia_record['multimedia_content'];
                }
                
                
                //Adding location content
                
                
                $location_check = mysqli_query($this->con, "SELECT * FROM  location WHERE post_id='$id' and deleted='no'");
                $location_record = mysqli_fetch_array( $location_check);
                $location_check_num = mysqli_num_rows($location_check);
                echo ("<script>console.log(" .  $location_check_num . ");</script>");
                $lat = '';
                $lng = '';
                $load_map='';
                if ($location_check_num > 0) {
                    $lat = $location_record['latitude'];
                    $lng = $location_record['longitude'];
                    $load_map = "<img src=\"https://maps.google.com/maps/api/staticmap?key=AIzaSyBqxdUPoWFPJa102IlgSSAmJLUffiCgDpA&markers=".$lat.",".$lng."&zoom=15&size=450x450&sensor=false\" style=\"width: 400px; height: 400px;\" />";
					//$load_map = "<img src=\"https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&markers=color:red%7Clabel:C%7C40.718217,-73.998284&key=AIzaSyBqxdUPoWFPJa102IlgSSAmJLUffiCgDpA\" />";
				}
                
                // Timeframe
                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($post_date); // Time of post
                $end_date = new DateTime($date_time_now); // Current time
                $interval = $start_date->diff($end_date); // Difference between dates
                
				if ($interval->y >= 1) {
                    if ($interval->y == 1)
                        $time_message = $interval->y . " year ago"; // 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // 1+ year ago
                } else if ($interval->m >= 1) {
                    if ($interval->d == 0) {
                        $days = " ago";
                    } else if ($interval->d == 1) {
                        $days = $interval->d . " day ago";
                    } else {
                        $days = $interval->d . " days ago";
                    }
                    if ($interval->m == 1) {
                        $time_message = $interval->m . " month" . $days;
                    } else {
                        $time_message = $interval->m . " months" . $days;
                    }
                } else if ($interval->d >= 1) {
                    if ($interval->d == 1) {
                        $time_message = "Yesterday";
                    } else {
                        $time_message = $interval->d . " days ago";
                    }
                } else if ($interval->h >= 1) {
                    if ($interval->h == 1) {
                        $time_message = $interval->h . " hour ago";
                    } else {
                        $time_message = $interval->h . " hours ago";
                    }
                } else if ($interval->i >= 1) {
                    if ($interval->i == 1) {
                        $time_message = $interval->i . " minute ago";
                    } else {
                        $time_message = $interval->i . " minutes ago";
                    }
                } else {
                    if ($interval->s < 30) {
                        $time_message = "Just now";
                    } else {
                        $time_message = $interval->s . " seconds ago";
                    }
                }
                
                $str .= "<div class='status_post' onClick='javascript:toggle$id()'>
					       <div class='post_profile_pic'>
						      <img src='$profile_pic' width='50'>
						   </div>

					       <div class='posted_by' style='color:#ACACAC;'>
							     <a href='$added_by'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;$time_message
									$delete_button
						   </div>
						  <div id='post_body'>
                                        $post_desc
									<br>
									<br>$multimedia_title
                                     <br>$multmedia_content
                                     
									<br>$load_map
						  </div>

				          <div class='newsfeedPostOptions'>
								     Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>&nbsp;&nbsp;&nbsp;
						</div>

						</div>
						<div class='post_comment' id='toggleComment$id' style='display:none;'>
							<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>
						<hr>";
                
                ?>
<script>

$(document).ready(function() {

						$('#post<?php echo $id; ?>').on('click', function() {
							bootbox.confirm("Are you sure you want to delete this post?", function(result) {

								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

								if(result)
									location.reload();

							});
						});


					});

</script>
<?php
            } // End while loop
            
           
        }
        if ($count > $limit)
            $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
        else
            $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
       
        echo $str;
    }

    // BigApple
    public function submitPost($body, $user_to,$privacy)
    {
        echo ("<script>console.log(Tesing for the submit post" . $body . ");</script>");
        $body = strip_tags($body); // removes html tags
        $body = mysqli_real_escape_string($this->con, $body);
        $check_empty = preg_replace('/\s+/', '', $body); // Deltes all spaces
        
        if ($check_empty != "") {
            
            $body_array = preg_split("/\s+/", $body);
            
            foreach ($body_array as $key => $value) {
                
                if (strpos($value, "www.youtube.com/watch?v=") !== false) {
                    
                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'" . $value . "\'></iframe><br>";
                    $body_array[$key] = $value;
                }
            }
            
            $body = implode(" ", $body_array);
            echo ("<script>console.log(Tesing for the submit post" . $body . ");</script>");
            
            echo ("<script>console.log(user tooo..." . $user_to . ");</script>");
            
            // Current date and time
            $date_added = date("Y-m-d H:i:s");
            // Get username
            $added_by = $this->user_obj->getUsername();
            
            echo ("<script>console.log(user from..." . $added_by . ");</script>");
            // If user is on own profile, user_to is 'none'
            if ($user_to == $added_by)
                $user_to = $added_by;
            
                
            // Inserting into wall
            $count_query = mysqli_query($this->con, "select count(*)  as curr_tot from wall");
            
            $row = mysqli_fetch_array($count_query);
            
            $post_id = 'post_' . ++ $row['curr_tot'];
            
            $query = mysqli_query($this->con, "INSERT INTO post VALUES('$post_id', '$date_added','','$body','$privacy')");
            $add_post_to_wall = mysqli_query($this->con, "INSERT INTO wall VALUES('$post_id','$user_to','no','$privacy')");
            
            // Insert to Post table
            
            
			$returned_id = mysqli_insert_id($this->con);
            
            echo ("<script>console.log(Mysql" . $returned_id . ");</script>");
            $stopWords = "a about above across after again against all almost alone along already
			 also although always among am an and another any anybody anyone anything anywhere are
			 area areas around as ask asked asking asks at away b back backed backing backs be became
			 because become becomes been before began behind being beings best better between big
			 both but by c came can cannot case cases certain certainly clear clearly come could
			 d did differ different differently do does done down down downed downing downs during
			 e each early either end ended ending ends enough even evenly ever every everybody
			 everyone everything everywhere f face faces fact facts far felt few find finds first
			 for four from full fully further furthered furthering furthers g gave general generally
			 get gets give given gives go going good goods got great greater greatest group grouped
			 grouping groups h had has have having he her here herself high high high higher
		     highest him himself his how however i im if important in interest interested interesting
			 interests into is it its itself j just k keep keeps kind knew know known knows
			 large largely last later latest least less let lets like likely long longer
			 longest m made make making man many may me member members men might more most
			 mostly mr mrs much must my myself n necessary need needed needing needs never
			 new new newer newest next no nobody non noone not nothing now nowhere number
			 numbers o of off often old older oldest on once one only open opened opening
			 opens or order ordered ordering orders other others our out over p part parted
			 parting parts per perhaps place places point pointed pointing points possible
			 present presented presenting presents problem problems put puts q quite r
			 rather really right right room rooms s said same saw say says second seconds
			 see seem seemed seeming seems sees several shall she should show showed
			 showing shows side sides since small smaller smallest so some somebody
			 someone something somewhere state states still still such sure t take
			 taken than that the their them then there therefore these they thing
			 things think thinks this those though thought thoughts three through
	         thus to today together too took toward turn turned turning turns two
			 u under until up upon us use used uses v very w want wanted wanting
			 wants was way ways we well wells went were what when where whether
			 which while who whole whose why will with within without work
			 worked working works would x y year years yet you young younger
			 youngest your yours z lol haha omg hey ill iframe wonder else like
             hate sleepy reason for some little yes bye choose";
            
            // Convert stop words into array - split at white space
            $stopWords = preg_split("/[\s,]+/", $stopWords);
            
            // Remove all punctionation
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $body);
            
            // Predict whether user is posting a url. If so, do not check for trending words
            if (strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false && strpos($no_punctuation, "youtube") === false) {
                // Convert users post (with punctuation removed) into array - split at white space
                $keywords = preg_split("/[\s,]+/", $no_punctuation);
                
                foreach ($stopWords as $value) {
                    foreach ($keywords as $key => $value2) {
                        if (strtolower($value) == strtolower($value2))
                            $keywords[$key] = "";
                    }
                }
            }
        }
    }

    // specific to the user profile -->
    public function loadProfilePosts($data, $limit)
    {
        //echo ("<script>console.log(In function" . $profileUser . ");</script>");
        $page = $data['page'];
        $profileUser = $data['profileUsername'];
        $userLoggedIn = $this->user_obj->getUsername();
        
        if ($page == 1)
            $start = 0;
        else
            $start = ($page - 1) * $limit;
        
        $str = ""; // String to return
        echo ("<script>console.log(this is profile" . $profileUser . ");</script>");
        echo ("<script>console.log(this is user" . $userLoggedIn . ");</script>");
        if($profileUser == $userLoggedIn) {
            $post_query = "select * from wall where profile_name = '$userLoggedIn' and deleted= 'no' order by post_id DESC;";
        } else {
            $post_query = "select * from wall where profile_name = '$profileUser' and deleted= 'no' and (access_id='T' or access_id = 'P') order by post_id DESC;";
        }
        
        
        $data_query = mysqli_query($this->con, $post_query);
        
        if (mysqli_num_rows($data_query) > 0) {
            $num_iterations = 0; // Number of results checked (not necasserily posted)
            $count = 1;
            
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['post_id'];
                $added_by = $row['profile_name'];
                // Prepare user_to string so it can be included even if not posted to a user
                if ($row['profile_name'] == "none") {
                    $user_to = "";
                } else {
                    echo ("<script>console.log(success..." . $row['profile_name'] . ");</script>");
                    $user_to_obj = new User($this->con, $row['profile_name']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to = "<a href='" . $row['profile_name'] . "'>" . $user_to_name . "</a>";
                }
                
                $user_logged_obj = new User($this->con, $userLoggedIn);
                if ($num_iterations ++ < $start)
                    continue;
                
                // Once 10 posts have been loaded, break
                if ($count > $limit) {
                    break;
                } else {
                    $count ++;
                }
                
                if ($userLoggedIn == $added_by)
                    $delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
                else
                    $delete_button = "";
                
                $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM registered_employee WHERE profile_name='$added_by'");
                $user_row = mysqli_fetch_array($user_details_query);
                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];
                // echo("<script>console.log(".$last_name.");</script>");
                
                ?>
<script>
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block")
									element.style.display = "none";
								else
									element.style.display = "block";
							}
						}

				</script>

<?php
                $post_info = mysqli_query($this->con, "SELECT * from post where post_id = '$id'");
                $post_record = mysqli_fetch_array($post_info);
                $post_title = $post_record['post_title'];
                $post_desc = $post_record['post_desc'];
                $post_date = $post_record['post_time'];
                echo ("<script>console.log(" . $post_date . ");</script>");
                $comments_check = mysqli_query($this->con, "SELECT * FROM comment WHERE post_id='$id'");
                $comments_check_num = mysqli_num_rows($comments_check);
                echo ("<script>console.log(" . $comments_check_num . ");</script>");
                
                // Adding multimedia contents
                $multimedia_check = mysqli_query($this->con, "SELECT * FROM  multimedia_content WHERE post_id='$id' and deleted='no'");
                $multimedia_record = mysqli_fetch_array($multimedia_check);
                $multimedia_check_num = mysqli_num_rows($multimedia_check);
                echo ("<script>console.log(" . $multimedia_check_num . ");</script>");
                $multimedia_title = '';
                $multmedia_content = '';
                if ($multimedia_check_num > 0) {
                    $multimedia_title = $multimedia_record['multimedia_name'];
                    $multmedia_content = $multimedia_record['multimedia_content'];
                }
               
                
                //Adding location content
                
                
                $location_check = mysqli_query($this->con, "SELECT * FROM  location WHERE post_id='$id' and deleted='no'");
                $location_record = mysqli_fetch_array( $location_check);
                $location_check_num = mysqli_num_rows($location_check);
                echo ("<script>console.log(" .  $location_check_num . ");</script>");
                $lat = '';
                $lng = '';
                $load_map='';
                if ($location_check_num > 0) {
                    $lat = $location_record['latitude'];
                    $lng = $location_record['longitude'];
                    $load_map = "<img src=\"https://maps.google.com/maps/api/staticmap?key=AIzaSyBqxdUPoWFPJa102IlgSSAmJLUffiCgDpA&markers=".$lat.",".$lng."&zoom=15&size=400x300&sensor=false\" style=\"width: 400px; height: 400px;\" />";
				}
                
                // Timeframe
                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($post_date); // Time of post
                $end_date = new DateTime($date_time_now); // Current time
                $interval = $start_date->diff($end_date); // Difference between dates
                if ($interval->y >= 1) {
                    if ($interval->y == 1)
                        $time_message = $interval->y . " year ago"; // 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // 1+ year ago
                } else if ($interval->m >= 1) {
                    if ($interval->d == 0) {
                        $days = " ago";
                    } else if ($interval->d == 1) {
                        $days = $interval->d . " day ago";
                    } else {
                        $days = $interval->d . " days ago";
                    }
                    if ($interval->m == 1) {
                        $time_message = $interval->m . " month" . $days;
                    } else {
                        $time_message = $interval->m . " months" . $days;
                    }
                } else if ($interval->d >= 1) {
                    if ($interval->d == 1) {
                        $time_message = "Yesterday";
                    } else {
                        $time_message = $interval->d . " days ago";
                    }
                } else if ($interval->h >= 1) {
                    if ($interval->h == 1) {
                        $time_message = $interval->h . " hour ago";
                    } else {
                        $time_message = $interval->h . " hours ago";
                    }
                } else if ($interval->i >= 1) {
                    if ($interval->i == 1) {
                        $time_message = $interval->i . " minute ago";
                    } else {
                        $time_message = $interval->i . " minutes ago";
                    }
                } else {
                    if ($interval->s < 30) {
                        $time_message = "Just now";
                    } else {
                        $time_message = $interval->s . " seconds ago";
                    }
                }
               
                $str .= "<div class='status_post' onClick='javascript:toggle$id()'>
					       <div class='post_profile_pic'>
						      <img src='$profile_pic' width='50'>
						   </div>

					       <div class='posted_by' style='color:#ACACAC;'>
							     <a href='$added_by'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;$time_message
									$delete_button
						   </div>

                           <div id='post_body'>
                                        $post_desc
									<br>
									<br>$multimedia_title
                                     <br>$multmedia_content                                                         
									<br>$load_map
                                    
						  </div>


				          <div class='newsfeedPostOptions'>
								     Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
						</div>

						</div>
						<div class='post_comment' id='toggleComment$id' style='display:none;'>
							<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>
						<hr>";
                
                ?>
<script>

                					$(document).ready(function() {

                						$('#post<?php echo $id; ?>').on('click', function() {
                							bootbox.confirm("Are you sure you want to delete this post?", function(result) {

                								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

                								if(result)
                									location.reload();

                							});
                						});


                					});

                				</script>
<?php
            } // End while loop
            
            if ($count > $limit)
                $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='noMorePosts' value='false'>";
            else
                $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
        }
        
        echo $str;
    }

    public function submitLocationPost($data, $user)
    {
        echo ("<script>console.log(In submitLocationPost function" . ");</script>");
        $lat = $data['latitude'];
        $lng = $data['longitude'];
        echo ("<script>console.log(In submitLocationPost function.$lat);</script>");
        $user_to = $user;
        
        $date_added = date("Y-m-d H:i:s");
        
        $count_query = mysqli_query($this->con, "select count(*)  as curr_tot from wall");
        $row = mysqli_fetch_array($count_query);
        
        $post_id = 'post_' . ++ $row['curr_tot'];
        
        echo ("<script>console.log($post_id);</script>");
        
        
        $query = mysqli_query($this->con, "INSERT INTO post VALUES('$post_id', '$date_added','','You shared location at..','P')");
        $add_post_to_wall = mysqli_query($this->con, "INSERT INTO wall VALUES('$post_id','$user_to','no','P')");
        
        # Inserting into location table
        $count_location_row = mysqli_query($this->con, "select count(*)  as curr_tot from location");
        $row = mysqli_fetch_array($count_location_row);
        $loc_id = 'loc_'. ++ $row['curr_tot'];
        
        
        
        $add_location_sql=mysqli_query($this->con,"INSERT INTO location VALUES('$loc_id','$post_id','Location from map','','$lat','$lng','P','no')");
        
        
    }
}
?>
