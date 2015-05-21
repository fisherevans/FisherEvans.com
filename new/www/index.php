<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$blogPostsPerPage = 4;


//include cockpit
include_once('lib/parsedown/Parsedown.php');
include_once('cockpit/bootstrap.php');

$app = new Lime\App();

function get404($message = "Whatever you're looking for, it's not here...") {
    global $app;
    header("HTTP/1.0 404 Not Found");
    $data = [
      'title'=>'404 Not Found',
      'message'=>$message
    ];
    return $app->render('views/404.php with views/layout.php', $data);
}

function getBlogPosts($filter, $page) {
  global $blogPostsPerPage;
  $collection = collection('Blog Posts');
  $count = $collection->count($filter);
  $pages = ceil($count/$blogPostsPerPage);
  if($page > $pages && $page != 1)
    return null;
  $posts = $collection->find($filter);
  $posts->limit($blogPostsPerPage)->skip(($page-1) * $blogPostsPerPage);
  $posts->sort(["posted_date"=>-1]);
  return [
    'posts'=>$posts->toArray(),
    'page'=>$page,
    'pages'=>$pages
  ];
}

$app->bind("/", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'about-page']);
  return $app->render('views/static_content.php with views/layout.php', [
    'title'=>'About',
    'content'=>$staticContent['content']
  ]);
});

$app->bind("/blog", function() use($app) {
  $data = [
    'title'=>'Blog Index',
    'currentPage'=>'blog'
  ];
  return $app->render('views/blog/blogIndex.php with views/layout.php', $data);
});

$app->bind("/blog/recent", function() use($app) {
  $this->reroute("/blog/recent/1");
});

// bind routes
$app->bind("/blog/recent/:page", function($params) use($app) {
  $blog = getBlogPosts(["published"=>true], $params['page']);
  if($blog == null)
    return get404("There aren't THAT many posts... Try a lower page number.");
  $blog['title'] = 'Recent Posts | Blog' . ($blog['page'] != 1 ? ' | Page ' . $blog['page'] : '');
  $blog['currentPage'] = 'blog';
  return $app->render('views/blog/postList.php with views/layout.php', $blog);
});

$app->bind("/blog/tag/:slug", function($params) use($app) {
  $this->reroute("/blog/tag/" . $params["slug"] . "/1");
});

$app->bind("/blog/tag/:slug/:page", function($params) use($app) {
  $tag = collection('Tags')->findOne(['name_slug'=>$params['slug']]);
  $tagIds = [$tag['_id']];
  if(!isset($tag))
    return get404("Looks like that tag doesn't exist. Whoops.");
  $blog = getBlogPosts(function($post) use($tagIds) {
    return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && $post['published'] == true;
  }, $params['page']);
  if($blog == null)
    return get404();
  $blog['title'] = 'Blog' . ($blog['page'] != 1 ? ' | ' . $tag['name'] . ' | Page ' . $blog['page'] : '');
  $blog['currentPage'] = 'blog';
  $blog['filterTag'] = $tag;
  return $app->render('views/blog/postList.php with views/layout.php', $blog);
});

$app->bind("/blog/post/:slug", function($params) use($app) {
    $post = collection('Blog Posts')->findOne(["title_slug"=>$params['slug']]);
    if(!isset($post) || $post['published'] == false)
        return get404();
    $data = [
        'title'=>$post['title'] . ' | Blog ',
        'currentPage'=>'blog',
        'post'=>$post
    ];
    return $app->render('views/blog/post.php with views/layout.php', $data);
});

$app->bind("/projects", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'wip']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Projects',
      'content'=>$staticContent['content']
  ]);
});

$app->bind("/resume", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'wip']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Resume',
      'content'=>$staticContent['content']
  ]);
});

$app->bind("/resources", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'resources']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Resources',
      'content'=>$staticContent['content']
  ]);
});

$app->bind("/contact", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'wip']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Contact Me',
      'content'=>$staticContent['content']
  ]);
});

$app->bind("*", function($params) use($app) {
    return get404();
});

$app->run();