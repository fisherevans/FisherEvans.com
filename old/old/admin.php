<?php
    
    ############################
    #echo("down"); exit();
    ############################
    
    
    //* ###################  ERROR Checking
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    /**/
    
    
    ############################### GLOBAL VARIABLES
    $defaultPage = "/admin/menu";
    $correctPhrase = "1qaz@WSX";
    $mainSite = "http://www.fisherevans.com/";
    $postHome = "/mnt/ssd/www/fisherevans.com/src/posts/";
    
    
    ############################## SESSIONS
    session_start();
    

    ############################### NICE LOOKING URLS
    $resource = array_shift($uri);
    
    if($resource === "")
    {
        header("Location: " . $defaultPage);
        exit;
    }
    
    
    ############################### AUTH
    $logged = false;
    if(isset($_SESSION['phrase']) && $_SESSION['phrase'] === $correctPhrase)
            $logged = true;
    if(isset($_POST['phrase']) && $_POST['phrase'] === $correctPhrase)
    {
        $_SESSION['phrase'] = $correctPhrase;
        $logged = true;
    }
    
    if(!$logged && !($resource === "login"))
    {
        header("Location: /admin/login/");
        exit;
    }
    
    ############################## TITLE SWITCH
    $title = "";
    switch($resource)
    {
        case "login": $title = "Login"; break;
        case "menu": $title = "Main Menu"; break;
        case "blog": $title = "Blog Mgmt."; break;
        case "tags": $title = "Tag Mgmt."; break;
        case "projects": $title = "Project Mgmt."; break;
    }
    
    ############################### MYSQL CONNECT
    mysql_connect("localhost", "fisherev_fisher", "1qa@WS") or die("failed to connect to sql");#mysql_error());
    mysql_select_db("fisherev_fisherevanscom") or die("failed to connect to db");#mysql_error());
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

    $content_file = "admin_pages/" . $resource . ".php";
    if(!file_exists($content_file))
        echo 'Whoops... <a href="/admin/menu">Click here I guess</a>...';
    else
        include($content_file);
?>

</body>
</html>