<div class="contentBlock">
  <?php
    $parsedown = new ParsedownExtra();
    echo $parsedown->text($content);
  ?>
</div>