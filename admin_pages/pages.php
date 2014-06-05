<?php
    $second_resource = (sizeof($URI)>0)?array_shift($URI):"";
    $third_resource = (sizeof($URI)>0)?array_shift($URI):"";
        
        
    if($second_resource === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br>
<a href="/admin/pages/new">Create new Page</a><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    foreach(fetchPages() as $page)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . $page['id'] . '">' . $page['title'] . '</a></td>';
        echo '<td>' . $page['id'] . '</td>';
        echo '<td><a href="/admin/pages/edit/' . $page['id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deletepage/' . $page['id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
        $color *= -1;
    }
?>
</table>
<?php
    }
    else if($second_resource === "new")
    {
?>
<a href="/admin/pages">&lt;&lt;&lt; Back to Page Management</a><br><br>
<form action="/admin/newpage" method="post">
<table cellspacing=0>
    <tr><td>Title:</td><td><input type="text" name="title"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
    <tr><td>Content:</td><td><textarea name="content"></textarea></td></tr>
</table>
<br>
<input type="submit" value="Create Page">
</form>
<?php
    }
    else if($second_resource === "edit")
    {
    $page = fetchPage($third_resource);
?>
<a href="/admin/pages">&lt;&lt;&lt; Back to Page Management</a><br><br>
<form action="/admin/editpage" method="post">
<table cellspacing=0>
    <tr><td>Title:</td><td><input type="text" name="title" value="<?php echo $page['title']; ?>"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id" value="<?php echo $page['id']; ?>"></td></tr>
    <tr><td>Content:</td><td><textarea name="content"><?php echo unParse($page['content']); ?></textarea></td></tr>
</table>
<br>
<input type="hidden" name="orig_id" value="<?php echo $page['id']; ?>">
<input type="submit" value="Update Page">
</form>
<?php
    }
?>
