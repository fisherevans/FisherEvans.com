<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "INSERT INTO tags (id, name) VALUES ('" . $_POST['id'] . "', '" . $_POST['name'] . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
    /**/
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
Tag Created</a><br><br>
