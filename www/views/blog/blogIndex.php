<?php
  global $url;
?>
<div class="section" itemscope itemtype="http://schema.org/WebPage">
  <div class="cookieCrumbs" itemprop="breadcrumb">
    <h1 rel="home" itemprop="name" class="cookieCrumb current">Blog Index</h1>
  </div>
  <p class="subscribeText"><a class="fadeColors" href="http://eepurl.com/bowcor" target="_blank" title="Subcribe to my blog">Subscribe</a> to my blog.</p>
  <h2 class="noTopMargin">Recent Posts</h2>
  <p>To find the posts I've recently made in all tag categories, click here: <a href="<?=$url?><?=$this->route("/blog/recent/1")?>">View Recent Posts</a>. There is also an <a href="<?=$url?>/blog/rss">RSS Feed</a> if you'd like to follow my blog in a feed reader.</p>
  <h2>Browse by Tag</h2>
  <div class="indexTags">
    <?php
    $collection = collection('Tags');
    $tags = $collection->find()->sort(["name"=>1])->toArray();
    foreach($tags as $tag) {
      $tagIds = [$tag['_id'] ];
      $count = collection('Blog Posts')->count(function($post) use($tagIds) {
        return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && $post['published'] == true;
      });
      if($count == 0)
        continue;
      echo "<a class='indexTag fadeColors' href='" . $url;
      $this->route("/blog/tag/".$tag['name_slug']."/1");
      echo "'>";
      echo "<img src='$url/img/left_tag.png' class='indexTagTriangle' alt='Tag Background Image' />";
      echo "<span class='indexTagName'>{$tag['name']}</span>";
      echo "<span class='indexTagCount'>{$count}</span></a>";
    }
    ?>
  </div>
  <h2>Post Archive</h2>
  <div itemscope itemtype="http://schema.org/Blog">
    <?php
    $parsedown = new ParsedownExtra();
    $collection = collection('Blog Posts');
    $posts = $collection->find(['published'=>true])->sort(["posted_date"=>-1])->toArray();
    $lastYear = null;
    $lastMonth = null;
    foreach($posts as $post) {
      $postDate = new DateTime("@" . strtotime($post['posted_date']));
      $thisYear = $postDate->format('Y');
      $thisMonth = $postDate->format('F');
      if ($thisYear != $lastYear || $thisMonth != $lastMonth) {
        if($lastYear != null)
          echo "</div>";
        echo "<h3 class='archivedPostHeader'>" . $thisMonth . ", " . $thisYear . "</h3><div class='archivedPosts'>";
      }
      echo "<div class='archivedPost' itemprop='blogPosts' itemscope itemtype='http://schema.org/BlogPosting'><a class='archiveTitle fadeColors' href='" . $url;
      $this->route("/blog/post/".$post['title_slug']);
      echo "'><h4 class='archiveTitleHeader fadeColors' itemprop='name'>{$post['title']}</h4></a>";
      include('snippets/postInfo.php');
      echo '<div class="archiveIntro" itemprop="description">' . fixRelativeLinks($parsedown->text($post['intro'])) . '<a class="archiveReadMore" href="' . $url;
      $this->route("/blog/post/".$post['title_slug']);
      echo '">Read more...</a></div>';
      echo "</div>";
      $lastYear = $thisYear;
      $lastMonth = $thisMonth;
    }
    if($lastYear != null)
      echo "</div>";
    ?>
  </div>
</div>