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
  <?php if($postCount > 0) { ?>
    <div class="hr"></div>
    <h3>Recent Blog Posts</h3>
    <p>
      Here are the most recent posts I've made relating to this project.
      You can see all posts tagged with <?=$tag['name']?> <a href="/blog/tag/<?=$tag['name_slug']?>/1">here</a>.
    </p>

  <?php } ?>
</div>