<?php
    $postsToShow = 3;

    function fetchProject($projectId) {
        $query = mysql_query("SELECT * FROM projects WHERE id='$projectId';");
        return mysql_fetch_array($query);
    }
    
    function fetchProjects() {
        $query = mysql_query("select projects.id AS project_id, projects.*, (
	select max(posts.post_date) as most_recent from posts, posts_to_tags, projects
	where posts.id=posts_to_tags.post_id
	and posts_to_tags.tag_id=projects.tag_id
	and projects.id=project_id
) AS most_recent from projects order by most_recent desc, projects.name asc;");
        $projects = array();
        while($project = mysql_fetch_array($query))
            array_push($projects, $project);
        return $projects;
    }
    
    function fetchProjectByTag($tagId) {
        $query = mysql_query("SELECT * FROM projects WHERE tag_id='$tagId';");
        return mysql_fetch_array($query);
    }
    
    function getProjectSummary($project) {
        $imgContent = '<a href="/projects/' . $project['id'] . '"><img class="projectSummaryLogo" src="' . $project['image_location'] . '" /></a>';
        $content = "<div class='contentBlock project'>";
        $content .= '<div class="projectSummary"><h1 class="headerLink" onClick="javascript:' . "window.location.assign('/projects/" . $project['id'] . "');" . '">' . $project['name'] . '</h1>';
        $content .= '<p>' . $project['intro_content'] . '</p>';
        $content .= '<p class="readMore"><a href="/projects/' . $project['id'] . '">View Project Page</a>';
        if($project['most_recent'] != null)
            $content .= "<p class='sub'>The most recent blog post related to this project was on " . date("F jS, Y", strtotime($project['most_recent'])) . '</p>';
        $content .= '</div>';
        $content .= $imgContent;
        $content .= '</div>';
        return $content;
    }
    
    function getProject($project) {
        $content = '<p class="topNotification">This page is for a single project. You can go back to view all of my <a href="/projects">Projects</a>.</p>';
        $content .= "<div class='contentBlock'>";
        $content .= "<img class='projectLogo' src='" . $project['image_location'] . "' />";
        $content .= '<h1 class="headerLink" onClick="javascript:' . "window.location.assign('/projects/" . $project['id'] . "');" . '">' . $project['name'] . '</h1>';
        $content .= '<p>' . $project['intro_content'] . '</p>';
        $content .= $project['main_content'] . "</div>";
        global $postsToShow;
        $posts = fetchTagPostsLimit($project['tag_id'], $postsToShow);
        if(sizeof($posts) > 0) {
            $content .= '<h2>Blog Posts</h2><p>Below is a listing of the most recent blog posts relating to this project. Click <a href="/blog/tags/' . $project['tag_id'] . '">here</a> to view all posts related to this project.';
            $content .= getPostSummaries($posts, "h3");
        }
        $content .= '<p class="topNotification">Go back to all of my <a href="/projects">Projects</a>...</p>';
        return $content;
    }

    function getProjectsContent($path) {
        global $title;
        include('blog.php');
        
        $action = array_shift($path);
        if($action == "") {
            $title = "Projects" . $title;
            $content = '<h1>Projects</h1><p>Below is a list of personal (and maybe some group) projects that I thought deserved their own page. Feel free to contact me (see the footer) if you\'de like to know more about a certain project or endeavor.</p>';
            $content .= '<p class="subtitle">The following projects are listed in order of their most recent blog post activity.</p>';
            foreach(fetchProjects() as $project) {
                $content .= getProjectSummary($project);
            }
            return $content;
        } else {
            $project = fetchProject($action);
            if($project == null)
                return get404();
            else {
                $title = $project['name'] . " (Project)" . $title;
                return getProject($project);
            }
        }
        return "<h1>Projects</h1>";
    }
?>