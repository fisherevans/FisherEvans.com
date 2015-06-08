<?php 
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $insert = "UPDATE projects SET project_id='" . $_POST['id'] . "', project_name='" . $_POST['name'] . "', project_description='" .  mysql_escape_string ($_POST['description']) . "', project_tag='" .  mysql_escape_string ($_POST['tag']) . "', project_page='" .  mysql_escape_string ($_POST['page']) . "' WHERE project_id='" . $_POST['orig_id'] . "';";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Updated: <a target="_blank" href="<?php echo "/projects/view/" . $_POST['id']; ?>"><?php echo $_POST['name']; ?></a><br><br>
