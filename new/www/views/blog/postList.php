<?php
  $parsedown = new ParsedownExtra();
?>
<div class="contentBlock">
  <div class="cookieCrumbs">
    <a href="<?=$this->route("/blog");?>" class="cookieCrumb fadeColors">Blog Index</a>
    <div class="cookieCrumb separator flaticon-fast44"></div>
    <?php if(isset($filterTag)) { ?>
      <a href="<?=$this->route("/blog/recent/1");?>" class="cookieCrumb fadeColors">Recent Posts</a>
      <div class="cookieCrumb separator flaticon-fast44"></div>
      <h1 class="cookieCrumb current">Tagged: <?php echo $filterTag['name']; ?></h1>
    <?php } else { ?>
      <h1 class="cookieCrumb current">Recent Posts</h1>
    <?php } ?>
  </div>
    <!--
    <?php
      if(count($posts) == 0) {
        ?>--><h2>Empty...</h2><p>Looks like I haven't posted anything here yet.<!--<?php
      } else {
          $left = true;
          foreach ($posts as $post) { ?>
           --><div class="postListBlock <?php echo ($left ? 'left' : 'right'); ?>">
          <a href="<?=$this->route("/blog/post/" . $post['title_slug']);?>">
            <img class="coverPhoto fadeColors" src="<?php echo str_replace("site:", "/", $post['image']);?>" />
          </a>
          <a href="<?=$this->route("/blog/post/" . $post['title_slug']);?>">
            <h3 class="fadeColors"><?php echo $post['title']; ?></h3>
          </a>
          <?php include('snippets/postInfo.php'); ?>
          <div class="postListIntro">
            <?php echo $parsedown->text($post['intro']); ?>
          </div>
        </div><!--
          <?php
        $left = !$left;
        }
      }
    ?>
    -->
  <div class="paginationLabel">Page Selection</div>
  <div class="pagination">
    <?php for($i=1;$i<=$pages;$i++) { ?>
      <?php if($page==$i) { ?>
          <span class="pageNumber"><?=$i;?></span>
      <?php } else if(isset($filterTag)) { ?>
        <a class="pageNumber fadeColors" href="<?=$this->route("/blog/tag/" . $filterTag['name_slug'] . "/" . $i);?>"><?=$i;?></a>
        <?php } else { ?>
        <a class="pageNumber fadeColors" href="<?=$this->route("/blog/recent/" . $i);?>"><?=$i;?></a>
        <?php } ?>
    <?php } ?>
  </div>
