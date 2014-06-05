<?php
    $datePosted = date('D, d M Y H:i:s O');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	>
    <channel>
        <title>FisherEvans.com | Blog</title>
        <link>http://fisherevans.com/blog</link>
        <generator>http://fisherevans.com/blog</generator>
        <description>This feed displays the most recent blog posts made by Fisher to his blog.</description>
        <lastBuildDate><?php echo $datePosted; ?></lastBuildDate>
        <pubDate><?php echo $datePosted; ?></pubDate>
        <language>en-US</language>
        <atom:link href="http://fisherevans.com/rss/" rel="self" type="application/rss+xml" />
        <image>
            <title>FisherEvans.com | Blog</title>
            <url>http://fisherevans.com/favicon.gif</url>
            <link>http://fisherevans.com/</link>
            <description>Fisher's Blog</description>
            <width>16</width>
            <height>16</height>
        </image>
<?php
    foreach(getPosts(0, 20) as $post)
        printPostRSS($post);
?>
    </channel>
</rss>