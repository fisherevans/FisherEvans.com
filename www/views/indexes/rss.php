<?php
$app->response->mime = 'xml';
$datePosted = date('D, d M Y H:i:s O');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
function getPosts() {
  return collection('Blog Posts')->find(["published"=>true])->limit(20)->toArray();
}
function printPostRSS($post) {
  $parseDown = new ParsedownExtra();
  echo "    <item>\n";
  echo "      <title>" . $post['title'] . "</title>\n";
  echo "      <link>http://fisherevans.com/blog/post/" . $post['title_slug'] . "</link>\n";
  echo "      <guid>http://fisherevans.com/blog/post/" . $post['title_slug'] . "</guid>\n";
  echo "      <pubDate>" . date("D, d M Y H:i:s O", strtotime($post['posted_date'])) . "</pubDate>\n";
  echo "      <content:encoded><![CDATA[" . fixRelativeLinks($parseDown->text($post['content'])) . "]]></content:encoded>\n";
  echo "    </item>\n";
}
?>
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:atom="http://www.w3.org/2005/Atom" >
  <channel>
    <title>Blog | Fisher Evans</title>
    <link>http://fisherevans.com/blog</link>
    <generator>http://fisherevans.com/blog</generator>
    <description>The most recent posts that Fisher Evans has made to his Blog.</description>
    <lastBuildDate><?=$datePosted?></lastBuildDate>
    <pubDate><?=$datePosted?></pubDate>
    <language>en-US</language>
    <image>
      <title>Blog | Fisher Evans</title>
      <url>http://fisherevans.com/favicon.png</url>
      <link>http://fisherevans.com/blog</link>
      <description>Fisher Evans' Blog</description>
      <width>16</width>
      <height>16</height>
    </image>
    <atom:link href="http://fisherevans.com/blog/rss" rel="self" type="application/rss+xml" />
    <?php
    foreach(getPosts() as $post)
      printPostRSS($post);
    ?>
  </channel>
</rss>