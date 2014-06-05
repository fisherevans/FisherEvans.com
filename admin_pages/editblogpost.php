<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "UPDATE posts SET title='" . $_POST['title'] .
    "', post_date='" . $_POST['post_date'] .
    "', main_content='" .  mysql_escape_string (parse($_POST['main_content'])) .
    "', intro_content='" .  mysql_escape_string (parse($_POST['intro_content'])) .
    "' WHERE id='" . $_POST['id'] . "';";
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
Blog Updated: <a target="_blank" href="<?php echo "/blog/post/" . $_POST['id']; ?>"><?php echo $_POST['title']; ?></a><br><br>
