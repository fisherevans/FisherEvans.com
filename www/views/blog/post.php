<?php
global $url;
$parsedown = new ParsedownExtra();
?>
<div class="section blogPost" itemscope itemtype="http://schema.org/WebPage">
  <div class="cookieCrumbs" itemprop="breadcrumb">
    <a href="<?=$url?><?=$this->route("/blog");?>" class="cookieCrumb fadeColors">Blog Index</a>
    <div class="cookieCrumb separator">&raquo;</div>
    <a href="<?=$url?><?=$this->route("/blog/recent/1");?>" class="cookieCrumb fadeColors">Recent Posts</a>
    <div class="cookieCrumb separator">&raquo;</div>
    <div class="cookieCrumb current">View Post</div>
  </div>
  <div itemscope itemtype="http://schema.org/BlogPosting">
    <h1 itemprop="name headline"><?php echo $post['title']; ?></h1>
    <?php include('snippets/postInfo.php'); ?>
    <p>
      Written by
      <span itemprop="author" itemscope="" itemtype="http://schema.org/Person">
        <span itemprop="name">
          <a itemprop="url" rel="author" href="https://plus.google.com/+FisherEvans">Fisher Evans</a>
        </span>
      </span>
    </p>
    <div class="postIntro" itemprop="description">
      <?php echo $parsedown->text($post['intro']); ?>
    </div>
    <img class="postPhoto" src="<?=$url?><?php echo str_replace("site:", "/", $post['image']);?>" alt="<?=$post['title']?> Banner Image" itemprop="image"/>
    <div class="postContent" itemprop="articleBody">
      <?php echo fixRelativeLinks($parsedown->text($post['content'])); ?>
    </div>
  </div>
  <p class="centered noBottomMargin">Like this content? Think about <a href="http://eepurl.com/bowcor" target="_blank" title="Subcribe to my blog">subscribing</a>.</p>
</div>
<div class="section blogDiscussion">
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