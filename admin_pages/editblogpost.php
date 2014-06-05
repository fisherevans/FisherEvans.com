<?php 
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $insert = "UPDATE posts SET post_title='" . $_POST['title'] . "', post_time='" . $_POST['time'] . "', post_content='" .  mysql_escape_string ($_POST['content']) . "' WHERE post_id='" . $_POST['id'] . "';";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
    
    $delOld = "DELETE FROM posts_to_tags WHERE post_id='" . $_POST['id'] . "';";
    #echo $delOld . '<br>';
    mysql_query($delOld) or die(mysql_error());
    
    foreach($_POST['tags'] as $tag)
    {
        $addTag = "INSERT INTO posts_to_tags (post_id, tag_id) VALUES ('" . $_POST['id'] . "', '$tag')";
        #echo $addTag . '<br>';
        mysql_query($addTag) or die(mysql_error());
    }
    /**/
?>
<a href="/admin/blog">&lt;&lt;&lt; Back to Blog Management</a><br><br>
Blog Updated: <a target="_blank" href="<?php echo "/blog/post/" . $_POST['reference']; ?>"><?php echo $_POST['title']; ?></a><br><br>
