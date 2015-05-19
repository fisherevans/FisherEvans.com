<?php
  $parsedown = new Parsedown();
?>
<div class="contentBlock">
  <h3>Recent Posts</h3>

  <!--
  <?php foreach ($posts as $post) { ?>
      --><div class="postListBlock">
        <a href="/blog/post/<?php echo $post['title_slug']; ?>">
          <img class="coverPhoto fadeColors" src="<?php echo str_replace("site:", "/", $post['image']);?>" />
        </a>
        <a href="/blog/post/<?php echo $post['title_slug']; ?>">
          <h3 class="fadeColors"><?php echo $post['title']; ?></h3>
        </a>
        <?php include('snippets/postInfo.php'); ?>
        <div class="postListIntro">
          <?php echo $parsedown->text($post['intro']); ?>
        </div>
      </div><!--
  <?php } ?>
  -->
  <div class="pagination">
    <?php for($i=1;$i<=$pages;$i++): ?>

      <?php if($page==$i): ?>
          <span><?=$i;?></span>
      <?php else: ?>
          <a href="<?=$this->route("/blog/page/{$i}");?>"><?=$i;?></a>
      <?php endif; ?>

    <?php endfor; ?>
  </div>
</div>
<textarea><?php print_r($posts); ?></textarea>