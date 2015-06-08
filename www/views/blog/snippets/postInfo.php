<div class="postInfo">
  <div class="postDate">
    <span class="flaticon-calendar51 dateIcon"></span>
    <div class="postInfoData" datetime="<?=(new DateTime())->format("Y-m-d\TH:i")?>2011-05-17T22:00" itemprop="datePublished"><?php echo date('M j, Y', strtotime($post['posted_date'])); ?></div>
  </div><!--
  --><div class="postTags">
    <div class="postInfoData">
      <?php include('postTags.php'); ?>
    </div>
    <span class="flaticon-shoppingstore7 tagIcon"></span></div>
  <div style="clear:both"></div>
</div>