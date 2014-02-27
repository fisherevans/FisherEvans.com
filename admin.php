<?php
    
    ############################
    #echo("down"); exit();
    ############################
    
    
    /* ###################  ERROR Checking
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    /**/
    
    
    ############################### GLOBAL VARIABLES
    $defaultPage = "/admin/menu";
    $mainSite = "http://home.fisherevans.com:63933/";
    
    function getHref($line) {
        $line = preg_replace("/\[[a-z]+ +/", "", $line);
        $line = preg_replace("/ *\] */", "", $line);
        $line = preg_replace("/[\n\r]/", "", $line);
        return $line;
    }
    
    function parse($markup) {
        $content = "";
        $code = false;
        foreach(explode("\n", $markup) as $line) {
            if(strlen(trim($line)) > 0 || $code) {
                $newLine = true;
                $line = preg_replace("/\[([^\>]+)>([^\]]+)\]/", "<a href='\\2'>\\1</a>", $line);
                $line = preg_replace("/\[inline\-code\|([a-z]+)\|([^\]]+)\]/", "<code class='inline language-\\1'>\\2</code>", $line);
                if(strpos($line, "[/code]") === 0) {
                    $content .= "</code></pre>";
                    $code = false;
                } else if($code) {
                    $content .= $line;
                } else if(strpos($line, "---") === 0) {
                    $content .= "<h3>" . trim(substr($line, 3)) . "</h3>";
                } else if(strpos($line, "--") === 0) {
                    $content .= "<h2>" . trim(substr($line, 2)) . "</h2>";
                } else if(strpos($line, "-") === 0) {
                    $content .= "<h1>" . trim(substr($line, 1)) . "</h1>";
                } else if(strpos($line, "    -") === 0) {
                    $content .= "<span class='bullet'>&#8226; " . trim(substr($line, 5)) . "</span>";
                } else if(strpos($line, "#") === 0) {
                    $content .= "<!-- raw -->" . trim(substr($line, 1));
                } else if(strpos($line, ">>") === 0) {
                    $content .= "<p class='subtitle'>" . trim(substr($line, 2)) . "</p>";
                } else if(strpos($line, ">") === 0) {
                    $content .= "<p class='quote'>" . trim(substr($line, 1)) . "</p>";
                } else if(strpos($line, "[banner ") === 0) {
                    $content .= "<img class='banner' src='" . getHref($line) ."' />";
                } else if(strpos($line, "[portrait ") === 0) {
                    $content .= "<img class='portrait' src='" . getHref($line) ."' />";
                } else if(strpos($line, "[video ") === 0) {
                    $content .= "<iframe class='youtubeVideo' src='http://www.youtube.com/embed/";
                    $content .= getHref($line);
                    $content .= "' frameborder='0' allowfullscreen></iframe>";
                } else if(strpos($line, "[block]") === 0) {
                    $content .= "<div class='contentBlock'>";
                } else if(strpos($line, "[/block]") === 0) {
                    $content .= "</div><!-- end block -->";
                } else if(strpos($line, "[code ") === 0) {
                    $content .= "<pre><code class='language-" . getHref($line) . "'>";
                    $code = true;
                    $newLine = false;
                } else {
                    $content .= "<p>" . trim($line) . "</p>";
                }
                if($newLine)
                    $content .= "\n";
            }
        }
        if($code) {
            $content .= "</code></pre>";
        }
        return $content;
    }
    
    function unParse($content) {
        $markupRemake = "";
        $code = false;
        foreach(explode("\n", $content) as $line) {
            if(strlen(trim($line)) > 0 || $code) {
                $line = preg_replace("/<a href='([^']+)'>([^<]+)<\/a>/", "[\\2>\\1]", $line);
                $line = preg_replace("/<code class='inline language-([a-z]+)'>(.+)<\/code>/", "[inline-code|\\1|\\2]", $line);
                if(strpos($line, "</code></pre>") === 0) {
                    $markupRemake .= "[/code]";
                    $code = false;
                } else if(strpos($line, "<pre><code class='language-") === 0) {
                    $markupRemake .= preg_replace("/<pre><code class='language-([a-z]+)'>([^[(<\/code>)]+)/", "[code \\1]\n\\2", $line);
                    $code = true;
                } else if($code) {
                    $markupRemake .= $line;
                } else if(strpos($line, "<h3>") === 0) {
                    $markupRemake .= "---" . preg_replace("/<\/?h3>/", "", $line);
                } else if(strpos($line, "<h2>") === 0) {
                    $markupRemake .= "--" . preg_replace("/<\/?h2>/", "", $line);
                } else if(strpos($line, "<h1>") === 0) {
                    $markupRemake .= "-" . preg_replace("/<\/?h1>/", "", $line);
                } else if(strpos($line, "<span class='bullet'>&#8226; ") === 0) {
                    $markupRemake .= "    - " . preg_replace("/(<span class='bullet'>&#8226; |<\/span>)/", "", $line);
                } else if(strpos($line, "<p class='subtitle'>") === 0) {
                    $markupRemake .= ">>" . preg_replace("/<\/?p[^>]*>/", "", $line);
                } else if(strpos($line, "<p class='quote'>") === 0) {
                    $markupRemake .= ">" . preg_replace("/<\/?p[^>]*>/", "", $line);
                } else if(strpos($line, "<p>") === 0) {
                    $markupRemake .= preg_replace("/<\/?p[^>]*>/", "", $line);
                } else if(strpos($line, "<img class='banner'") === 0) {
                    $markupRemake .= preg_replace("/<img class='banner' src='([^']+)' \/>/", "[banner \\1]", $line);
                } else if(strpos($line, "<img class='portrait'") === 0) {
                    $markupRemake .= preg_replace("/<img class='portrait' src='([^']+)' \/>/", "[portrait \\1]", $line);
                } else if(strpos($line, "<iframe class='youtubeVideo'") === 0) {
                    $markupRemake .= preg_replace("/<iframe class='youtubeVideo' src='http:\/\/www.youtube.com\/embed\/([a-zA-Z0-9]+)' frameborder='0' allowfullscreen><\/iframe>/", "[video \\1]", $line);
                } else if(strpos($line, "<div class='contentBlock'>") === 0) {
                    $markupRemake .= "[block]";
                } else if(strpos($line, "</div><!-- end block -->") === 0) {
                    $markupRemake .= "[/block]";
                } else if(strpos($line, "<!-- raw -->") === 0) {
                    $markupRemake .= preg_replace("/<!-- raw -->/", "#", $line);
                }
                $markupRemake .= "\n";
            }
        }
        if($code)
            $markupRemake .= "[/code]\n";
        return $markupRemake;
    }
    
    
    ############################## SESSIONS
    session_start();
    

    ############################### NICE LOOKING URLS
    $baseResource = array_shift($URI);
    
    if($baseResource === "")
    {
        header("Location: " . $defaultPage);
        exit;
    }
    
    
    ############################### AUTH
    $logged = false;
    if(isset($_SESSION['phrase']) && $_SESSION['phrase'] === $correctAdminPhrase)
            $logged = true;
    if(isset($_POST['phrase']) && $_POST['phrase'] === $correctAdminPhrase)
    {
        $_SESSION['phrase'] = $correctAdminPhrase;
        $logged = true;
    }
    
    if(!$logged && !($baseResource == "login"))
    {
        header("Location: /admin/login/");
        exit;
    }
    
    include("blog.php");
    include("projects.php");
    
    ############################## TITLE SWITCH
    $title = "";
    switch($baseResource)
    {
        case "login": $title = "Login"; break;
        case "menu": $title = "Main Menu"; break;
        case "blog": $title = "Blog Mgmt."; break;
        case "tags": $title = "Tag Mgmt."; break;
        case "projects": $title = "Project Mgmt."; break;
    }
    
?>

<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" id="curedotorg"  xmlns:fb="http://ogp.me/ns/fb#" xmlns:og="http://ogp.me/ns#" lang="en-US">
<head>
    <link rel="icon" type="image/gif" href="/favicon.gif">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700' rel='stylesheet' type='text/css'>
    <link href="/css/admin.css" rel="stylesheet" type="text/css">
    <title>Admin Pane | <?php echo $title; ?></title>
    <script type="text/javascript" language="Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" language="Javascript" src="js/dynamic_window.js"></script>
</head>
<body>
<?php
    $content_file = "admin_pages/" . $baseResource . ".php";
    if(!file_exists($content_file))
        echo 'Whoops...<a href="/admin/menu">Click here I guess</a>';
    else
        include($content_file);
?>

</body>
</html>