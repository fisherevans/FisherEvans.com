<?php
$parseDown = new ParsedownExtra();
?>
<div class="section" itemscope itemtype="http://schema.org/<?=$staticContent['itemtype']?>">
  <h1 itemprop="name"><?=$staticContent['name']?></h1>
  <div itemprop="text">
    <?=$parseDown->text($staticContent['content'])?>
  </div>
</div>
