<?php
  $parsedown = new Parsedown();
?>
<div class="contentBlock blogPost">
  <div class="cookieCrumbs">
    <a href="<?=$this->route("/blog");?>" class="cookieCrumb fadeColors">Blog Index</a>
    <div class="cookieCrumb separator flaticon-fast44"></div>
    <a href="<?=$this->route("/blog/recent/1");?>" class="cookieCrumb fadeColors">Recent Posts</a>
    <div class="cookieCrumb separator flaticon-fast44"></div>
    <div class="cookieCrumb current">View Post</div>
  </div>
  <h1><?php echo $post['title']; ?></h1>
  <?php include('snippets/postInfo.php'); ?>
  <!--<div class="postIntro">
    <?php echo $parsedown->text($post['intro']); ?>
  </div>-->
  <div class="postContent">
    <?php echo $parsedown->text($post['content']); ?>
  </div>
</div>
<div class="contentBlock blogDiscussion">
  <div id="disqus_thread"></div>
</div>
<script type="text/javascript">
  var disqus_shortname = 'fisherevans';
  var disqus_identifier = '<?php echo $post['title_slug']; ?>';
  var disqus_title = '<?php echo $post['title']; ?>';
  var disqus_url = window.location.href ;
  (function() {
    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
  })();
</script>