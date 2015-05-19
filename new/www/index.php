<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$baseTitle = "Fisher Evans";


//include cockpit
include_once('lib/parsedown/Parsedown.php');
include_once('cockpit/bootstrap.php');

$app = new Lime\App();

function get404() {
    global $app;
    header("HTTP/1.0 404 Not Found");
    $data = [
        'title'=>'404 | Not Found'
    ];
    return $app->render('views/404.php with views/layout.php', $data);
}

$app->bind("/", function() use($app) {
    $this->reroute("/blog/page/1");
});

$app->bind("/blog", function() use($app) {
    $this->reroute("/blog/page/1");
});

$app->bind("/blog/page", function() use($app) {
    $this->reroute("/blog/page/1");
});

// bind routes
$app->bind("/blog/page/:page", function($params) use($app) {
    $collection = collection('Blog Posts');
    $limit = 4;
    $page  = $params['page'];
    $count = $collection->count(["published"=>true]);
    $pages = ceil($count/$limit);

    if($page > $pages)
        return get404();

    // get posts
    $posts = $collection->find(["published"=>true]);

    // apply pagination
    $posts->limit($limit)->skip(($page-1) * $limit);

    // apply sorting
    $posts->sort(["created"=>-1]);

    $data = [
        'title'=>'Blog' . ($page != 1 ? ' | Page ' . $page : ''),
        'currentPage'=>'blog',
        'posts'=>$posts->toArray(),
        'pages'=>$pages,
        'page'=>$page
    ];
    return $app->render('views/postList.php with views/layout.php', $data);
});

$app->bind("/blog/post/:slug", function($params) use($app) {
    $post = collection('Blog Posts')->findOne(["title_slug"=>$params['slug']]);
    if($post['published'] == false)
        return get404();
    $data = [
        'title'=>$post['title'] . ' | Blog ',
        'currentPage'=>'blog',
        'post'=>$post
    ];
    return $app->render('views/post.php with views/layout.php', $data);
});

$app->bind("*", function($params) use($app) {
    return get404();
});

$app->run();