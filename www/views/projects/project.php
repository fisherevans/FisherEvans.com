<?php
  global $url;
  $parsedown = new ParsedownExtra();
  $tag = collection('Tags')->findOne(['_id'=>$project['tag']]);
  $tagIds = [ $tag['_id'] ];
  $postCount = collection('Blog Posts')->count(function($post) use($tagIds) {
    return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && $post['published'] == true;
  });
?>
<div class="section" itemscope itemtype="http://schema.org/WebPage">
  <div class="cookieCrumbs" itemprop="breadcrumb">
    <a href="<?=$url?><?=$this->route("/projects");?>" class="cookieCrumb fadeColors">Projects</a>
    <div class="cookieCrumb separator">&raquo;</div>
    <div class="cookieCrumb current"><?=$project['name']?></div>
  </div>
  <img itemprop="image" class="projectPhoto" src="<?=$url?><?php echo str_replace("site:", "/", $project['image']);?>" alt="<?=$project['name']?> Logo" />
  <h1 itemprop="name" class="projectName"><?=$project['name']?></h1>
  <div itemprop="description" class="projectIntro"><?=fixRelativeLinks($parsedown->text($project['description']))?></div>
  <div itemprop="text" class="projectContent"><?=fixRelativeLinks($parsedown->text($project['content']))?></div>
  <div class="clearFix"></div>
  <?php if($postCount > 0) {
    $posts = collection("Blog Posts")->find(function($post) use($tagIds) {
      return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && isset($post['published']) && $post['published'] == true;
    });
    $posts->limit(3);
    $posts->sort(["posted_date"=>-1]);
    ?>
    <div class="hr"></div>
    <h3>Recent Blog Posts</h3>
    <p>
      Here are the most recent posts I've made relating to this project.
      You can see all posts tagged with <?=$tag['name']?> <a href="<?=$url?>/blog/tag/<?=$tag['name_slug']?>/1">here</a>.
    </p>
    <div class="archivedPosts" itemscope itemtype="http://schema.org/Blog">
      <?php
      foreach($posts->toArray() as $post) {
        echo "<div class='archivedPost' itemprop='blogPosts' itemscope itemtype='http://schema.org/BlogPosting'><a class='archiveTitle fadeColors' href='$url";
        $this->route("/blog/post/".$post['title_slug']);
        echo "'><h4 class='archiveTitleHeader fadeColors' itemprop='name'>{$post['title']}</h4></a>";
        include(dirname(__DIR__).'/blog/snippets/postInfo.php');
        echo '<div class="archiveIntro" itemprop="description">' . fixRelativeLinks($parsedown->text($post['intro'])) . '<a class="archiveReadMore" href="' . $url;
        $this->route("/blog/post/".$post['title_slug']);
        echo '">Read more...</a></div>';
        echo "</div>";
      }
      ?>
    </div>
  <?php } ?>
</div>