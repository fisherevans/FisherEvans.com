<?php
    $pageSize = 4;
    
    $currentTag = "";
    
    function isValidId($id, $table) {
        $query = mysql_query("SELECT id FROM $table WHERE id='$id';");
        return mysql_num_rows($query) > 0;
    }
    
    function fetchRowCount($table) {
        $resource = mysql_query("SELECT COUNT(id) FROM $table;");
        return mysql_result($resource,0);
    }
    
    function fetchPosts($pageNumber) {
        global $pageSize;
        $query = mysql_query("SELECT id, title, intro_content, post_date FROM posts ORDER BY post_date DESC LIMIT " . ($pageNumber*$pageSize) . ", $pageSize;");
        $posts = array();
        while($post = mysql_fetch_array($query))
            array_push($posts, $post);
        return $posts;
    }
    
    function fetchAllPosts() {
        global $pageSize;
        $query = mysql_query("SELECT * FROM posts ORDER BY post_date DESC;");
        $posts = array();
        while($post = mysql_fetch_array($query))
            array_push($posts, $post);
        return $posts;
    }
    
    function fetchPost($postId) {
        global $pageSize;
        $query = mysql_query("SELECT * FROM posts WHERE id='$postId';");
        return mysql_fetch_array($query);
    }
    
    function fetchProjectIdByTag($tagId) {
        $query = mysql_query("SELECT id, name FROM projects WHERE tag_id='$tagId';");
        return mysql_fetch_array($query);
    }
    
    function fetchPostTags($postId) {
        $query = mysql_query("SELECT t.id, t.name FROM posts_to_tags AS ptt, tags AS t WHERE ptt.post_id='$postId' AND ptt.tag_id=t.id;");
        $tags = array();
        while($tag = mysql_fetch_array($query))
            array_push($tags, $tag);
        return $tags;
    }
    
    function fetchTags() {
        $query = mysql_query("SELECT * from tags;");
        $tags = array();
        while($tag = mysql_fetch_array($query))
            array_push($tags, $tag);
        return $tags;
    }
    
    function fetchTagPosts($tagId) {
        $query = mysql_query("SELECT p.id, p.title, p.intro_content, p.post_date FROM posts AS p, posts_to_tags AS ptt WHERE ptt.tag_id='$tagId' AND ptt.post_id=p.id order by post_date desc;");
        $posts = array();
        while($post = mysql_fetch_array($query))
            array_push($posts, $post);
        return $posts;
    }
    
    function fetchTagPostsLimit($tagId, $limit) {
        $query = mysql_query("SELECT p.id, p.title, p.intro_content, p.post_date FROM posts AS p, posts_to_tags AS ptt WHERE ptt.tag_id='$tagId' AND ptt.post_id=p.id order by post_date desc LIMIT $limit;");
        $posts = array();
        while($post = mysql_fetch_array($query))
            array_push($posts, $post);
        return $posts;
    }
    
    function fetchTagName($tagId) {
        $query = mysql_query("SELECT name FROM tags WHERE id='$tagId';");
        $tag = mysql_fetch_array($query);
        return $tag['name'];
    }
    
    function fetchPostTitle($postId) {
        $query = mysql_query("SELECT title FROM posts WHERE id='$postId';");
        $post = mysql_fetch_array($query);
        return $post['title'];
    }
    
    function getTagList($postId) {
        global $currentTag;
        $tags = fetchPostTags($postId);
        $list = "";
        $id = 0;
        foreach($tags as $tag) {
            if($id++ > 0) $list .= ", ";
            $list .= '<a class="tagLink';
            if($currentTag == $tag['id']) $list .= ' current';
            $list .= '" href="/blog/tags/' . $tag['id'] . '">' . $tag['name'] . '</a>';
        }
        return $list;
    }
    
    function getPageCount($table) {
        global $pageSize;
        return ceil(fetchRowCount($table)/$pageSize);
    }
    
    function getTagPageCount($tagId) {
        global $pageSize;
        return ceil(mysql_result(mysql_query("SELECT COUNT(id) FROM posts_to_tags WHERE tag_id='$tagId';"),0)/$pageSize);
    }
    
    function getPostSummaries($posts, $heading) {
        $content = "";
        foreach($posts as $post) {
            $content .= '<div class="contentBlock"><h2 class="headerLink" onClick="javascript:' . "window.location.assign('/blog/post/" . $post['id'] . "');" . '">' . $post['title'] . '</h2>';
            $content .= '<p class="blogPostTagline time">' . date("F jS, Y", strtotime($post['post_date'])) . '</p>';
            $content .= '<p class="blogPostTagline tags">' . getTagList($post['id']) . '</p>';
            $content .= '<div class="spacer"></div><p class="blogPostOpeneing">' . $post['intro_content'] . '</p>';
            $content .= '<p class="readMore"><a href="/blog/post/' . $post['id'] . '">Continue Reading...</a></div>';
            //$content .= '<div class="break"></div>';
        }
        return $content;
    }
    
    function getRecentPosts($pageNumber) {
        $posts = fetchPosts($pageNumber);
        return getPostSummaries($posts, "h1");
    }
    
    function getPost($postId) {
        $post = fetchPost($postId);
        
        if($post == null)
            return get404();
        
        $content = '<p class="topNotification">You are viewing a single blog post. You can go back to view all of my recent <a href="/blog">Blog Posts</a>.</p>';
        $content .= '<div class="contentBlock"><h1>' . $post['title'] . '</h1>';
        $content .= '<p class="blogPostTagline time">' . date("F jS, Y", strtotime($post['post_date'])) . '</p>';
        $content .= '<p class="blogPostTagline tags">' . getTagList($post['id']) . '</p>';
        $content .= '<div class="spacer"></div><p class="blogPostOpeneing">' . $post['intro_content'] . '</p>';
        $content .= $post['main_content'];
        $content .= '</div><p class="topNotification">Go back to my most recent <a href="/blog">Blog</a> posts...</p>';
        return $content;
    }
    
    function getTag($tagId) {
        $posts = fetchTagPosts($tagId);
        $projectText = "";
        $project = fetchProjectIdByTag($tagId);
        if($project != null)
            $projectText = "You can view the project related to this tag <a href='/projects/" . $project['id'] . "'>here</a>.";
        $content = '<p class="topNotification">You are viewing posts tagged with <b>' . fetchTagName($tagId) . '</b>. ' . $projectText . '</p>';
        $content .= getPostSummaries(fetchTagPosts($tagId), "h1");
        return $content;
    }
    
    function getPageLinks($preText, $currentPage, $linkPrefix, $table) {
        $count = getPageCount($table);
        $content = '<div class="pageLinks">' . $preText . '( ';
        for($id = 1;$id <= $count;$id++) {
            if($id > 1)
                $content .= " - ";
            if($id == $currentPage)
                $content .= '<span class="pageNumber currentPage">' . $id . '</span>';
            else
                $content .= '<a class="pageNumber" href="' . $linkPrefix . $id . '">' . $id . '</a>';
        }
        $content .= ' )</div>';
        return $content;
    }
    
    function getBlogContent($path) {
        $action = array_shift($path);
        if($action == null)
            $action = '1';
        switch($action) {
            case "post":
                global $title;
                $postId = array_shift($path);
                if(isValidId($postId, "posts")) {
                    $title = fetchPostTitle($postId) . " (Post)" . $title;
                    return getPost($postId);
                } else return get404();
                break;
            case "tags":
                global $currentTag;
                global $title;
                $currentTag = array_shift($path);
                if(isValidId($currentTag, "tags")) {
                    $title = fetchTagName($currentTag) . " (Tag)" . $title;
                    return getTag($currentTag);
                } else return get404();
                break;
            default:
                global $title;
                $validNumber = preg_match("/^[0-9]+$/", $action, $matches);
                if(!$validNumber) return get404();
                if(getPageCount("posts") < $action) return get404();
                $title = "Blog" . $title;
                if($action == 1)
                    $content = '<h1>Blog</h1><p>A small collection of thoughts and progress notes I thought the would would possibly what to know about. I try to keep my updates sparse but informative but I can\'t hold that promise.</p>';
                else
                    $content = getPageLinks("You are viewing blog posts from a past time.<br>", $action, "/blog/", "posts");
                return $content . getRecentPosts($action - 1) . getPageLinks("Page Selection<br>", $action, "/blog/", "posts");
                break;
        }
    }
?>