<?php
    // ###################  ERROR Checking
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    /**/
    
    
    ############################### GLOBAL VARIABLES
    $blogPageSize = 4;
    $defaultPage = "/blog";
    $footRecentSize = 6;
    $defaultProjectImage = "img/default_project.png";
    
    
    ############################## GLOBAL INCLUDES
    include('css/colors.php');
    include('mobile_check.php'); // $mobile_browser > 0 IF on mobile device
    include('functions.php');
    
    
    ############################### NICE LOOKING URLS
    $url = explode('?', $_SERVER['REQUEST_URI']);
    if(sizeof($url) === 2)
        $get = $url[1];
    $uri = explode('/', $url[0]);
    array_shift($uri);
    $resource = array_shift($uri);
    
    if($resource === "")
    {
        $resource = 'blog';
    }
    else if($resource === "admin")
    {
        include("admin.php");
        exit;
    }
    else if($resource === "d")
    {
        include("dir/index.php");
        exit;
    }
    
    
    ############################### MYSQL CONNECT
    mysql_connect("localhost", "fisherev_old", "OlD123$%^!@#456") or die("failed to connect to sql");#mysql_error());
    mysql_select_db("fisherev_old") or die("failed to connect to db");#mysql_error());
    
    ############################# STANDARD METHOD CALLS
	
    if($resource === "rss")
    {
		header ("Content-Type:text/xml"); 
        include("rss.php");
        exit;
    }
    
    ############################## TITLE SWITCH
    $title = "FisherEvans.com";
    switch($resource)
    {
        case "blog": $title = "Blog | " . $title; break;
        case "about": $title = "About | " . $title; break;
        case "resume": $title = "Resume | " . $title; break;
        case "projects": $title = "Projects | " . $title; break;
        default: $title = "404 | " . $title; break;
    }

    
    ############################ HTML HEADER
    echo '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" id="curedotorg"  xmlns:fb="http://ogp.me/ns/fb#" xmlns:og="http://ogp.me/ns#" lang="en-US">';
    echo '<head>';
    echo '<link rel="icon" type="image/gif" href="/favicon.gif">';
    echo '<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700,400italic" rel="stylesheet" type="text/css">';
    echo '<link href="/css/base_css.php" rel="stylesheet" type="text/css">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
    if($mobile_browser > 0) { echo '<link href="/css/mobile_css.php" rel="stylesheet" type="text/css">'; }
    echo '<title>' . $title . '</title>';
    echo '<script type="text/javascript" language="Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>';
    echo '<script type="text/javascript" language="Javascript" src="/js/dynamic_window.js"></script>';
    echo '</head>';
    
    
    ######################### BODY
    echo '<body onload="windowResize()">';


    ######################### GOOGLE ANAL
    include('google_anal.php');

    
    ######################### BANNER 
    echo '<div id="banner"><div id="header"><div id="logo_text">';
    echo '<a href="/"><span class="dark_green">FISHER</span> <span class="dark_red">EVANS</span></a></div>';
    echo '<div id="nav">';
    
    echo '<a class="nav_link ' . (($resource === "blog")?' current':'') . '" href="/blog">BLOG</a>';
    echo '<a class="nav_link ' . (($resource === "about")?' current':'') . '" href="/about">ABOUT</a>';
    echo '<a class="nav_link ' . (($resource === "resume")?' current':'') . '" href="/resume">RESUME</a>';
    echo '<a class="nav_link ' . (($resource === "projects")?' current':'') . '" href="/projects">PROJECTS</a>';
    
    echo '</div></div></div>';
    
    
    ############################### CONTENT
    echo '<div id="content">';
    
    $content_file = "pages/" . $resource . ".php";
    if(!file_exists($content_file))
        include("pages/404.php");
    else
        include($content_file);
    
    echo '</div>';
    
    
    ################################## FOOTER
    echo '<div id="footer">';
    include('footer.php');
    echo '</div>';
    

    ###################################### HTML END
    echo '</body></html>';
?>