<?php
    $second_resource = (sizeof($URI)>0)?array_shift($URI):"";
    $third_resource = (sizeof($URI)>0)?array_shift($URI):"";
        
        
        
    if($second_resource === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br>
<a href="/admin/tags/new">Create new Tag</a><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    $sortTags = fetchTags();
    foreach($sortTags as $tag)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'blog/tags/' . $tag['id'] . '">' . $tag['name'] . '</a></td>';
        echo '<td>' . $tag['id'] . '</td>';
        echo '<td><a href="/admin/tags/edit/' . $tag['id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deletetag/' . $tag['id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
        $color *= -1;
    }
?>
</table>
<?php
    }
    else if($second_resource === "new")
    {
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
<form action="/admin/newtag" method="post">
<table cellspacing=0>
    <tr><td>Name:</td><td><input type="text" name="name"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
</table>
<br>
<input type="submit" value="Create">
</form>
<?php
    }
    else if($second_resource === "edit")
    {
?>
<a href="/admin/tags">&lt;&lt;&lt; Back to Tag Management</a><br><br>
<form action="/admin/edittag" method="post">
<table cellspacing=0>
    <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo fetchTagName($third_resource); ?>"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id" value="<?php echo $third_resource; ?>"></td></tr>
</table>
<br>
<input type="hidden" name="orig_id" value="<?php echo $third_resource; ?>">
<input type="submit" value="Modify">
</form>
<?php
    }
?>
