<div id="footer_content">
        <div class="footer_third">
            <h4>CONTACT INFO</h4>
            <table cell-spacing=0>
                <tr>
                    <td class="left">Email</td>
                    <td class="right"><a href="mailto:contact@fisherevans.com">contact@fisherevans.com</a></td>
                </tr>
                <tr>
                    <td class="left">Phone</td>
                    <td class="right"><a href="tel:8024482036">802.448.2036</a></td>
                </tr>
                <tr>
                    <td class="left">Location</td>
                    <td class="right"><a target="_blank" href="https://maps.google.com/maps?q=Burlington,+VT+&hl=en&ll=44.475931,-73.212204&spn=0.176137,0.318604&sll=44.49259,-73.226648&sspn=0.176087,0.318604&t=h&hnear=Burlington,+Chittenden,+Vermont&z=12&iwloc=A">Burlington, VT</a></td>
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
        <div class="footer_third">
            <h4>RECENT BLOG POSTS</h4>
            <table cell-spacing=0>
            <?php
                foreach(getRecentPosts() as $recentPost)
                {
                    echo '<tr><td class="single"><a href="/blog/post/' . $recentPost['post_id'] . '"><span class="footTitle">' . $recentPost['post_title'] . '</span> ';
                    echo '(' .date("F jS, Y", strtotime($recentPost['post_time'])) . ')</a></td></tr>';
                }
            ?>
            </table>
        </div>
        <div class="footer_third">
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
    </div>
    <div id="cc">
		&#169; Copyright David Fisher Evans. Website created and managed by David Fisher Evans. Third-party technologies and resources used: <a target="_blank" href="http://thenounproject.com/">The Noun Project</a>, <a target="_blank" href="http://jquery.com/">jQuery</a>,<a target="_blank" href="http://www.google.com/fonts/">Google Webfonts</a>.
	</div>
    <div id="cc">
		Here's an <a href="/rss">RSS Feed</a> for Fisher's Blog.
	</div>
    