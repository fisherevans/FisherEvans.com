<div class="postInfo">
  <div class="postDate">
    <span class="flaticon-calendar51 dateIcon"></span>
    <div class="postInfoData"><?php echo date('M j, Y', $post['created']); ?></div>
  </div>
  <div class="postTags">
    <div class="postInfoData">
      <?php
        $first = true;
        foreach($post['tags'] as $tagId) {
          $tag = collection('Tags')->findOne(['_id'=>$tagId]);
          if($first == false)
            echo ', ';
          echo '<a class="tag" href="/blag/tag/' . $tag['name_slug'] . '">' . $tag['name'] . '</a>';
          $first = false;
        }
      ?>
    </div>
    <span class="flaticon-shoppingstore7 tagIcon"></span></div>
  <div style="clear:both"></div>
</div>