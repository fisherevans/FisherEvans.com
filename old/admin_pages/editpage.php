<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "UPDATE pages SET id='" . $_POST['id'] . "', title='" . $_POST['title'] . "', content='" .  mysql_escape_string (parse($_POST['content'])) . "' WHERE id='" . $_POST['orig_id'] . "';";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/pages">&lt;&lt;&lt; Back to Page Management</a><br><br>
Page Updated: <a target="_blank" href="/<?php echo $_POST['id']; ?>"><?php echo $_POST['title']; ?></a><br><br>
