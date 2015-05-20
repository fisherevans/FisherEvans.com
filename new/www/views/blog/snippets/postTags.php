<?php
  $tags = $post['tags'];
  if(count($tags) == 1) {
    $tag = collection('Tags')->findOne(['_id'=>$tags[0]]);
    echo "<a class='tag fadeColors' href='";
    $this->route("/blog/tag/".$tag['name_slug']);
    echo "'>{$tag['name']}</a>";
  } else if(count($tags) == 0) {
    echo "Not tagged";
  } else {
    echo '<div class="multipleTags">Multiple Tags<div class="multipleTagsList fadeOpacityMaxHeight">';
    foreach($post['tags'] as $tagId) {
      $tag = collection('Tags')->findOne(['_id'=>$tagId]);
      echo "<a class='tag fadeColors' href='";
      $this->route("/blog/tag/".$tag['name_slug']);
      echo "'>{$tag['name']}</a>";
    }
    echo '</div></div>';
  }
?>