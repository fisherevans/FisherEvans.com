<?php
  global $url;
  if(!isset($description))
    $description = 'The website of Fisher Evans, a full-stack Software Engineer in the greater Burlington, Vermont area.';
  if(isset($title))
    $title = $title . ' | Fisher Evans';
  else
    $title = 'Fisher Evans';
  function printNav($label, $link, $active, $newTab = false, $mobileOnly = false) {
    global $currentPage;
    $mobileClass = $mobileOnly ? ' mobileOnly' : '';
    $activeClass = $active ? ' active' : '';
    $target = $newTab ? '_blank' : '_self';
    $title = $newTab ? 'Opens a new tab' : '';
    echo "        ";
    echo "<a class='navElement fadeColors$activeClass$mobileClass' title='$title' target='$target' href='$link'>$label";
    if($newTab)
      echo '<span class="flaticon-back57 newTabIcon"></span>';
    echo "<div class='arrowBox'><span class='flaticon-fast44 arrow'></span></div></a>\n";
  }
?><!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="<?=$url?>/img/favicon.png?2015.06.08">
    <title><?=$title?></title>
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
    <!-- Third Party Resources -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900%7CRoboto+Slab:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/lib/flaticon/flaticon.css?2015.06.08">
    <link rel="stylesheet" type="text/css" href="/lib/highlight/styles/idea.css?2015.06.08">
    <!-- Styling -->
    <link rel="stylesheet" type="text/css" href="/css/base.css?2015.06.08-2"    media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/mobile.css?2015.06.08-2"  media="screen and (max-width: 799px)" />
    <link rel="stylesheet" type="text/css" href="/css/desktop.css?2015.06.08-2" media="screen and (min-width: 800px)" />
    <link rel="stylesheet" type="text/css" href="/css/print.css?2015.06.08-2"   media="print" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <!-- Content -->
    <div class="printHeader"><?=$title?></div>
    <div class="article">
<?php echo $content_for_layout; ?>
    </div>
    <!-- Footer -->
    <div class="footer">
      This site and its contents are Copyright &copy; <span class="noBreak">David Fisher Evans <?=date('Y')?>, all rights reserved.</span><br>
      Credit where credit is due; here's some <span class="noBreak"><a href="<?=$url?>/credits">licensing information</a>.</span>
    </div>
    <p class="printFooter">
      Copyright &copy; <?php echo date('Y'); ?> David Fisher Evans<br>
      Page accessed: <?php echo date('Y-m-d g:i A'); ?><br>
      fisherevans.com<?=$_SERVER['REQUEST_URI']?>
    </p>
    <!-- Navigation -->
    <div class="sideBar">
      <img class="logo" src="<?=$url?>/img/logo.png" alt="FisherEvans.com Logo" />
      <div class="navToggle fadeColors noTextSelect">
        <img class="fadeOpacityRotation openMenuIcon"      src="<?=$url?>/img/menu.png"       alt="Open Menu"/>
        <img class="fadeOpacityRotation closeMenuIcon" src="<?=$url?>/img/close_menu.png" alt="Close Menu"/>
      </div>
      <div class="navigation fadeMaxHeightBorder">
        <?php
        printNav("Fisher Evans", $url."/",                         isset($currentPage) && $currentPage == "about");
        printNav("Blog",         $url."/blog/recent/1",            isset($currentPage) && $currentPage == "blog");
        printNav("Projects",     $url."/projects",                 isset($currentPage) && $currentPage == "projects");
        printNav("Resources",    $url."/resources",                isset($currentPage) && $currentPage == "resources");
        printNav("Resume",       "http://resume.fisherevans.com/", isset($currentPage) && $currentPage == "resume",  true);
        printNav("Contact Me",   $url."/contact",                  isset($currentPage) && $currentPage == "contact", false, true);
        ?>
      </div>
      <a class="subscribe fadeColors" href="http://eepurl.com/bowcor" target="_blank">Subscribe to my blog</a>
      <div class="connect">
        <a class="icon fadeColors flaticon-gmail3"      target="_blank" title="Email Address"       href="mailto:contact@fisherevans.com"></a>
        <a class="icon fadeColors flaticon-linkedin12"  target="_blank" title="LinkedIn Profile"    href="https://www.linkedin.com/in/fisherevans/"></a>
        <a class="icon fadeColors flaticon-github8"     target="_blank" title="GitHub Account"      href="https://github.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-twitter13"   target="_blank" title="Twitter Feed"        href="https://twitter.com/FisherEvans"></a>
        <a class="icon fadeColors flaticon-facebook29"  target="_blank" title="Facebook Page"       href="https://www.facebook.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-google110"   target="_blank" title="Google Plus Profile" href="https://plus.google.com/+FisherEvans/posts"></a>
        <a class="icon fadeColors flaticon-500px5"      target="_blank" title="500px Profile"       href="https://500px.com/fisherevans"></a>
        <a class="icon fadeColors flaticon-magnifier13" target="_blank" title="Google Search Me"    href="http://lmgtfy.com/?q=Fisher+Evans+software+engineer"></a>
      </div>
      <a class="contact fadeColors" href="<?=$url?>/contact">Contact Me</a>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="/lib/highlight/highlight.pack.js?2015.06.08"></script>
    <script type="text/javascript" src="/lib/jquery/jquery-2.1.4.min.js?2015.06.08"></script>
    <script>
      $(document).ready(function() {
        $('pre code').each(function(i, block) {
          hljs.highlightBlock(block);
        });
        $('.navToggle').on('click', function(event) {
          $('.sideBar').toggleClass('expanded');
        });
        $(window).on('resize', function(event) {
          if($(window).width() > 800)
            $('.navPane').removeClass('expanded');
        });
      });
    </script>
    <script type="application/ld+json">
      { "@context" : "http://schema.org",
        "@type" : "Person",
        "name" : "Fisher Evans",
        "url" : "http://fisherevans.com",
        "sameAs" : [ "https://www.linkedin.com/in/fisherevans/",
                     "https://twitter.com/FisherEvans",
                     "https://www.facebook.com/fisherevans",
                     "https://plus.google.com/+FisherEvans/posts"
        ]
      }
    </script>
    <?=collection('Static Code')->findOne('footer')['code']?>
  </body>
</html>