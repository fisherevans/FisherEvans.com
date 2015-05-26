<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $updateTags = "UPDATE tags SET id='" . $_POST['id'] . "', name='" . $_POST['name'] . "' WHERE id='" . $_POST['orig_id'] . "';";
    mysql_query($updateTags) or die(mysql_error());
    
    $updateMaps = "UPDATE posts_to_tags SET id='" . $_POST['id'] . "' WHERE id='" . $_POST['orig_id'] . "';";
    mysql_query($updateMaps) or die(mysql_error());
    /**/
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
Tag Modified</a><br><br>
