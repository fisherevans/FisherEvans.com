<?php 
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $insert = "INSERT INTO projects (project_id, project_name, project_description, project_tag, project_page) VALUES ('" . $_POST['id'] . "', '" . $_POST['name'] . "', '" . mysql_escape_string($_POST['description']) . "', '" . $_POST['tag'] . "', '" .  mysql_escape_string($_POST['page']) . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Created: <a target="_blank" href="<?php echo "/projects/view/" . $_POST['id']; ?>"><?php echo $_POST['name']; ?></a><br><br>
