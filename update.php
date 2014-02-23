<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    function getHref($line) {
        $line = preg_replace("/\[[a-z]+ +/", "", $line);
        $line = preg_replace("/ *\] */", "", $line);
        return $line;
    }
    
    $markup = "
-Heading 1
--Heading 2
---Heading 3
Paragraph
>Quote
>>Subtitle
[banner /banner.png]
[portrait /goat.png]
[video yO6LMZWsBEA]
#<table><tr><td>test</td><td>one</td></tr></table>
    ";
    echo $markup . "<br>\n<br>\n<br>\n<br>\n<br>\n<br>\n";
    
    $content = "";
    foreach(explode("\n", $markup) as $line) {
        if(strlen(trim($line)) > 0) {
            if(strpos($line, "---") === 0) {
                $content .= "<h3>" . trim(substr($line, 3)) . "</h3>";
            } else if(strpos($line, "--") === 0) {
                $content .= "<h2>" . trim(substr($line, 2)) . "</h2>";
            } else if(strpos($line, "-") === 0) {
                $content .= "<h1>" . trim(substr($line, 1)) . "</h1>";
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
                $content .= "<iframe class='youtubeVideo' src='//www.youtube.com/embed/";
                $content .= getHref($line);
                $content .= "' frameborder='0' allowfullscreen></iframe>";
            } else {
                $content .= "<p>" . trim($line) . "</p>";
            }
            $content .= "\n";
        }
    }
    echo $content . "<br>\n<br>\n<br>\n<br>\n<br>\n<br>\n";
        
        include('mysql_def.php');
        mysql_connect($mySQLHostname, $mySQLUser, $mySQLPassword) or die("MySQL Error! Code: 0");
        mysql_select_db($mySQLDatabase) or die("MySQL Error! Code: 1");
        
        $sql = "update posts set main_content='" . mysql_real_escape_string($content) . "' where id='sample19';";
        echo "<textarea>" . $sql . "</textarea>";
        mysql_query($sql) or die("MySQL Error! Code: 1");
        
        echo "\n\n\n\n\n\n\n";
        
        
    $markupRemake = "";
    foreach(explode("\n", $content) as $line) {
        if(strlen(trim($line)) > 0) {
            if(strpos($line, "<h3>") === 0) {
                $markupRemake .= "---" . preg_replace("/<\/?h3>/", "", $line);
            } else if(strpos($line, "<h2>") === 0) {
                $markupRemake .= "--" . preg_replace("/<\/?h2>/", "", $line);
            } else if(strpos($line, "<h1>") === 0) {
                $markupRemake .= "-" . preg_replace("/<\/?h1>/", "", $line);
            } else if(strpos($line, "<p class='subtitle'>") === 0) {
                $markupRemake .= ">>" . preg_replace("/<\/?p[^>]*>/", "", $line);
            } else if(strpos($line, "<p class='quote'>") === 0) {
                $markupRemake .= ">" . preg_replace("/<\/?p[^>]*>/", "", $line);
            } else if(strpos($line, "<p>") === 0) {
                $markupRemake .= preg_replace("/<\/?p[^>]*>/", "", $line);
            } else if(strpos($line, "<img class='banner'") === 0) {
                $markupRemake .= preg_replace("/<img[^>]*src='/", "[banner ", preg_replace("/' \/> *$/", "]", $line));
            } else if(strpos($line, "<img class='portrait'") === 0) {
                $markupRemake .= preg_replace("/<img[^>]*src='/", "[portrait ", preg_replace("/' \/> *$/", "]", $line));
            } else if(strpos($line, "<iframe class='youtubeVideo'") === 0) {
                $markupRemake .= preg_replace("/<iframe[^>]*src='\/\/www.youtube.com\/embed\//", "[video ", preg_replace("/' frameborder='0' allowfullscreen><\/iframe> *$/", "]", $line));
            } else if(strpos($line, "<!-- raw -->") === 0) {
                $markupRemake .= preg_replace("/<!-- raw -->/", "#", $line);
            }
            $markupRemake .= "\n";
        }
    }
        echo $markupRemake;
?>
    