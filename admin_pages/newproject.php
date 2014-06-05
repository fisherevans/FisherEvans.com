<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "INSERT INTO projects (id, name, tag_id, intro_content, main_content, image_location) VALUES ('" . $_POST['id'] . "', '" . $_POST['name'] . "', '" . mysql_escape_string($_POST['tag_id'])
    . "', '" . mysql_escape_string(parse($_POST['intro_content'])) . "', '" . mysql_escape_string(parse($_POST['main_content'])) . "', '" .  mysql_escape_string($_POST['image_location']) . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Created: <a target="_blank" href="<?php echo "/projects/" . $_POST['id']; ?>"><?php echo $_POST['name']; ?></a><br><br>
