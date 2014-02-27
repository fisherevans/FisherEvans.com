<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $tagID = $URI[0];
    
    $delTag = "DELETE FROM tags WHERE id='" . $tagID . "';";
    mysql_query($delTag) or die(mysql_error());
    
    $delTagMap = "DELETE FROM posts_to_tags WHERE tag_id='" . $tagID . "';";
    mysql_query($delTagMap) or die(mysql_error());
    /**/
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
Tag (<?php echo $tagID; ?>) deleted.</a><br><br>
