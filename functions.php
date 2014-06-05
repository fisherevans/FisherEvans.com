<?php

    $projects = null;
    function getProjects()
    {
        global $projects;
        if($projects === null)
        {
            $projects = array();
            $query = mysql_query("SELECT * FROM projects;") or die(mysql_error());
            while($project = mysql_fetch_array($query))
            {
                $projects[$project['project_id']] = array(
                    'project_id'=>$project['project_id'],
                    'project_name'=>$project['project_name'],
                    'project_description'=>$project['project_description'],
                    'project_tag'=>$project['project_tag'],
                    'project_page'=>$project['project_page'],
                );
            }
        }
        return $projects;
    }
    
    function getProject($projectID)
    {
        $projects = getProjects();
        return $projects[$projectID];
    }
    
    function getProjectImage($projectID)
    {
        global $defaultProjectImage;
        $img = "img/" . $projectID  . ".png";
        return '/' . (file_exists($img)?($img):$defaultProjectImage);
    }
    
    function printProjects()
    {
        $row = 1;
        foreach(getProjects() as $project)
        {
            echo '<a href="/projects/view/' . $project['project_id'] . '"><div class="project_thumb">';
            
            $img = '<img src="' . getProjectImage($project['project_id']) . '" />';
            $text = '<div><h2>' . $project['project_name'] . '</h2><p class="subtitle">' . $project['project_description'] . '</p></div>';
            
            echo ($row>0)?($img.$text):($text.$img);
            echo '</div>';
            
            $row *= -1;
        }
    }
    
    function printProjectPage($projectID)
    {
        $project = getProject($projectID);
        echo '<h1 class="page_title_withside">' . $project['project_name'] . '</h1>';
        echo '<div class="page_content">';
        echo '<div class="img_right"><img src="' . getProjectImage($project['project_id']) . '"></img></div>';
        echo $project['project_page'];
        echo '</div>';
        
        echo '<div class="page_content">';
        echo '<h1>Blog Posts About this Project</h1>';
        echo '<p>Blog posts tagged as "' . getTagName($project['project_tag']) . '" refer to this project. Click below to see all of the blog posts about ' . $project['project_name'] . '.</p>';
        echo '<h3>Blog Posts Tagged in <a class="dark_red" href="/blog/tag/' . $project['project_tag'] . '">' . getTagName($project['project_tag']) . ' (' . $project['project_tag'] . ')</a></h3>';
        echo '</div>';
    }
    
    $tags = null;
    function getTags()
    {
        global $tags;
        if($tags === null)
        {
            $tags = array();
            $query = mysql_query("SELECT * FROM tags;") or die(mysql_error());
            while($tag = mysql_fetch_array($query))
            {
                $tags[$tag['tag_id']] = array(
                    'tag_id'=>$tag['tag_id'],
                    'tag_name'=>$tag['tag_name']
                );
            }
        }
        return $tags;
    }
    
    function getTagCount($tagID)
    {
        $query = mysql_query("SELECT id FROM posts_to_tags WHERE tag_id='$tagID';") or die(mysql_error());
        return mysql_num_rows($query);
    }
    
    function getTagName($tagID)
    {
        $query = mysql_query("SELECT tag_name FROM tags WHERE tag_id='$tagID';") or die(mysql_error());
        $tag = mysql_fetch_array($query);
        return $tag['tag_name'];
    }
    
    function tagSort($a, $b)
    {
        if (getTagCount($a['tag_id']) == getTagCount($b['tag_id']))
            return 0;
        return (getTagCount($a['tag_id']) < getTagCount($b['tag_id'])) ? 1 : -1;
    }

    $recentPosts = null;
    function getRecentPosts()
    {
        global $recentPosts;
        global $footRecentSize;
        if($recentPosts === null)
        {
            $recentPosts = array();
            $query = mysql_query("SELECT post_id, post_title, post_time FROM posts ORDER BY post_time DESC LIMIT $footRecentSize;") or die(mysql_error());
            while($post = mysql_fetch_array($query))
                array_push($recentPosts, $post);
        }
        return $recentPosts;
    }

    function getPosts($lowLimit, $highLimit)
    {
        $recentPosts = array();
        $query = mysql_query("SELECT post_id, post_title, post_time FROM posts ORDER BY post_time DESC LIMIT $lowLimit, $highLimit") or die(mysql_error());
        while($post = mysql_fetch_array($query))
            array_push($recentPosts, $post);
        return $recentPosts;
    }
    
    function getPost($postID)
    {
        $query = mysql_query("SELECT post_id, post_title, post_time, post_content FROM posts WHERE post_id='$postID';") or die(mysql_error());
        return mysql_fetch_array($query);
    }
    
    function getPostCount()
    {
        $query = mysql_query("SELECT post_id FROM posts;") or die(mysql_error());
        return mysql_num_rows($query);
    }
    
    function getPostTags($postID)
    {
        $postTags = array();
        $query = mysql_query("SELECT * FROM posts_to_tags WHERE post_id='$postID';") or die(mysql_error());
        while($tag = mysql_fetch_array($query))
            array_push($postTags, $tag['tag_id']);
        return $postTags;
    }
    
    function getPostContent($postID)
    {
        $query = mysql_query("SELECT post_content FROM posts WHERE post_id='$postID';") or die(mysql_error());
        $post = mysql_fetch_array($query);
        return $post['post_content'];
    }
    
    function getPostsByTag($tagID)
    {
        $posts = array();
        
        $query = mysql_query("SELECT post_id FROM posts_to_tags WHERE tag_id='$tagID';") or die(mysql_error());
        while($mapping = mysql_fetch_array($query))
            array_push($posts, getPost($mapping['post_id']));
        
        return $posts;
    }
    
    function printPost($post)
    {
        echo  '<div class="page_content"><div class="blogpost_info"><h2><a href="/blog/post/' . $post['post_id'] . '">';
        echo $post['post_title'];
        echo '</a></h2><p class="note">Posted on <b>';
        echo date("F jS, Y", strtotime($post['post_time'])) . " at " . date("g:ia", strtotime($post['post_time']));
        echo '</b><br>Tagged in:&nbsp;&nbsp;';
        
        foreach(getPostTags($post['post_id']) as $tag)
            echo '<a href="/blog/tag/' . $tag . '">' . $tag . '</a>&nbsp;&nbsp;';
        
        echo '</p></div><div class="blogpost_content">';
        echo getPostContent($post['post_id']);
        echo '</div></div>';
    }
    
    function printPostSummary($post)
    {
        echo  '<div class="blogpost_info"><h2><a href="/blog/post/' . $post['post_id'] . '">';
        echo $post['post_title'];
        echo '</a></h2><p class="note">Posted on <b>';
        echo date("F jS, Y", strtotime($post['post_time'])) . " at " . date("g:ia", strtotime($post['post_time']));
        echo '</b><br>Tagged in:&nbsp;&nbsp;';
        
        foreach(getPostTags($post['post_id']) as $tag)
            echo '<a href="/blog/tag/' . $tag . '">' . $tag . '</a>&nbsp;&nbsp;';
        
        echo '</p><br></div>';
    }
    
    function printBlogPageLinks($page)
    {
        global $blogPageSize;
    
        echo '<div class="page_content"><div id="blog_page_numbers">Newer &nbsp;&nbsp;> &nbsp;&nbsp;';
        for($p = 1;$p <= getPostCount()/$blogPageSize;$p++)
        {
            if($p != 1)
                echo '&nbsp;&nbsp; | &nbsp;&nbsp;';
            if($p != $page)
                echo '<a href="/blog/' . $p . '">' . $p . '</a>';
            else
                echo $p;
        }
        echo ' &nbsp;&nbsp;< &nbsp;&nbsp;Older</div></div>';
    }
    
    function printPostRSS($post)
    {
        echo "        <item>\n";
        echo '            <title>' . $post['post_title'] . "</title>\n";
        echo '            <link>http://fisherevans.com/blog/post/' . $post['post_id'] . "/</link>\n";
        echo '            <pubDate>' . date("D, d M Y H:i:s O", strtotime($post['post_time'])) . "</pubDate>\n";
        echo "            <content:encoded>\n";
        echo "                <![CDATA[\n";
        echo             getPostContent($post['post_id']);
        echo "                ]]>\n";
        echo "            </content:encoded>\n";
        echo "        </item>\n";
    }
?>
