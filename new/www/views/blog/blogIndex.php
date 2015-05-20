<div class="contentBlock">
  <div class="cookieCrumbs">
    <div class="cookieCrumb current">Blog Index</div>
  </div>
  <h2>Tags</h2>
  <ul>
    <?php
    $collection = collection('Tags');
    $tags = $collection->find()->toArray();
    foreach($tags as $tag) {
      echo "<li><a class='tag fadeColors' href='";
      $this->route("/blog/tag/".$tag['name_slug']);
      echo "'>{$tag['name']}</a></li>";
    }
    ?>
  </ul>
  <h2>All Posts</h2>
  <?php
  $parsedown = new Parsedown();
  $collection = collection('Blog Posts');
  $posts = $collection->find(['published'=>true])->sort(["created"=>-1])->toArray();
  $lastYear = null;
  $lastMonth = null;
  foreach($posts as $post) {
    $postDate = new DateTime("@" . $post['created']);
    $thisYear = $postDate->format('Y');
    $thisMonth = $postDate->format('F');
    if ($thisYear != $lastYear || $thisMonth != $lastMonth) {
      echo "<h3>" . $thisYear . " - " . $thisMonth . "</h3><ul>";
    }
    echo "<div><a class='tag fadeColors' href='";
    $this->route("/blog/post/".$post['title_slug']);
    echo "'>{$post['title']}</a>";
    include('snippets/postInfo.php');
    echo $parsedown->text($post['intro']);
    echo "</div><br><br>";
    $lastYear = $thisYear;
    $lastMonth = $thisMonth;
  }
  ?>
</div>