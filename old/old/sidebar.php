
<?php
    
    echo '<div id="sidebar"><br><br>';
    echo '<div class="sidebar_content"><h4>Recent Posts</h4><br>';
    
    $x = 0;
    foreach(getRecentPosts() as $recentPost)
    {
        if($x > 0)
            echo '<br>';
        echo '<a class="recent_post_title" href="/blog/post/' . $recentPost['post_id'] . '">' . $recentPost['post_title'] . '</a><br>';
        echo '<p class="note recent_post_note">' . date("F jS, Y", strtotime($recentPost['post_time'])) . '<br>';
        foreach(getPostTags($recentPost['post_id']) as $recentPostTag)
        {
            echo '<a class="recent_post_note" href="/blog/tag/' . $recentPostTag . '">' . $recentPostTag . '</a>&nbsp; ';
        }
        echo '</p>';
        $x++;
    }
    
    echo '</div><div class="sidebar_content"><h4>All Posts</h4><br>';
    echo '<a class="recent_post_title" href="/blog/all">Click Here</a><br>';
    echo '<p class="note recent_post_note">to see a full blog post listing.</p>';
    
    echo '</div><div class="sidebar_content"><h4>Tags</h4><br>';
    $sortTags = getTags();
    usort($sortTags,"tagSort");
    foreach($sortTags as $tag)
    {
        echo '<p class="note tag_note"><a class="tag_link" href="/blog/tag/' . $tag['tag_id'] . '">' . $tag['tag_name'] . '</a>';
        echo '&nbsp;(' . getTagCount($tag['tag_id']) . ')</p>'."\n";
    }
    
    echo '</div></div>';
    
?>
