<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$blogPostsPerPage = 4;

if(isset($_SERVER['HTTPS']))
  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
else
  $protocol = 'http';
$url = $protocol . "://" . $_SERVER['HTTP_HOST'];

//include cockpit
include_once('lib/parsedown/Parsedown.php');
include_once('cockpit/bootstrap.php');

$app = new Lime\App();

function get404($message = "Whatever you're looking for, it's not here...") {
    global $app;
    $app->response->status = "404";
    $data = [
        'title'=>'404 Not Found',
        'description'=>'This page was not found. Please let me know if you this is in error.',
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

function fixRelativeLinks($content) {
  global $url;
  return preg_replace('/(href|src)="\/([a-zA-Z0-9])/', '${1}="' . $url . '/${2}', $content);
}

$app->bind("/", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'about-me']);
  return $app->render('views/static_content.php with views/layout.php', [
    'title'=>'About',
    'staticContent'=>$staticContent,
    'currentPage'=>'about'
  ]);
});

$app->bind("/blog", function() use($app) {
  $data = [
      'title'=>'Blog Index',
      'description'=>"The index of Fisher Evans' Blog. Find his most recent musings, browse by tag, or browse the whole archive.",
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
  $blog['description'] = "The most recent posts that Fisher Evans has made to his Blog.";
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
    return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && isset($post['published']) && $post['published'] == true;
  }, $params['page']);
  if($blog == null)
    return get404();
  $blog['title'] =  $tag['name'] . ' | Blog' . ($blog['page'] != 1 ? ' | Page ' . $blog['page'] : '');
  $blog['description'] = "The most recent posts tagged under " . $tag['name'] . " that Fisher Evans has made to his Blog.";
  $blog['currentPage'] = 'blog';
  $blog['filterTag'] = $tag;
  return $app->render('views/blog/postList.php with views/layout.php', $blog);
});

$app->bind("/blog/post/:slug", function($params) use($app) {
    $post = collection('Blog Posts')->findOne(["title_slug"=>$params['slug']]);
    if(!isset($post) || $post['published'] == false)
        return get404();
    $data = [
        'title'=>$post['title'] . ' | Blog',
        'description'=>"Posted: " . $post['posted_date'] . ". " . $post['intro'],
        'currentPage'=>'blog',
        'post'=>$post
    ];
    return $app->render('views/blog/post.php with views/layout.php', $data);
});

$app->bind("/projects", function() use($app) {
  $featured = array();
  $nonFeatured = array();
  $projects = collection('Projects')->find(["published"=>true]);
  $projects->sort(["name"=>1]);
  foreach($projects->toArray() as $project) {
    if(isset($project['featured']) && $project['featured'] == true)
      $featured[] = $project;
    else
      $nonFeatured[] = $project;
  }
  return $app->render('views/projects/projectList.php with views/layout.php', [
      'title'=>'Projects',
      'description'=>"A listing of Fisher Evans' more prominent and complete projects.",
      'currentPage'=>'projects',
      'featured'=>$featured,
      'nonFeatured'=>$nonFeatured
  ]);
});

$app->bind("/projects/:slug", function($params) use($app) {
  $project = collection('Projects')->findOne(["published"=>true,"name_slug"=>$params['slug']]);
  return $app->render('views/projects/project.php with views/layout.php', [
      'title'=>$project['name'] . ' | Projects',
      'description'=>$project['description'],
      'currentPage'=>'projects',
      'project'=>$project,
  ]);
});

$app->bind("/resources", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'resources']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Resources',
      'description'=>"Fisher Evans' favorite libraries, tools and frameworks. Resources that aid from game development to web services.",
      'currentPage'=>'resources',
      'staticContent'=>$staticContent
  ]);
});

$app->bind("/contact", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'contact-me']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Contact',
      'description'=>"It's easy to connect with Fisher Evans: E-Mail, Twitter, LinkedIn, GitHub, the works!",
      'currentPage'=>'contact',
      'staticContent'=>$staticContent
  ]);
});

$app->bind("/credits", function() use($app) {
  $staticContent = collection('Static Content')->findOne(['name_slug'=>'credits']);
  return $app->render('views/static_content.php with views/layout.php', [
      'title'=>'Credits',
      'description'=>"I wouldn't have been able to make this site without a little help...",
      'currentPage'=>'',
      'staticContent'=>$staticContent
  ]);
});

$app->bind("/resume", function() use($app) {
  global $app;
  $app->response->status = "301";
  header('Location: http://resume.fisherevans.com/');
  $data = [
      'title'=>'404 Not Found',
      'description'=>'This page was not found. Please let me know if you this is in error.',
      'message'=>'My resume is now located here: <a href="http://resume.fisherevans.com/">resume.fisherevans.com/</a>.'
  ];
  return $app->render('views/404.php with views/layout.php', $data);
});

$app->bind("/sitemap.xml", function() use($app) {
  return $app->render('views/indexes/sitemap.php', ['app'=>$app]);
});

$app->bind("/blog/rss", function() use($app) {
  return $app->render('views/indexes/rss.php', ['app'=>$app]);
});

$app->bind("*", function() use($app) {
    return get404();
});

if(isset($_SERVER['ORIG_PATH_INFO']))
  $app->run($_SERVER['ORIG_PATH_INFO']);
else if(isset($_SERVER['REQUEST_URI']))
  $app->run($_SERVER['REQUEST_URI']);
else
  $app->run('/');