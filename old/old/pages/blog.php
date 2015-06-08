<?php
    include('sidebar.php');
    
    $second_resource = (sizeof($uri)>0)?array_shift($uri):"";
    $third_resource = (sizeof($uri)>0)?array_shift($uri):"";
    $forth_resource = (sizeof($uri)>0)?array_shift($uri):"";
    
    switch($second_resource)
    {
        case "post":
            echo '<h2 class="page_title_withside">Only Showing One Post</h2>';
            printPost(getPost($third_resource));
            break;
        case "tag":
            echo '<h2 class="page_title_withside">Posts Tagged:</h2>';
            echo '<h1 class="page_title_withside">' . getTagName($third_resource) . '</h1>';
            foreach(getPostsByTag($third_resource) as $post)
                printPost($post);
            break;
        case "all":
            echo '<h1 class="page_title_withside">All Blog Posts</h1>';
            echo '<div class="page_content">';
            foreach(getPosts(0, getPostCount()) as $post)
                printPostSummary($post);
            echo '</div>';
            break;
        default:
            $page = ($second_resource==="")?1:$second_resource;
            foreach(getPosts(($page-1)*$blogPageSize, $blogPageSize) as $post)
                printPost($post);
            printBlogPageLinks($page);
            break;
    }
?>