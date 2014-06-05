<?php
    if(sizeof($uri) > 0)
        $resource2 = array_shift($uri);
    else
        $resource2 = "";
        
        
        
    if($resource2 === "")
    {
?>
<a href="/admin/menu">&lt;&lt;&lt; Back to Menu</a><br><br>
<a href="/admin/blog/new">Create new Post</a><br><br>
<table cellspacing=0>
<?php
    
    $color = 1;
    foreach(getPosts(0, getPostCount()) as $post)
    {
        echo '<tr class="' . (($color>0)?"white":"grey") . '"><td><a target="_blank" href="' . $mainSite . 'blog/post/' . $post['post_id'] . '">' . $post['post_title'] . '</a></td>';
        echo '<td>' . $post['post_id'] . '</td>';
        echo '<td>';
        foreach(getPostTags($post['post_id']) as $tag)
            echo $tag . " ";
        echo '</td>';
        echo '<td>' . date("F jS, Y (H:i:s)", strtotime($post['post_time'])) . '</td>';
        echo '<td><a href="/admin/blog/edit/' . $post['post_id'] . '">Edit</a></td>';
        echo '<td><a href="/admin/deleteblogpost/' . $post['post_id'] . '" onclick="return confirm(\'are you sure?\')">Delete</a></td>';
        
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
<table>
    <tr><td>Title:</td><td><input type="text" name="title"></td></tr>
    <tr><td>ID:</td><td><input type="text" name="id"></td></tr>
    <tr><td>Time Posted:</td><td><input type="text" name="time" value="<?php echo date("Y-m-d H:i:s"); ?>"></td></tr>
    <tr><td>Content:</td><td><textarea name="content"></textarea></td></tr>
</table>
<br>
<?php
    $tags = mysql_query("SELECT * FROM tags;") or die(mysql_error());
    while($tag = mysql_fetch_array($tags))
    {
        echo '<input class="checkbox" type="checkbox" name="tags[]" value="' . $tag['tag_id'] . '">' . $tag['tag_name'] . '<br>';
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
    
    if(sizeof($uri) > 0)
    {
        $postID = array_shift($uri);
        $post = getPost($postID);
        $postTags = getPostTags($postID);
?>
<form action="/admin/editblogpost" method="post">
<table>
    <tr><td>Title:</td><td><input type="text" name="title" value="<?php echo $post['post_title']; ?>"></td></tr>
    <tr><td>Time Posted:</td><td><input type="text" name="time" value="<?php echo $post['post_time']; ?>"></td></tr>
    <tr><td>Content:</td><td><textarea name="content"><?php echo $post['post_content']; ?></textarea></td></tr>
</table>
<br>
<?php
    $tags = mysql_query("SELECT * FROM tags;") or die(mysql_error());
    while($tag = mysql_fetch_array($tags))
    {
        
        echo '<input class="checkbox" type="checkbox" name="tags[]" value="' . $tag['tag_id'] . '"' . (in_array($tag['tag_id'], $postTags)?" checked":"") . '>' . $tag['tag_name'] . '<br>';
    }
?>
<br>
<input type="hidden" name="id" value="<?php echo $post['post_id']; ?>">
<input type="submit" value="Post">
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
