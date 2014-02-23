<?php
    // Error Checking
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    /**/
    
    function get404() {
        return '<h1>404 - Not Found</h1><p>The page you are looking for was not found...</p>';
    }
    
    $defaultBaseResource = "about";
    $pageContent = "null";
    $title = " | FisherEvans.com";
    
    include('mysql_def.php');
    include('global_functions.php');
    
    
    mysql_connect($mySQLHostname, $mySQLUser, $mySQLPassword) or die("MySQL Error! Code: 0");
    mysql_select_db($mySQLDatabase) or die("MySQL Error! Code: 1");
    
    $URL = explode('?', $_SERVER['REQUEST_URI']);
    if(sizeof($URL) === 2)
        $get = $URL[1];
    $URL[0] = preg_replace("/[^0-9a-z\-\/]/", "", preg_replace("/^\//", "", strtolower($URL[0])));
    $URI = explode('/', $URL[0]);
    $baseResource = array_shift($URI);
    if($baseResource == null)
        $baseResource = $defaultBaseResource;
    
    if($baseResource == 'update') {
        include('update.php');
        exit;
    }
    
    $pageContent = getPageContent($baseResource);
    if($pageContent == null) { // if there isn't any page content
        switch($baseResource) {
            case "blog":
                include('blog.php');
                $pageContent = getBlogContent($URI);
                break;
            case "projects":
                include('projects.php');
                $pageContent = getProjectsContent($URI);
                break;
            default:
                $pageContent = get404();
        }
    } else {
        $title = getPageTitle($baseResource) . $title;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,400,300,100|Roboto+Slab:700,400' rel='stylesheet' type='text/css'>
        <link href='/css/style_global.css' rel='stylesheet' type='text/css' media="all">
        <link href='/css/style_big.css' rel='stylesheet' type='text/css' media="all and (max-width:1100px)">
        <link href='/css/style_medium.css' rel='stylesheet' type='text/css' media="all and (max-width:800px)">
        <link href='/css/style_small.css' rel='stylesheet' type='text/css' media="all and (max-width:500px)">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="/script.js"></script>
    </head>
    <body>
        <div id="header">
            <img id="menuIcon" src="/menu.png" />
            <span id="title">Fisher Evans</span>
            <div id="nav" class="fadeMaxHeight">
                <?php
                    echo getNavLink("about", "About");
                    echo getNavLink("blog", "Blog");
                    echo getNavLink("resume", "Resume");
                    echo getNavLink("projects", "Projects");
                    echo getNavLink("resources", "Resources");
                    //echo getNavLink("contact", "Contact");
                ?>
            </div>
        </div>
        <div class="page">
            <?php
                echo $pageContent;
            ?>
        </div>
        <div class="page" id="footer">
            <p>All content within FisherEvans.com is Copyright &copy; 2014 David Fisher Evans unless explicitly stated otherwise.</p>
        </div>
    </body>
</html>