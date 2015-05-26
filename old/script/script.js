$(document).ready(function() {
    $("#menuIcon").click(function(event) {
        $("#nav").toggleClass("visible");
    });
    $(".navLink").click(function(event) {
        $("#nav").removeClass("visible");
    });
    $(window).resize(checkNavClass);
    checkNavClass();
});

function goToPage(pageId) {
    $(".navLink").removeClass("selected");
    $(".navLink." + pageId).addClass("selected");
    $(".page").addClass("hidden");
    $("#" + pageId).removeClass("hidden");
}

function checkNavClass() {
    $("html").delay(0).queue(function() {
        if($("#nav").css("max-height") == "40px") {
            $("#nav").removeClass("fadeMaxHeight");
            $("#nav").css("height", "40px");
        } else {
            $("#nav").addClass("fadeMaxHeight");
            $("#nav").css("height", "auto");
        }
        $(this).dequeue();
    });
}