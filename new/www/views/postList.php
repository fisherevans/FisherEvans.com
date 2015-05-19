<?php
  $parsedown = new Parsedown();
?>
<div class="contentBlock">
  <h1>Blog Posts</h1>

  <?php foreach ($posts as $post): ?>
      <h2><a href="<?php $this->route('/blog/post/'.$post['title_slug']); ?>"><?php echo $post['title']; ?></a></h2>
      <?php include('snippets/postInfo.php'); ?>
      <p><?php echo $parsedown->text($post['intro']); ?></p>
  <?php endforeach; ?>
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