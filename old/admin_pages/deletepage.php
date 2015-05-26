<?php
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $pageID = $URI[0];
    
    $page = fetchPage($pageID);
    
    $fp = fopen('deleted_pages.txt', 'a');
    fwrite($fp, "\n\n##################################################\n");
    fwrite($fp, print_r($page, TRUE));
    fwrite($fp, "##################################################\n");
    fclose($fp);
    
    $delete = "DELETE FROM pages WHERE id='" . $pageID . "';";
    #echo $delete . '<br>';
    mysql_query($delete) or die(mysql_error());
    
?>
<a href="/admin/pages">&lt;&lt;&lt; Back to Page Management</a><br><br>
Page Deleted. Data saved in backup text file.
