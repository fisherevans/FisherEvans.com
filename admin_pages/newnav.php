<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $insert = "INSERT INTO navigation (page_id, sequence) VALUES ('" . $_POST['page_id'] . "', '" . $_POST['sequence'] . "');";
    #echo $insert . '<br>';
    mysql_query($insert) or die(mysql_error());
    /**/
?>
<a href="/admin/nav">&lt;&lt;&lt; Back to Navigation Management</a><br><br>
Navigation Created</a><br><br>
