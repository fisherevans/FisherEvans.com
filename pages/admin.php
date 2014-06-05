<?php
    generateTagNames();
    
    $editable = true;
    $failed = true;
    
    if(isset($get) && $get === "1qaz@WSX" && $editable)
    {
        $failed = false;
        $con = mysqli_connect("localhost","immortal","1w2e#R3r","fisherevansdotcom");
        if (mysqli_connect_errno($con))
        {
            $failed = true;
        }
        else
        {
            echo '<div class="page_content">';
            echo '<form method="post">';
            echo '<p>Title:<br><input style="color:black;font-family:consolas;width:40%;" type="text" name="title" /></p>';
            echo '<p>Posted:<br><input style="color:black;font-family:consolas;width:40%;" type="text" name="posted" /></p>';
            echo '<p>Title:<br><textarea style="color:black;font-family:consolas;width:80%;height:250px;" name="content"><test tag> hello</textarea></p>';
            
            foreach($tagNames as $tagName)
            {
                echo '<input type="checkbox" name="tags" value="' . $tagName['reference'] . '">' . $tagName['name'] . '<br>';
            }
            
            echo '</div';
        }
    }
    
    if($failed)
    {
        include('404.php');
    }
?>