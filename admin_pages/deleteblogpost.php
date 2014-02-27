<?php
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $postID = $URI[0];
    
    $post = fetchPost($postID);
    $postTags = fetchPostTags($postID);
    
    $fp = fopen('deleted_posts.txt', 'a');
    fwrite($fp, "\n\n##################################################\n");
    fwrite($fp, print_r($post, TRUE));
    fwrite($fp, print_r($postTags, TRUE));
    fwrite($fp, "##################################################\n");
    fclose($fp);
    
    $delete = "DELETE FROM posts WHERE id='" . $postID . "';";
    #echo $delete . '<br>';
    mysql_query($delete) or die(mysql_error());
    
    $delTag = "DELETE FROM posts_to_tags WHERE post_id='" . $postID . "';";
    #echo $delTag . '<br>';
    mysql_query($delTag) or die(mysql_error());
    
?>
<a href="/admin/blog">&lt;&lt;&lt; Back to Blog Management</a><br><br>
Blog Post Deleted. Data saved in backup text file.
