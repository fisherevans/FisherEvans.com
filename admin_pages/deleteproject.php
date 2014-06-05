<?php
    if($_SESSION['phrase'] != $correctPhrase) { exit; }
    
    $projectID = $uri[0];
    
    $project = getproject($projectID);
    
    $fp = fopen('deleted_projects.txt', 'a');
    fwrite($fp, "\n\n##################################################\n");
    fwrite($fp, print_r($project, TRUE));
    fwrite($fp, "##################################################\n");
    fclose($fp);
    
    $delete = "DELETE FROM projects WHERE project_id='" . $projectID . "';";
    #echo $delete . '<br>';
    mysql_query($delete) or die(mysql_error());
    
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
Project Deleted. Data saved in backup text file.
