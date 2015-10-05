<?php

$script1 = '<script>';
$script2 = "\n".'$(document).ready(function() {';
$script3 = '<style>';
$post_number = 0;

$sql1 = "SELECT * FROM posts ORDER BY id DESC";
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {
    while($row1 = mysqli_fetch_assoc($result1)) {
		print '<div class="post">';
		$sql2 = "SELECT * FROM users WHERE id='".$row1['user_id']."'";
		$result2 = mysqli_query($conn, $sql2);
		
		print 'Posted by: ';
		print '<div style="float:right;">'.$row1['timestamp'].'</div>';
		if($row2 = mysqli_fetch_assoc($result2)){
			print $row2['username'].' - '.$row2['firstname'];
		}else{
			print 'Unknown';
		}
		print '<br>';
		print '<pre>';
        print $row1['content'];
		print '</pre>';

		$post_number = $post_number +1;
		$script1 = $script1 . 'var slided'.$post_number.' = true;';
		$script2 = $script2 .'
$("#flip'.$post_number.'").click(function() {
	if (slided'.$post_number.') {
		$("#panel'.$post_number.'").slideDown("fast");
		slided'.$post_number.' = !slided'.$post_number.';
		$("#down_arrow'.$post_number.'").hide("fast");
		$("#up_arrow'.$post_number.'").show("fast");


	} else {
		$("#panel'.$post_number.'").slideUp("fast");
		slided'.$post_number.' = !slided'.$post_number.';
		$("#up_arrow'.$post_number.'").hide("fast");
		$("#down_arrow'.$post_number.'").show("fast");
	};
});
		';
		$script3 = $script3 . '
#panel'.$post_number.' {
	display: none;
}
		';

		print '<div class="comments">';

		print '
		<a class="commentsbutton">
			<div id="flip'.$post_number.'">
				<div id="down_arrow'.$post_number.'">
					Show Comments
				</div>
				<div id="up_arrow'.$post_number.'" style="display:none">
					Hide Comments
				</div>
			</div>
		</a>
		';

		print '	
<div class="pulldown">
<div class="plan-list" id="panel'.$post_number.'">
		<p class="info">';
		print 'Comments:<br>';
		$sql3 = "SELECT * FROM comments WHERE post_id='".$row1['id']."'";
		$result3 = mysqli_query($conn, $sql3);

		if (mysqli_num_rows($result3) > 0) {
			while($row3 = mysqli_fetch_assoc($result3)) {
				print '<div class="comment">';
				$sql4 = "SELECT * FROM users WHERE id='".$row3['user_id']."'";
				$result4 = mysqli_query($conn, $sql4);
				
				print '<small>';
				print 'Comment by: ';
				if($row4 = mysqli_fetch_assoc($result4)){
					print $row4['username'].' - '.$row4['firstname'];
				}else{
					print 'Unknown';
				}
				print '</small>';
				
				print '<br>';
				print '<p>';
				print $row3['comment'];
				print '</p>';
				print '</div>'; // Closing Comment Div

			}
		
			
		}	
		print '</p></div>'; // Closing Comments Div

		print '
	</div>
</div>
		';

		print '
<form action="create.php?type=comment&post_id='.$row1['id'].'" method="post">
	<br> Comment: <Br><textarea name="comment" rows="10" cols="30"></textarea>
	<br><br>
	<input type="submit" value="Submit">
</form>';
	print '</div>'; // Closing Post div.
	}
			
} else {
    print '<div class="login">';
    print "No posts found";
    print '</div>';
}

print $script1;
print $script2;
print '}); </script>';
print $script3;
print '</style>';