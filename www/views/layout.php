<?php
  if(!isset($description))
    $description = 'The website of Fisher Evans, a full-stack Software Engineer in the greater Burlington, Vermont area.';
  if(isset($title))
    $title = $title . ' | Fisher Evans';
  else
    $title = 'Fisher Evans';
  function printNav($label, $link, $active, $newTab = false, $mobileOnly = false) {
    global $currentPage;
    $mobileClass = $mobileOnly ? 'mobileOnly' : '';
    $activeClass = $active ? 'active' : '';
    $target = $newTab ? '_blank' : '_self';
    $title = $newTab ? 'Opens a new tab' : '';
    ?>
      <a class="navElement fadeColors <?=$activeClass?> <?=$mobileClass?>" title="<?=$title?>" target="<?=$target?>" href="<?=$link?>"><?=$label?>
        <?php
        if($newTab)
          echo '<span class="flaticon-back57 newTabIcon"></span>';
        ?>
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
    <title><?=$title?></title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <!-- SEO -->
    <meta name="description" content="<?=$description?>">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <link rel="author" href="https://plus.google.com/+FisherEvans"/>
    <!-- Facebook -->
    <meta property="og:title" content="<?=$title?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:description"  content="<?=$description?>">
    <!-- Twitter -->
    <meta name="twitter:title" content="<?=$title?>">
    <meta name="twitter:description"  content="<?=$description?>">
    <!-- Actual Resources -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Roboto+Slab:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/lib/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="/lib/highlight/styles/idea.css">

    <link rel="stylesheet" type="text/css" href="/css/base.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/mobile.css" media="screen and (max-width: 799px)" />
    <link rel="stylesheet" type="text/css" href="/css/desktop.css" media="screen and (min-width: 800px)" />
    <link rel="stylesheet" type="text/css" href="/css/print.css" media="print" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <h4 class="printHeader"><?=$title?></h4>
    <div class="navPane">
      <img class="logo" src="/img/logo.png" alt="FisherEvans.com Logo" />
      <div class="menuBox fadeColors noTextSelect">
        <img class="menuIcon fadeOpacityRotation" src="/img/menu.png" alt="Open Menu"></img>
        <img class="closeMenuIcon fadeOpacityRotation" src="/img/close_menu.png" alt="Close Menu"></img>
      </div>
      <div class="nav fadeMaxHeightBorder">
        <?php
          printNav("Fisher Evans", "/",                              isset($currentPage) && $currentPage == "about");
          printNav("Blog",         "/blog/recent/1",                 isset($currentPage) && $currentPage == "blog");
          printNav("Projects",     "/projects",                      isset($currentPage) && $currentPage == "projects");
          printNav("Resources",    "/resources",                     isset($currentPage) && $currentPage == "resources");
          printNav("Resume",       "http://resume.fisherevans.com/", isset($currentPage) && $currentPage == "resume",  true);
          printNav("Contact Me",   "/contact",                       isset($currentPage) && $currentPage == "contact", false, true);
        ?>
      </div>
      <a class="subscribe fadeColors" href="http://eepurl.com/bowcor" target="_blank">
        Subscribe to my blog
      </a>
      <div class="connect">
        <a class="icon fadeColors flaticon-gmail3"      target="_blank" alt="Email Address"       title="Email Address"       href="mailto:contact@fisherevans.com"></a>
        <a class="icon fadeColors flaticon-linkedin12"  target="_blank" alt="LinkedIn Profile"    title="LinkedIn Profile"    href="https://www.linkedin.com/in/fisherevans/"></a>
        <a class="icon fadeColors flaticon-github8"     target="_blank" alt="GitHub Account"      title="GitHub Account"      href="https://github.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-twitter13"   target="_blank" alt="Twitter Feed"        title="Twitter Feed"        href="https://twitter.com/FisherEvans"></a>
        <a class="icon fadeColors flaticon-facebook29"  target="_blank" alt="Facebook Page"       title="Facebook Page"       href="https://www.facebook.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-google110"   target="_blank" alt="Google Plus Profile" title="Google Plus Profile" href="https://plus.google.com/+FisherEvans/posts"></a>
        <a class="icon fadeColors flaticon-magnifier13" target="_blank" alt="Google Search Me"    title="Google Search Me"    href="http://lmgtfy.com/?q=Fisher+Evans+software+engineer"></a>
      </div>
      <a class="contact fadeColors" href="/contact">Contact Me</a>
    </div>
    <div class="contentPane">
      <?php echo $content_for_layout; ?>
      <footer>
        This site and its contents are Copyright &copy; <span class="noBreak">David Fisher Evans <?=date('Y')?>, all rights reserved.</span><br>
        Credit where credit is due; here's some <span class="noBreak"><a href="/credits">licensing information</a>.</span>
      </footer>
    </div>
    <p class="printSitePlug">
      Copyright &copy; <?php echo date('Y'); ?> David Fisher Evans<br>
      Page accessed: <?php echo date('Y-m-d g:i A'); ?><br>
      fisherevans.com<?=$_SERVER['REQUEST_URI']?>
    </p>
    <script type="text/javascript" src="/lib/highlight/highlight.pack.js"></script>
    <script type="text/javascript" src="/lib/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="http://s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script>
    <script>
      $(document).ready(function() {
        $('pre code').each(function(i, block) {
          hljs.highlightBlock(block);
        });
        $('.menuBox').on('click', function(event) {
          $('.navPane').toggleClass('expanded');
        });
        $(window).on('resize', function(event) {
          if($(window).width() > 800)
            $('.navPane').removeClass('expanded');
        });
      });
    </script>
    <?=collection('Static Code')->findOne('footer')['code']?>
  </body>
</html>