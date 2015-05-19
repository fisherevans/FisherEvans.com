<?php
  function printNav($label, $link, $active) {
    global $currentPage;
    $activeClass = $active ? 'active' : '';
    ?>
      <a class="navElement fadeColors <?=$activeClass?>" href="<?=$link?>"><?=$label?>
        <div class="arrowBox">
            <span class="flaticon-fast44 arrow"></span>
        </div>
      </a>
    <?php
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700|Roboto+Slab:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/lib/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="/lib/highlight/styles/idea.css">

    <link rel="stylesheet" type="text/css" href="/css/base.css" media="(min-width: 0px)" />
    <link rel="stylesheet" type="text/css" href="/css/mobile.css" media="(max-width: 799px)" />
    <link rel="stylesheet" type="text/css" href="/css/desktop.css" media="(min-width: 800px)" />
    <link rel="stylesheet" type="text/css" href="/css/desktop_big.css" media="(min-width: 1100px)" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($title) ? $title . ' | ' : ''; ?>Fisher Evans</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
  </head>
  <body>
    <div class="navPane">
      <img class="logo" src="/img/logo.png" />
      <div class="menuBox fadeColors noTextSelect">
        <img class="menuIcon fadeOpacityRotation" src="/img/menu.png"></img>
        <img class="closeMenuIcon fadeOpacityRotation" src="/img/close_menu.png"></img>
      </div>
      <div class="nav fadeMaxHeightBorder">
        <?php
          printNav("Fisher Evans", "/",            isset($currentPage) && $currentPage == "about");
          printNav("Blog",         "/blog/page/1", isset($currentPage) && $currentPage == "blog");
          printNav("Projects",     "/projects",    isset($currentPage) && $currentPage == "projects");
          printNav("Resume",       "/resume",      isset($currentPage) && $currentPage == "resume");
          printNav("Resources",    "/resources",   isset($currentPage) && $currentPage == "resources");
        ?>
      </div>
      <div class="connect">
        <a class="icon fadeColors flaticon-gmail3"      target="_blank" alt="Email Address"       href="mailto:contact@fisherevans.com"></a>
        <a class="icon fadeColors flaticon-linkedin12"  target="_blank" alt="LinkedIn Profile"    href="https://www.linkedin.com/in/fisherevans/"></a>
        <a class="icon fadeColors flaticon-github8"     target="_blank" alt="GitHub Account"      href="https://github.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-twitter13"   target="_blank" alt="Twitter Feed"        href="https://twitter.com/FisherEvans"></a>
        <a class="icon fadeColors flaticon-facebook29"  target="_blank" alt="Facebook Page"       href="https://www.facebook.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-google110"   target="_blank" alt="Google Plus Profile" href="https://plus.google.com/+FisherEvans/posts"></a>
        <a class="icon fadeColors flaticon-magnifier13" target="_blank" alt="Google Search Me"    href="http://lmgtfy.com/?q=Fisher+Evans+software+engineer"></a>
      </div>
      <a class="contact fadeColors" href="/contact">Contact Me</a>
    </div>
    <div class="contentPane">
      <?php echo $content_for_layout; ?>
    </div>
    <div class="sidePane">
      Dummy data... Dummy data... Dummy data... Dummy data... Dummy data... Dummy data... 
    </div>
    <script type="text/javascript" src="/lib/highlight/highlight.pack.js"></script>
    <script type="text/javascript" src="/lib/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
  </body>
</html>