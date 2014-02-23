<?php

    function getPageContent($pageId) {
        $query = mysql_query("SELECT content FROM pages WHERE id='" . $pageId . "';");
        $result = mysql_fetch_array($query);
        return $result['content'];
    }
    
    function getPagetitle($pageId) {
        $query = mysql_query("SELECT title FROM pages WHERE id='" . $pageId . "';");
        $result = mysql_fetch_array($query);
        return $result['title'];
    }
    
    function getNavLink($pageId, $label) {
        global $baseResource;
        $tag = '<a class="navLink fadeColor';
        if($pageId == $baseResource)
            $tag .= ' selected';
        $tag .= '" href="/' . $pageId . '">' . $label . "</a>\n";
        return $tag;
    }
    
?>