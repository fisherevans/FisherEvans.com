<?php
    include('sidebar.php');
    
    $second_resource = (sizeof($uri)>0)?array_shift($uri):"";
    $third_resource = (sizeof($uri)>0)?array_shift($uri):"";
    
    switch($second_resource)
    {
        case "view":
            echo '<h2 class="page_title_withside">Project Page for:</h1>';
            printProjectPage($third_resource);
            break;
        default:
            echo '<h1 class="page_title_withside">Projects</h1>';
            echo '<div class="page_content">';
            printProjects();
            echo '</div>';
            break;
    }
?>