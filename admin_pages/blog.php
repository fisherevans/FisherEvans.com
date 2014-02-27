<?php
    if(sizeof($URI) > 0)
        $resource2 = array_shift($URI);
    else
        $resource2 = "";
        
        
        
    if($resource2 === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br>
<a href="/admin/blog/new">Create new Post</a><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    foreach(fetchAllPosts() as $post)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'blog/post/' . $post['id'] . '">' . $post['title'] . '</a></td>';
        echo '<td>' . $post['id'] . '</td>';
        echo '<td>';
        foreach(fetchPostTags($post['id']) as $tag)
            echo $tag['id'] . " ";
        echo '</td>';
        echo '<td>' . date("F jS, Y (H:i:s)", strtotime($post['post_date'])) . '</td>';
        echo '<td><a href="/admin/blog/edit/' . $post['id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deleteblogpost/' . $post['id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td></tr>';
        
        $color *= -1;
    }
?>
</table>
<?php
    }
    else if($resource2 === "new")
    {
?>
<a href="/admin/blog">&lt;&lt;&lt; Back to Blog Management</a><br><br>
<form action="/admin/newblogpost" method="post">
<table cellspacing=0>
    <tr><td>Title:</td><td><input type="text" name="title"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
    <tr><td>Post Date:</td><td><input type="text" name="post_date" value="<?php echo date("Y-m-d H:i:s"); ?>"></td></tr>
    <tr><td>Intro Content:</td><td><textarea style="height:100px;" name="intro_content"></textarea></td></tr>
    <tr><td>Main Content:</td><td><textarea name="main_content"></textarea></td></tr>
</table>
<br>
<?php
    $tags = mysql_query("SELECT * FROM tags;") or die(mysql_error());
    while($tag = mysql_fetch_array($tags))
    {
        echo '<input class="checkbox" type="checkbox" name="tags[]" value="' . $tag['id'] . '">' . $tag['name'] . '<br>';
    }
?>
<br>
<input type="submit" value="Post">
</form>
<?php
    }
    else if($resource2 === "edit")
    {
    echo '<a href="/admin/blog">&lt;&lt;&lt; Back to Blog Management</a><br><br>';
    
    if(sizeof($URI) > 0)
    {
        $postID = array_shift($URI);
        $post = fetchPost($postID);
        $postTags = fetchPostTags($postID);
?>
<form action="/admin/editblogpost" method="post">
<table cellspacing=0>
    <tr><td>Title:</td><td><input type="text" name="title" value="<?php echo $post['title']; ?>"></td></tr>
    <tr><td>Time Posted:</td><td><input type="text" name="post_date" value="<?php echo $post['post_date']; ?>"></td></tr>
    <tr><td>Intro Content:</td><td><textarea style="height:200px;" name="intro_content"><?php echo unParse($post['intro_content']); ?></textarea></td></tr>
    <tr><td>Main Content:</td><td><textarea name="main_content"><?php echo unParse($post['main_content']); ?></textarea></td></tr>
</table>
<br>
<?php
    $tags = mysql_query("SELECT * FROM tags;") or die(mysql_error());
    while($tag = mysql_fetch_array($tags))
    {
        
        echo '<input class="checkbox" type="checkbox" name="tags[]" value="' . $tag['id'] . '"' . (in_array($tag, $postTags)?" checked":"") . '>' . $tag['name'] . '<br>';
    }
?>
<br>
<input type="hidden" name="id" value="<?php echo $post['id']; ?>">
<input type="submit" value="Update!">
</form>
<?php
    }
    else
    {
        echo 'No post givien...';
    }
?>

<?php
    }
?>
