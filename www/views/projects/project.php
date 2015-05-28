<?php
  $parsedown = new ParsedownExtra();
  $tag = collection('Tags')->findOne(['_id'=>$project['tag']]);
  $tagIds = [ $tag['_id'] ];
  $postCount = collection('Blog Posts')->count(function($post) use($tagIds) {
    return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && $post['published'] == true;
  });
?>
<div class="contentBlock">
  <div class="cookieCrumbs">
    <a href="<?=$this->route("/projects");?>" class="cookieCrumb fadeColors">Projects</a>
    <div class="cookieCrumb separator flaticon-fast44"></div>
    <h1 class="cookieCrumb current"><?=$project['name']?></h1>
  </div>
  <img class="projectPhoto" src="<?php echo str_replace("site:", "/", $project['image']);?>" />
  <h1 class="projectName"><?=$project['name']?></h1>
  <div class="projectIntro"><?=$parsedown->text($project['description'])?></div>
  <div class="projectContent"><?=$parsedown->text($project['content'])?></div>
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
      You can see all posts tagged with <?=$tag['name']?> <a href="/blog/tag/<?=$tag['name_slug']?>/1">here</a>.
    </p>
    <div class="archivedPosts">
      <?php
      foreach($posts->toArray() as $post) {
        echo "<div class='archivedPost'><a class='archiveTitle fadeColors' href='";
        $this->route("/blog/post/".$post['title_slug']);
        echo "'><h4 class='archiveTitleHeader fadeColors'>{$post['title']}</h4></a>";
        include(dirname(__DIR__).'/blog/snippets/postInfo.php');
        echo '<div class="archiveIntro">' . $parsedown->text($post['intro']) . '<a class="archiveReadMore" href="';
        $this->route("/blog/post/".$post['title_slug']);
        echo '">Read more...</a></div>';
        echo "</div>";
      }
      ?>
    </div>
  <?php } ?>
</div>