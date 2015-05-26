<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "UPDATE projects SET id='" . $_POST['id'] . "', name='" . $_POST['name'] . "', intro_content='" .  mysql_escape_string (parse($_POST['intro_content'])) . "', main_content='" .  mysql_escape_string (parse($_POST['main_content'])) . "', tag_id='" .  mysql_escape_string ($_POST['tag_id']) . "', image_location='" .  mysql_escape_string ($_POST['image_location']) . "' WHERE id='" . $_POST['orig_id'] . "';";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Updated: <a target="_blank" href="<?php echo "/projects/" . $_POST['orig_id']; ?>"><?php echo $_POST['name']; ?></a><br><br>
