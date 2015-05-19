<?php
  $parsedown = new Parsedown();
?>
<div class="contentBlock">

  <h1><?php echo $post['title']; ?></h1>
  <?php include('snippets/postInfo.php'); ?>
  <div class="postIntro">
    <?php echo $parsedown->text($post['intro']); ?>
  </div>
  <div class="postContent">
    <?php echo $parsedown->text($post['content']); ?>
  </div>
</div>
<textarea><?php print_r($post); ?></textarea>