<?php
    // Error Checking
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    /**/
    
    function get404() {
        global $title;
        $title = "404" . $title;
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
    
    
    switch($baseResource) {
        case "admin":
            include("admin.php");
            exit;
            break;
        case "blog":
            include('blog.php');
            $pageContent = getBlogContent($URI);
            break;
        case "projects":
            include('projects.php');
            $pageContent = getProjectsContent($URI);
            break;
        default:
            $pageContent = getPageContent($baseResource);
            if($pageContent == null)
                $pageContent = get404();
            else
                $title = getPageTitle($baseResource) . $title;
            break;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="/img/favicon.png">
        
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,400,300,100|Roboto+Slab:700,400' rel='stylesheet' type='text/css'>
        <link href="/css/prism.css" rel="stylesheet" />
        <link href='/css/style_global.css' rel='stylesheet' type='text/css' media="all">
        <link href='/css/style_big.css' rel='stylesheet' type='text/css' media="all and (max-width:1050px)">
        <link href='/css/style_medium.css' rel='stylesheet' type='text/css' media="all and (max-width:700px)">
        <link href='/css/style_small.css' rel='stylesheet' type='text/css' media="all and (max-width:500px)">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="/script/script.js"></script>
    </head>
    <body>
        <div id="header">
            <img id="menuIcon" src="/img/menu.png" />
            <span id="title">Fisher Evans</span>
            <div id="nav" class="fadeMaxHeight">
                <?php
                    foreach(fetchNavigation() as $nav) {
                        echo getNavLink($nav['page_id'], getPagetitle($nav['page_id']));
                    }
                ?>
            </div>
        </div>
        <div class="page">
            <?php
                echo $pageContent;
            ?>
        </div>
        <div class="page" id="footer">
            <div class="footerHalf">
                <h4>CONTACT INFO</h4>
                <table cell-spacing=0>
                    <tr>
                        <td class="left">Email</td>
                        <td class="right"><a href="mailto:contact@fisherevans.com">contact@fisherevans.com</a></td>
                    </tr>
                    <tr>
                        <td class="left">Phone</td>
                        <td class="right"><a href="tel:8023637526">(802) 363-7526</a></td>
                    </tr>
                    <tr>
                        <td class="left">Location</td>
                        <td class="right"><a target="_blank" href="https://www.google.com/maps/place/Chittenden+County/@44.4380375,-73.0638627,108486m/data=!3m2!1e3!4b1!4m2!3m1!1s0x4cb587b3309b2fdf:0x24998da66abb959c?hl=en">Chittenden County, VT</a></td>
                    </tr>
                    <tr>
                        <td class="left">Facebook</td>
                        <td class="right"><a target="_blank" href="https://www.facebook.com/fisherevans">facebook.com/fisherevans</a></td>
                    </tr>
                    <tr>
                        <td class="left">LinkedIn</td>
                        <td class="right"><a target="_blank" href="http://www.linkedin.com/in/fisherevans/">linkedin.com/in/fisherevans</a></td>
                    </tr>
                    <tr>
                        <td class="left">YouTube</td>
                        <td class="right"><a target="_blank" href="http://www.youtube.com/user/DFisherEvans">youtube.com/user/DFisherEvans</a></td>
                    </tr>
                </table>
            </div>
            <div class="footerHalf">
            <h4>FRIENDS & FAVORITES</h4>
            <table cell-spacing=0>
                <tr>
                    <td class="left">Philip Lipman</td>
                    <td class="right"><a target="_blank" href="http://www.philiplipman.com/">philiplipman.com</a></td>
                </tr>
                <tr>
                    <td class="left">Jason Bunn</td>
                    <td class="right"><a target="_blank" href="http://wizardrymachine.com/">wizardrymachine.com</a></td>
                </tr>
            </table>
            </div>
            <p>All content within FisherEvans.com is Copyright &copy; 2014 David Fisher Evans unless explicitly stated otherwise.</p>
        </div>
        <script src="/script/prism.js"></script>
    </body>
</html>