<?php
    $second_resource = (sizeof($URI)>0)?array_shift($URI):"";
    $third_resource = (sizeof($URI)>0)?array_shift($URI):"";
        
        
    if($second_resource === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br>
<a href="/admin/projects/new">Create new Project</a><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    foreach(fetchProjects() as $project)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'projects/' . $project['id'] . '">' . $project['name'] . '</a></td>';
        echo '<td>' . $project['id'] . '</td>';
        echo '<td><a href="/admin/projects/edit/' . $project['id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deleteproject/' . $project['id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
        $color *= -1;
    }
?>
</table>
<?php
    }
    else if($second_resource === "new")
    {
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
<form action="/admin/newproject" method="post">
<table cellspacing=0>
    <tr><td>Name:</td><td><input type="text" name="name"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
    <tr><td>Tag:</td><td><input type="text" name="tag_id"></td></tr>
    <tr><td>Image:</td><td><input type="text" name="image_location"></td></tr>
    <tr><td>Intro Content:</td><td><textarea style="height:200px;" name="intro_content"></textarea></td></tr>
    <tr><td>Main Content:</td><td><textarea name="main_content"></textarea></td></tr>
</table>
<br>
<input type="submit" value="Create">
</form>
<?php
    }
    else if($second_resource === "edit")
    {
    $project = fetchProject($third_resource);
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
<form action="/admin/editproject" method="post">
<table cellspacing=0>
    <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo $project['name']; ?>"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id" value="<?php echo $project['id']; ?>"></td></tr>
    <tr><td>Tag:</td><td><input type="text" name="tag_id" value="<?php echo $project['tag_id']; ?>"></td></tr>
    <tr><td>Image:</td><td><input type="text" name="image_location" value="<?php echo $project['image_location']; ?>"></td></tr>
    <tr><td>Intro Content:</td><td><textarea style="height:200px;" name="intro_content"><?php echo unParse($project['intro_content']); ?></textarea></td></tr>
    <tr><td>Main Content:</td><td><textarea name="main_content"><?php echo unParse($project['main_content']); ?></textarea></td></tr>
</table>
<br>
<input type="hidden" name="orig_id" value="<?php echo $project['id']; ?>">
<input type="submit" value="Update">
</form>
<?php
    }
?>
