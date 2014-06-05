<?php
    $second_resource = (sizeof($uri)>0)?array_shift($uri):"";
    $third_resource = (sizeof($uri)>0)?array_shift($uri):"";
        
        
        
    if($second_resource === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br><br>
<a href="/admin/tags/new">Create new Tag</a><br><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    $sortTags = getTags();
    usort($sortTags,"tagSort");
    foreach($sortTags as $tag)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'blog/tag/' . $tag['tag_id'] . '">' . $tag['tag_name'] . '</a></td>';
        echo '<td>' . $tag['tag_id'] . '</td>';
        echo '<td>' . getTagCount($tag['tag_id']) . ' Posts</td>';
        echo '<td><a href="/admin/tags/edit/' . $tag['tag_id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deletetag/' . $tag['tag_id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
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
<table>
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
<table>
    <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo getTagName($third_resource); ?>"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id" value="<?php echo $third_resource; ?>"></td></tr>
</table>
<br>
<input type="hidden" name="orig_id" value="<?php echo $third_resource; ?>">
<input type="submit" value="Modify">
</form>
<?php
    }
?>
