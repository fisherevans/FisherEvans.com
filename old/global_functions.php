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
    
    function fetchPage($pageId) {
        $query = mysql_query("SELECT * FROM pages WHERE id='" . $pageId . "';");
        return mysql_fetch_array($query);
    }
    
    function fetchPages() {
        $query = mysql_query("SELECT * FROM pages;");
        $pages = array();
        while($page = mysql_fetch_array($query))
            array_push($pages, $page);
        return $pages;
    }
    
    function fetchPagesNotInNav() {
        $query = mysql_query("SELECT id FROM pages where id not in (select page_id from navigation);");
        $pages = array();
        while($page = mysql_fetch_array($query))
            array_push($pages, $page);
        return $pages;
    }
    
    function fetchNavigation() {
        $query = mysql_query("SELECT * FROM navigation order by sequence asc;");
        $navs = array();
        while($nav = mysql_fetch_array($query))
            array_push($navs, $nav);
        return $navs;
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