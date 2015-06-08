<?php 
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $insert = "INSERT INTO posts (post_id, post_title, post_time, post_content) VALUES ('" . $_POST['id'] . "', '" . $_POST['title'] . "', '" . $_POST['time'] . "', '" .  mysql_escape_string ($_POST['content']) . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
    
    foreach($_POST['tags'] as $tag)
    {
        $addTag = "INSERT INTO posts_to_tags (post_id, tag_id) VALUES ('" . $_POST['id'] . "', '$tag')";
        #echo $addTag . '<br>';
        mysql_query($addTag) or die(mysql_error());
    }
    /**/
?>
<a href="/admin/blog">&lt;&lt;&lt; Back to Blog Management</a><br><br>
Blog Posted: <a target="_blank" href="<?php echo "/blog/post/" . $_POST['reference']; ?>"><?php echo $_POST['title']; ?></a><br><br>
