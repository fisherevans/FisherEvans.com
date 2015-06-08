<?php
/* VALID CHANGE FREQ's:
 * always - changes every time it's loaded
 * hourly
 * daily
 * weekly
 * monthly
 * yearly
 * never - archived pages
 */
function getDateString($epoch) {
  // YYYY-MM-DDThh:mm:ss.sTZD (eg 1997-07-16T19:20:30.45+01:00)
  return (new DateTime("@$epoch"))->format("Y-m-d\TH:i:sP");
}
$app->response->mime = 'xml';
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
$url = "http://fisherevans.com/";
$pages = array();

/* ##### STATIC PAGES ##### */

$about = collection('Static Content')->findOne(['name_slug'=>'about-page']);
$pages[] = [
    'loc'=>'',
    'lastmod'=>getDateString($about['modified']),
    'changefreq'=>'monthly',
    'priority'=>0.75
];

$contact = collection('Static Content')->findOne(['name_slug'=>'contact-me']);
$pages[] = [
    'loc'=>'contact',
    'lastmod'=>getDateString($contact['modified']),
    'changefreq'=>'weekly',
    'priority'=>0.75
];

$resources = collection('Static Content')->findOne(['name_slug'=>'resources']);
$pages[] = [
    'loc'=>'resources',
    'lastmod'=>getDateString($resources['modified']),
    'changefreq'=>'monthly',
    'priority'=>0.5
];

$credits = collection('Static Content')->findOne(['name_slug'=>'credits']);
$pages[] = [
    'loc'=>'credits',
    'lastmod'=>getDateString($credits['modified']),
    'changefreq'=>'monthly',
    'priority'=>0.25
];

/* ##### BLOG POSTS ##### */

$lastBlogModified = 0;

global $blogPostsPerPage;

$postsCollection = collection('Blog Posts');
$postCount = $postsCollection->count(["published"=>true]);
$blogPageCount = ceil($postCount/$blogPostsPerPage);
$posts = $postsCollection->find(["published"=>true])->toArray();

foreach($posts as $post) {
  $pages[] = [
      'loc'=>'blog/post/' . $post['title_slug'],
      'lastmod'=>getDateString($post['modified']),
      'changefreq'=>'weekly',
      'priority'=>0.85
  ];
  if($post['modified'] > $lastBlogModified)
    $lastBlogModified = $post['modified'];
}
for($blogPageId = 1;$blogPageId <= $blogPageCount;$blogPageId++) {
  $pages[] = [
      'loc'=>'blog/recent/' . $blogPageId,
      'lastmod'=>getDateString($lastBlogModified),
      'changefreq'=>'weekly',
      'priority'=>0.5
  ];
}

/* ##### TAGS ##### */

$tagsCollection = collection('Tags');
$tags = $tagsCollection->find()->toArray();
foreach($tags as $tag) {
  $tagIds = [$tag['_id']];
  $tagPostsCollection = collection('Blog Posts');
  $tagPostCount = $tagPostsCollection->count(function($post) use($tagIds) {
    return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && isset($post['published']) && $post['published'] == true;
  });
  $tagPageCount = ceil($tagPostCount/$blogPostsPerPage);
  for($tagPageId = 1;$tagPageId <= $tagPageCount;$tagPageId++) {
    $pages[] = [
        'loc'=>'blog/tag/' . $tag['name_slug'] . '/' . $tagPageId,
        'lastmod'=>getDateString($lastBlogModified),
        'changefreq'=>'weekly',
        'priority'=>0.5
    ];
  }
}

$pages[] = [
    'loc'=>'blog',
    'lastmod'=>getDateString($lastBlogModified),
    'changefreq'=>'monthly',
    'priority'=>0.75
];

/* ##### PROJECTS ##### */

$lastProjectModified = 0;
$projects = collection('Projects')->find(["published"=>true])->toArray();
foreach($projects as $project) {
  $pages[] = [
      'loc'=>'projects/' . $project['name_slug'],
      'lastmod'=>getDateString($project['modified']),
      'changefreq'=>'weekly',
      'priority'=>0.85
  ];
  if($project['modified'] > $lastProjectModified)
    $lastProjectModified = $project['modified'];
}

$pages[] = [
    'loc'=>'projects',
    'lastmod'=>getDateString($lastProjectModified),
    'changefreq'=>'weekly',
    'priority'=>0.75
];

/* ##### PRINT OUTS ##### */

foreach($pages as $page) {
  echo "  <url>\n";
  echo "    <loc>" . $url . $page['loc'] . "</loc>\n";
  echo "    <lastmod>" . $page['lastmod'] . "</lastmod>\n";
  echo "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
  echo "    <priority>" . $page['priority'] . "</priority>\n";
  echo "  </url>\n";
}

echo '</urlset>';