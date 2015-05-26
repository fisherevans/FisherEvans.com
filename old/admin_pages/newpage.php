<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "INSERT INTO pages (id, title, content) VALUES ('" . $_POST['id'] . "', '" . $_POST['title'] . "', '" . mysql_escape_string(parse($_POST['content'])) . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
?>
<a href="/admin/pages">&lt;&lt;&lt; Back to Page Management</a><br><br>
Page Created: <a target="_blank" href="/<?php echo $_POST['id']; ?>"><?php echo $_POST['title']; ?></a><br><br>
