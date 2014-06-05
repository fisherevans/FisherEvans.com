<?php
    header("Content-type: text/css");

    include('colors.php');

    $mobile_width = "min-width: 100%;max-width: 100%;width: 100%;";
?>

#banner
{
    position: relative;
    background-color: <?php echo $black; ?>;
    <?php echo $mobile_width; ?>
    height: auto;
    padding-bottom:3px;
}

    #header
    {
        <?php echo $mobile_width; ?>
        height: auto;
        background-color: <?php echo $black; ?>;
        position: relative;
        text-align: center;
    }

        #logo_text
        {
            height:auto;
            float: none;
            margin: 0px;
        }

            #logo_text a
            {
                text-decoration: none;
                font-size: 22px;
                line-height: 35px;
                padding: 5px 7px;
                font-weight: 700;
                float: none;
                margin: 0px;
            }

        #nav
        {
            float: none;
            height:auto;
        }

            .nav_link
            {
                text-decoration: none;
                font-size: 18px;
                line-height: 35px;
                padding: 0px 10px;
                float: none;
                margin: 0px;
                display: inline-block;
            }

            .nav_link:hover
            {
                color: <?php echo $black; ?>;
                background-color: <?php echo $white; ?>;
            }

            .current
            {
                color: <?php echo $white; ?>;
                background-image: none;
            }

            .current:hover
            {
                color: <?php echo $black; ?>;
            }

#content
{
    <?php echo $mobile_width; ?>
    position: relative;
    margin:0px;
    background-color: <?php echo $dark_grey; ?>;
    overflow: visible;
}
    
    #content .page_title_withside
    {
        display: block;
        width:95%;
        padding: 7px 0px;
        margin: 0px auto;
    }
    
    #content .page_title
    {
        <?php echo $mobile_width; ?>
        margin:0px;
        padding: 0px;
    }
    
    #sidebar
    {
        visibility: hidden;
        position:absolute;
    }

    .page_content
    {
        width: 90%;
        padding: 20px 0px;
        margin:0px auto;
	    background-color: <?php echo $dark_grey; ?>;
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
        width: 95%;
    }
    
        .download_section img
        {
            width: 20%;
            padding: 1%;
            display: inline-block;
            vertical-align: middle;
        }
        
        .download_section div
        {
            width: 70%;
            padding: 1%;
            display: inline-block;
            vertical-align: middle;
	    font-size:0px;
	}
            
    .img_right
    {
        float: none;
        padding:2px;
        margin: 15px;
        overflow:visible;
        width:60%;
        margin:0px auto;
        max-width: 200px;
    }

    #err_404
    {
        text-align:center;
        padding: 20px 0px;
    }

        #err_404 img
        {
            margin: 0px auto;
            text-align:center;
            padding: 25px;
        }

        #err_404 div
        {
            margin: 0px auto;
            text-align:center;
        }

            #err_404 p
            {
                font-size: 18px;
                line-height: 26px;
                padding:5px;
            }


#footer
{
    <?php echo $mobile_width; ?>
}

    .footer_third
    {
        display: block;
        width: 90%;
        margin: 0px auto;
        margin-bottom:30px;
    }
    
    #cc
    {
        width:72.2%;
    }
