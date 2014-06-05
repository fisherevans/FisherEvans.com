<?php
    $second_resource = (sizeof($uri)>0)?array_shift($uri):"";
    $third_resource = (sizeof($uri)>0)?array_shift($uri):"";
        
        
    if($second_resource === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br><br>
<a href="/admin/projects/new">Create new Project</a><br><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    foreach(getProjects() as $project)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'projects/view/' . $project['project_id'] . '">' . $project['project_name'] . '</a></td>';
        echo '<td>' . $project['project_id'] . '</td>';
        echo '<td>' . $project['project_tag'] . '</td>';
        echo '<td>' . getTagCount($project['project_tag']) . ' Posts</td>';
        echo '<td><a href="/admin/projects/edit/' . $project['project_id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deleteproject/' . $project['project_id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
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
<table>
    <tr><td>Name:</td><td><input type="text" name="name"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
    <tr><td>Tag:</td><td><input type="text" name="tag"></td></tr>
    <tr><td>Description:</td><td><textarea name="description"></textarea></td></tr>
    <tr><td>Page:</td><td><textarea name="page"></textarea></td></tr>
</table>
<br>
<input type="submit" value="Create">
</form>
<?php
    }
    else if($second_resource === "edit")
    {
    $project = getProject($third_resource);
?>
<a href="/admin/projects">&lt;&lt;&lt; Back to Project Management</a><br><br>
<form action="/admin/editproject" method="post">
<table>
    <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo $project['project_name']; ?>"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id" value="<?php echo $project['project_id']; ?>"></td></tr>
    <tr><td>Tag:</td><td><input type="text" name="tag" value="<?php echo $project['project_tag']; ?>"></td></tr>
    <tr><td>Description:</td><td><textarea name="description"><?php echo $project['project_description']; ?></textarea></td></tr>
    <tr><td>Page:</td><td><textarea name="page"><?php echo $project['project_page']; ?></textarea></td></tr>
</table>
<br>
<input type="hidden" name="orig_id" value="<?php echo $project['project_id']; ?>">
<input type="submit" value="Update">
</form>
<?php
    }
?>
