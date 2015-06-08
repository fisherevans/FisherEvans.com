<?php
    include('sidebar.php');
    
    $age = (date("md", date("U", mktime(0, 0, 0, 6, 3, 1993))) > date("md") ? ((date("Y")-1993)-1):(date("Y")-1993));
    $school = $age - 17;
    $year = array("", "freshman", "sophomore", "junior", "senior", "masters student");
?>

<h1 class="page_title_withside">About</h1>

<div class="page_content">
    <div class="img_right">
        <img src="img/self.png" alt="Fisher's Facebook profile picture."></img>
    </div>
    <h2>20 Second Summary</h1>
    <p>
        My full name is <b>David Fisher Evans</b>, but I've always gone by Fisher. I'm a <?php echo $age; ?> year old <b>Software Engineering</b> student studying at the Williston campus of <a target="_blank" href="http://www.vtc.edu/interior.php/pid/4/sid/26/tid/556">Vermont Technical College</a> . I have a <b>passion for</b> <a href="/projects">making</a> useful, intuitive,  things and I'm eager to <b>learn</b> how to make those things better.
    </p>
    <br>
    <h2>The Past</h1>
    <p>
        My computer journey started towards the end of middle school when I got my first personal computer. In the beginning I just played games, but with time I started to modify my computer environment. Whether it was making a custom theme for Windows or writing a script to out-perform the other players, I was starting to get "under the hood" of the computer.
    </p>
    <p>
        During high school, I became interested in Web Development. I started with simple HTML/CSS web pages and progressed to using PHP, MySQL and JavaScript to create fully-functioning sites and user-based services. In the process, I also became accustomed to the Adobe Suite; I took pride in making all of the graphics myself. In my last two years of high school I started to take Computer Systems classes through the Burlington Technical Center. The instructor, Angela Pandis, provided me with the motivation and encouragement to learn more.
    </p>
    <p>
        Throughout my high school experience, I won three state championships for Computer Maintenance, Inter-Networking and Web Design. I continued to compete nationally in Computer Maintenance and Inter-Networking, finishing in 38th and 13th place respectively. During the National Computer Maintenance competition I earned my CompTIA A+ certification.
    </p>
    <br>
    <h2>The Present</h1>
    <p>
        I'm currently a <?php echo $year[$school]; ?> at Vermont Technical College studying Computer Software Engineering, and loving it. Software is definitely what I want to do with my life. In the<?php echo (($school <= 2)?" short":""); ?> time that I've attended college I've learned so much, and have met so many people who motivate me to do the best that I can and to persue greater learning.
    </p>
    <p>
        Between work and school, I'm trying to have as much fun as possible. If I'm not with friends, I'm probably working on a side project or making up some grand plans for the future. You can check out what I think is important in my current life on my <a href="/blog">Blog</a> and what I'm currently working on over at my <a href="/projects">Projects</a> page.
    </p>
    <br>
    <h2>The Future</h1>
    <p>
        I want to love what I do, I don't want to be stuck working an 8-to-5 job I dread going to everyday. I want to be excited about going to work and feel that I'm doing something worthwhile. I want my career to challange me and allow me to shine.
    </p>
</div>

<?php

?>