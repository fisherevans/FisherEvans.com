<?php 
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $pageID = $URI[0];
    
    $delNav = "DELETE FROM navigation WHERE page_id='" . $pageID . "';";
    mysql_query($delNav) or die(mysql_error());
    /**/
?>
<a href="/admin/nav">&lt;&lt;&lt; Back to Navigation Management</a><br><br>
Navigation (<?php echo $pageID; ?>) deleted.</a><br><br>
