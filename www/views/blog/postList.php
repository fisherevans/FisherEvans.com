<?php
global $url;
$parsedown = new ParsedownExtra();
?>
<div class="section">
  <div class="cookieCrumbs" itemprop="breadcrumb">
    <a rel="home" href="<?=$url?><?=$this->route("/blog");?>" class="cookieCrumb fadeColors">Blog Index</a>
    <div class="cookieCrumb separator">&raquo;</div>
    <?php if(isset($filterTag)) { ?>
      <a href="<?=$url?><?=$this->route("/blog/recent/1");?>" class="cookieCrumb fadeColors">Recent Posts</a>
      <div class="cookieCrumb separator">&raquo;</div>
      <h1 class="cookieCrumb current">Tagged: <?php echo $filterTag['name']; ?></h1>
    <?php } else { ?>
      <h1 class="cookieCrumb current">Recent Posts</h1>
    <?php } ?>
  </div>
  <?php
    if(isset($filterTag)) {
      $project = collection('Projects')->findOne(["published"=>true, "tag"=>$filterTag['_id']]);
      if(isset($project)) {
        ?>
        <h2><?=$project['name']?></h2>
        <p>This tag is related to the project <a href="<?=$url?>/projects/<?=$project['name_slug']?>"><?=$project['name']?></a>. <?=$project['description']?></p>
        <?php
      }
    }
  ?>
  <div class="postListBlocks" itemscope itemtype="http://schema.org/Blog">
    <!--
    <?php
      if(count($posts) == 0) {
        ?>--><h2>Empty...</h2><p>Looks like I haven't posted anything here yet.<!--<?php
      } else {
          $first = true;
          $left = true;
          foreach ($posts as $post) {
            if($left && !$first) {
              echo '--><div class="hhr"></div><div class="hhr"></div><!--';
            }
            ?>
           --><div class="postListBlock <?php echo ($left ? 'left' : 'right'); ?>" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
          <a href="<?=$url?><?=$this->route("/blog/post/" . $post['title_slug']);?>">
            <img class="coverPhoto fadeColors" src="<?=$url?><?php echo str_replace("site:", "/", $post['image']);?>" alt="<?=$post['title']?> Banner Image" itemprop="image"/>
          </a>
          <a href="<?=$url?><?=$this->route("/blog/post/" . $post['title_slug']);?>">
            <h3 class="fadeColors" itemprop="name headline"><?php echo $post['title']; ?></h3>
          </a>
          <?php include('snippets/postInfo.php'); ?>
          <div class="postListIntro" itemprop="description">
            <?php echo fixRelativeLinks($parsedown->text($post['intro'])); ?>
          </div>
        </div><!--
          <?php
        $left = !$left;
        $first = false;
        }
      }
    ?>
    -->
  </div>
  <?php if($pages > 0) { ?>
    <div class="paginationLabel">Page Selection</div>
    <div class="pagination">
      <?php for($i=1;$i<=$pages;$i++) { ?>
        <?php if($page==$i) { ?>
            <span class="pageNumber"><?=$i;?></span>
        <?php } else if(isset($filterTag)) { ?>
          <a class="pageNumber fadeColors" href="<?=$url?><?=$this->route("/blog/tag/" . $filterTag['name_slug'] . "/" . $i);?>"><?=$i;?></a>
          <?php } else { ?>
          <a class="pageNumber fadeColors" href="<?=$url?><?=$this->route("/blog/recent/" . $i);?>"><?=$i;?></a>
          <?php } ?>
      <?php } ?>
      </div>
    <?php } ?>
  </div>
