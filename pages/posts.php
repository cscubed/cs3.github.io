<?php

$script1 = '<script>';
$script2 = "\n".'$(document).ready(function() {';
$script3 = '<style>';
$post_number = 0;

$sql1 = 'select
posts.id, posts.timestamp, posts.content, users.username, users.firstname
from posts
left outer join users
on posts.user_id = users.id
order by posts.timestamp desc';

$sql2 = "select
comments.comment, users.username, users.firstname
from comments
left outer join users
on comments.user_id = users.id
where comments.post_id = ?";

foreach($dbh->query($sql1) as $row1) {
    $post_timestamp = filter_var($row1['timestamp'], FILTER_SANITIZE_STRING);
    $post_timestamp = date("Y-m-d H:i:s", strtotime($post_timestamp));
    $post_username  = filter_var($row1['username'], FILTER_SANITIZE_STRING);
    $post_firstname = filter_var($row1['firstname'], FILTER_SANITIZE_STRING);
    $post_content   = filter_var($row1['content'], FILTER_UNSAFE_RAW);

    print '<div class="post">';
    
    print 'Posted by: ';
    print "<div style=\"float:right;\">$post_timestamp</div>";
    if(isset($post_username) && !empty($post_username)){
        print "$post_username - $post_firstname";
    }else{
        print 'Unknown';
    }
    print '<br>';
    print '<pre>';
    print $post_content;
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

    $stmt = $dbh->prepare($sql2);

    if ($stmt->execute(array($row1['id']))) {
        while ($row2 = $stmt->fetch()) {
            $comment_username  = filter_var($row2['username'], FILTER_SANITIZE_STRING);
            $comment_firstname = filter_var($row2['firstname'], FILTER_SANITIZE_STRING);
            $comment_text      = filter_var($row2['comment'], FILTER_SANITIZE_STRING);

            print '<div class="comment">';
            
            print '<small>';
            print 'Comment by: ';
            if(isset($comment_username) && !empty($comment_username)){
                print "$comment_username - $comment_firstname";
            }else{
                print 'Unknown';
            }
            print '</small>';
            
            print '<br>';
            print '<p>';
            print $comment_text;
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

if ($post_number == 0) {
    print '<div class="login">';
    print "No posts found";
    print '</div>';
}

print $script1;
print $script2;
print '}); </script>';
print $script3;
print '</style>';
