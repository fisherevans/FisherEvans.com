<?php
    if($_SESSION['phrase'] != $correctAdminPhrase) { exit; }
    
    $projectID = $URI[0];
    
    $project = fetchProject($projectID);
    
    $fp = fopen('deleted_projects.txt', 'a');
    fwrite($fp, "\n\n##################################################\n");
    fwrite($fp, print_r($project, TRUE));
    fwrite($fp, "##################################################\n");
    fclose($fp);
    
    $delete = "DELETE FROM projects WHERE id='" . $projectID . "';";
    #echo $delete . '<br>';
    mysql_query($delete) or die(mysql_error());
    
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Deleted. Data saved in backup text file.
