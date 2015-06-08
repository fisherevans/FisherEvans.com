<?php
  function displayProjects($projects) {
    $parsedown = new ParsedownExtra();
    foreach($projects as $project) {
      $tag = collection('Tags')->findOne(['_id'=>$project['tag']]);
      $tagIds = [ $tag['_id'] ];
      $postCount = collection('Blog Posts')->count(function($post) use($tagIds) {
        return count(array_intersect($tagIds, $post['tags']))===count($tagIds) && $post['published'] == true;
      });
      ?>
      <div class="projectListBlock fadeColorShadow">
        <div class="intro">
          <a href="/projects/<?=$project['name_slug']?>"><h2 class="name fadeColors"><?=$project['name']?></h2></a>
          <div class="text"><?php echo $parsedown->text($project['description']); ?></div>
          <p>
            <a class="normalLink floatLeft" href="/projects/<?=$project['name_slug']?>">Read More</a>
            <?php if($postCount) { ?>
              <a class="normalLink floatRight" href="/blog/tag/<?=$tag['name_slug']?>/1">View Related Posts</a>
            <?php } else { ?>
              <span class="floatRight lightGrayColor">No Related Posts</span>
            <?php } ?>
          </p>
          <div class="clearFix"></div>
        </div>
        <a class="cover" href="/projects/<?=$project['name_slug']?>">
          <img src="<?php echo str_replace("site:", "/", $project['image']);?>" alt="<?=$project['name']?> Logo" />
        </a>
      </div>
    <?php
    }
  }
?>

<div class="section">
  <div class="cookieCrumbs">
      <h1 class="cookieCrumb current">Projects</h1>
  </div>
  <p>
    Below is a list of personal (and maybe some group) projects that I thought deserved their own page. Feel free to <a href="/contact">contact me</a> if you'd like to know more about a certain project or endeavor.
  </p>
  <h3>Featured Project<?=count($featured) > 1 ? 's' : ''?></h3>
  <?php displayProjects($featured); ?>
  <h3>Other Projects</h3>
  <?php displayProjects($nonFeatured); ?>
</div>