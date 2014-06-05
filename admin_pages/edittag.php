<?php 
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $updateTags = "UPDATE tags SET tag_id='" . $_POST['id'] . "', tag_name='" . $_POST['name'] . "' WHERE tag_id='" . $_POST['orig_id'] . "';";
    mysql_query($updateTags) or die(mysql_error());
    
    $updateMaps = "UPDATE posts_to_tags SET tag_id='" . $_POST['id'] . "' WHERE tag_id='" . $_POST['orig_id'] . "';";
    mysql_query($updateMaps) or die(mysql_error());
    /**/
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
Tag Modified</a><br><br>
