<?php
    //* ERROR Checking
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    /**/
    
    header("Content-type: text/css");
    
    $cont_width = "
        width:1050px;
        min-width: 750px;
        max-width:85%;";

    include('colors.php');
?>

<?php ####################### GLOBAL ?>

*
{
    font-family: 'Droid Sans', sans-serif;
    color: <?php echo $white; ?>;
    padding: 0px;
    margin: 0px;
}

a
{
    transition: color .25s ease-in-out, text-decoration .25s  ease-in-out;
    -moz-transition: color .25s  ease-in-out, text-decoration .25s  ease-in-out;
    -webkit-transition: color .25s  ease-in-out, text-decoration .25s  ease-in-out;
}

body 
{
    background-color: <?php echo $grey; ?>;
    padding-bottom: 20px;
}

.dark_red
{
    color: <?php echo $dark_red; ?>;
}

.dark_green
{
    color: <?php echo $dark_green; ?>;
}

p
{
    font-family: 'Droid Serif', serif;
    font-size: 15px;
    line-height: 25px;
    padding:10px;
    text-indent: 60px;
}

    p a
    {
        font-family: 'Droid Sans', sans-serif;
        font-weight: 700;
        font-style: italic;
        color:<?php echo $dark_green; ?>;
        text-decoration: none;
    }

    p a:hover
    {
        color: <?php echo $light_green; ?>;
    }

p.quote
{
    font-size: 28px;
    line-height: 40px;
    padding:10px 15%;
    text-indent: 0px;
    text-align: center;
}

p.subtitle
{
    font-style: italic;
    font-size: 14px;
    line-height: 24px;
    color: <?php echo $light_grey; ?>;
    text-indent: 0px;
    padding-top: 0px;
}

p.note
{
    font-family: 'Droid Sans', sans-serif;
    font-style: italic;
    font-size: 14px;
    line-height: 24px;
    color: <?php echo $light_grey; ?>;
    text-indent: 0px;
    padding:0px 10px;
}

    p.note a
    {
        font-family: 'Droid Serif', serif;
        font-size: 12px;
        text-decoration: none;
        color: <?php echo $dark_red; ?>;
    }

    p.note a:hover
    {
        color: <?php echo $light_red; ?>;
    }

    p.note b
    {
        color: <?php echo $light_grey; ?>;
    }

ul
{
    padding-left: 35px;
}

h1
{
    font-family: 'Droid Serif', serif;
    font-style: italic;
    font-size: 36px;
    line-height: 40px;
    padding:10px;
}

h2
{
    font-family: 'Droid Serif', serif;
    font-style: italic;
    font-size: 28px;
    line-height: 40px;
    padding:7px;
}

    h2 a
    {
        font-family: 'Droid Serif', serif;
        font-style: italic;
        font-size: 28px;
        line-height: 40px;
        text-decoration: underline;
        color: <?php echo $white; ?>;
    }

    h2 a:hover
    {
        color: <?php echo $light_green; ?>;
        text-decoration: none;
    }

    h1 a:hover
    {
        color: <?php echo $light_green; ?>;
        text-decoration: none;
    }

h3
{
    font-family: 'Droid Serif', serif;
    font-size: 20px;
    line-height: 40px;
    padding:5px;
}

h4
{
    font-family: 'Droid Sans', sans-serif;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 400;
    text-align: center;
    padding-top: 0px;
}

img.centered
{
    width:70%;
    padding:10px 15%;
}

<?php ################################### BANNER ?>
#banner
{
    position: fixed;
    top:0px;
    left:0px;
    right:0px;
    height: 55px;
    background-color: #020202;
    z-index:1;
}

    #header
    {
        <?php echo $cont_width; ?>
        height: 55px;
        margin: 0px auto;
    }

        #logo_text
        {
            line-height:55px;
            float: left;
        }

            #logo_text a
            {
                text-decoration: none;
                font-size: 22px;
                line-height: 35px;
                padding: 10px 20px;
                color: #6e635f;
                display: <?php echo $black; ?>ock;
                font-weight: 700;
            }

        #nav
        {
            float: right;
            height: 55px;
            font-size: 0;
        }

            .nav_link
            {
                text-decoration: none;

                font-size: 18px;
                line-height: 35px;
                padding: 10px 20px;
                display: inline-block;
                margin: 0px;
                color: <?php echo $light_grey; ?>;
                background-color: #020202;
                transition: background .25s, color .25s ease-in-out;
                -moz-transition: background .25s, color .25s  ease-in-out;
                -webkit-transition: background .25s, color .25s  ease-in-out;
            }

            .nav_link:hover
            {
                color: #020202;
                background-color: <?php echo $white; ?>;
            }

            .current
            {
                color: <?php echo $white; ?>;
                background-image: url('/img/nav_current.png');
                background-repeat: no-repeat;
                background-position: center top;
            }

            .current:hover
            {
                color: #020202;
            }
            
<?php ################################### CONENT ?>

#content
{
    <?php echo $cont_width; ?>
    position: relative;
    margin: 55px auto;
    margin-bottom:0px;
    background-color: <?php echo $darker_grey; ?>;
    overflow: auto;
}

    #blog_page_numbers
    {
        font-family: 'Droid Serif', serif;
        font-size: 20px;
        text-align: center;
        width: 80%;
        margin: 0px auto;
        border-top:1px dotted <?php echo $light_grey; ?>;
        padding:20px;
        color: <?php echo $light_grey; ?>;
    }

        #blog_page_numbers a
        {
            font-family: 'Droid Serif', serif;
            font-size: 20px;
            color: <?php echo $white; ?>;
        }

        #blog_page_numbers a:hover
        {
            color: <?php echo $light_green; ?>;
        }

    #content .center
    {
	text-align:center;
	width:auto;
	padding:20px;
	margin: 0px auto;
    }
    
    #content .page_title_withside
    {
        display: block;
        width:72%;
        padding: 0px 3%;
        padding-top:20px;
        background-color: <?php echo $dark_grey; ?>;
        font-size: 45px;
        text-align:center;
        line-height:57px;
    }
    
    #content h2.page_title_withside
    {
        padding-top:20px;
        background-color: <?php echo $dark_grey; ?>;
        color: <?php echo $light_grey; ?>;
        font-size: 28px;
        text-align:center;
        line-height:33px;
        margin-bottom:-10px;
    }
    
    #content li
    {
        line-height: 25px;
        paddong-bottom:3px;
    }
    
    #sidebar
    {
        float:right;
        width:18%;
        padding:2%;
    }

        #sidebar .sidebar_content
        {
            width: auto;
            margin: 0px auto;
            margin-bottom: 60px;
        }

        #sidebar p
        {
            line-height:25px;
        }

        #sidebar .recent_post_title
        {
            font-family: 'Droid Serif', serif;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            color:<?php echo $white; ?>;
        }

        #sidebar .recent_post_note
        {
            line-height:18px;
        }

        #sidebar .recent_post_title:hover
        {
            color: <?php echo $light_green; ?>;
        }
	
    #sidebar .tag_note
    {
        padding-bottom:10px;
        line-height:15px;
    }

	#sidebar .tag_link
	{
	    font-family: 'Droid Serif', serif;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        font-style:normal;
        color:<?php echo $white; ?>;
        padding-bottom:10px;
	}

        #sidebar .tag_link:hover
        {
            color: <?php echo $light_green; ?>;
        }

    .page_content
    {
        width:72%;
        padding: 20px 3%;
        background-color: <?php echo $dark_grey; ?>;
        min-height:100%;
    }

        .blogpost_info
        {
            /*float:left;
            width:40%;/**/
            padding-right:30px;
        }

            .blogpost_info p
            {
                line-height: 20px;
            }
    
    .download_section
    {
        width: 80%;
        border: 3px double <?php echo $grey; ?>;
        margin: 20px auto;
        vertical-align: middle;
        background-color: <?php echo $dark_grey; ?>
        transition: background .25s;
        -moz-transition: background .25s;
        -webkit-transition: background .25s;
        text-align:center;
        box-shadow: #000 0em 0em 0em;   
    }
    
   .download_section:hover
   {
        background-color: <?php echo $darker_grey; ?>;
   }
    
        .download_section img
        {
            width: 20%;
            padding: 4%;
            display: inline-block;
            vertical-align: middle;
            border: 0px;
            opacity: 0.5;
            -moz-transition: opacity .25s;
       	    -webkit-transition: opacity .25s;
            text-align:center;
            box-shadow: #000 0em 0em 0em;
        }

	.download_section:hover img
	{
	    opacity: 1;
	}
        
        .download_section div
        {
            width: 60%;
            padding: 4%;
            display: inline-block;
            vertical-align: middle;
            text-align:left;
        }
        
    .project_thumb
    {
        width: 90%;
        border: 3px double <?php echo $grey; ?>;
        margin: 20px auto;
        vertical-align: middle;
        background-color: <?php echo $dark_grey; ?>
        transition: background .25s;
        -moz-transition: background .25s;
        -webkit-transition: background .25s;
        text-align:center;
        box-shadow: #000 0em 0em 0em;
    }
    
   .project_thumb:hover
   {
        background-color: <?php echo $darker_grey; ?>;
   }
    
        .project_thumb img
        {
            width: 20%;
            padding: 4%;
            display: inline-block;
            vertical-align: middle;
            border: 0px;
            opacity: 0.85;
            -moz-transition: opacity .25s;
       	    -webkit-transition: opacity .25s;
            text-align:center;
            box-shadow: #000 0em 0em 0em;
        }

	.project_thumb:hover img
	{
	    opacity: 1;
	}
        
        .project_thumb div
        {
            width: 60%;
            padding: 4%;
            display: inline-block;
            vertical-align: middle;
            text-align:left;
        }
    
    .img_right
    {
        float: right;
        padding:2px;
        margin: 15px;
        overflow:visible;
        width:40%;
    }
    
        .img_right p
        {
            font-size:12px;
            color: <?php echo $light_grey; ?>;
            text-indent: 0px;
            line-height: 18px;
            text-align:center;
            padding-top:3px;
        }
        
        .img_right img
        {
            width:100%;
            padding: 1px;
        }

    #err_404
    {
        margin:0px auto;
        padding: 80px 0px;
        width: 100%;
        background-color: <?php echo $dark_grey; ?>;
        vertical-align: middle;
        text-align: center;
    }

        #err_404 img
        {
            width:22%;
            height:auto;
            display: inline-block;
            margin:auto 0px;
            vertical-align: middle;
        }

        #err_404 div
        {
            width:59%;
            display: inline-block;
            vertical-align: top;
            text-align: left;
            vertical-align: middle;
        }

            #err_404 h1
            {
                font-size: 72px;
                padding: 10px 35px;
                margin-bottom: 0px;
                vertical-align: middle;
                color: <?php echo $dark_red; ?>;
            }

            #err_404 p
            {
                font-size:26px;
                text-indent: 0px;
                line-height: 45px;
                padding: 10px 35px;
                vertical-align: middle;
                color: <?php echo $light_grey; ?>;
            }
            
        
<?php ############################################### FOOTER ?>

#footer
{
    <?php echo $cont_width; ?>
    margin: 0px auto;
    background-color: <?php echo $black; ?>;
    padding:20px 0px;
    margin-bottom: 20px;
}

    #footer_content
    {
        width:100%;
        text-align: center;
        vertical-align: top;
        font-size: 0px;
    }

        .footer_third
        {
            width: 33%;
            display: inline-block;
            font-size:14px;
            text-align: center;
            vertical-align: top;
        }

            .footer_third h4
            {
                padding: 0px;
                padding-bottom:10px;
                margin-bottom: 5px;
                display: inline-block;
                text-align: center;
                width: 80%;
                border-bottom: 1px solid <?php echo $grey; ?>;
            }
            
            .footer_third a
            {
                text-decoration: none;
                color: <?php echo $light_grey; ?>;
            }
            
            .footer_third a:hover
            {
                color: <?php echo $light_red; ?>;
            }
            
            .footer_third p
            {
                font-family: 'Droid Sans', sans-serif;
                color: <?php echo $light_grey; ?>;
                text-align: center;
                font-size:12px;
                padding: 4px;
                text-indent: 0px;
                line-height: 13px;
            }
            
            .footer_third p a
            {
                font-family: 'Droid Serif', serif;
                color: <?php echo $white; ?>;
                font-size:11px;
                font-weight: 700;
                text-decoration: none;
            }
            
            .footer_third p a:hover
            {
                color: <?php echo $light_red; ?>;
            }
            
            .footer_third table
            {
                margin: 0px auto;
            }
            
            .footer_third .left
            {
                font-family: 'Droid Serif', serif;
                color: <?php echo $white; ?>;
                text-align: right;
                font-size:11px;
                padding: 4px;
                font-weight: 700;
                line-height: 13px;
            }
            
            .footer_third .right
            {
                font-family: 'Droid Sans', sans-serif;
                color: <?php echo $light_grey; ?>;
                text-align: left;
                font-size:12px;
                padding: 4px;
                line-height: 13px;
            }
            
            .footer_third .single
            {
                font-family: 'Droid Sans', sans-serif;
                color: <?php echo $light_grey; ?>;
                text-align: center;
                font-size:12px;
                padding: 4px;
                line-height: 13px;
            }
            
            span.footTitle
            {
                font-family: 'Droid Serif', serif;
                color: <?php echo $white; ?>;
                font-size:11px;
            }
            
    #cc
    {
        width: 93%;
        padding-top:20px;
        margin: 0px auto;
        margin-top:20px;
        text-align: center;
        border-top: 1px solid <?php echo $grey; ?>;
        font-family: 'Droid Sans', sans-serif;
        color: <?php echo $white; ?>;
        font-size:11px;
    }
