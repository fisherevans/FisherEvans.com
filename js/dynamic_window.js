var viewport = "desktop";
var mobile_css = "/css/mobile_css.php";
var min_width = 750;

function loadCSSFile(filename) {
    var fileref=document.createElement('link');
    fileref.setAttribute('rel', 'stylesheet');
    fileref.setAttribute('type', 'text/css');
    fileref.setAttribute('href', filename);
    document.getElementsByTagName("head")[0].appendChild(fileref);
}

function removeCSSFile(filename){
    var targetelement = "link";
    var targetattr = "href";
    var allsuspects=document.getElementsByTagName(targetelement)
    for (var i=allsuspects.length; i>=0; i--)
    {
        if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
            allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
    }
}

function windowResize()
{
    if($(window).width() < min_width && viewport === "desktop")
    {
        viewport = "mobile";
        loadCSSFile(mobile_css);
    }
    else if($(window).width() >= min_width && viewport === "mobile")
    {
        viewport = "desktop";
        removeCSSFile(mobile_css);
    }
}

$(window).resize(function()
{
    windowResize();
});