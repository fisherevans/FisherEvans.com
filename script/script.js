$(document).ready(function() {
    $("#menuIcon").click(function(event) {
        console.log("click!");
        $("#nav").toggleClass("visible");
    });
    $(".navLink").click(function(event) {
        $("#nav").removeClass("visible");
    });
});

function goToPage(pageId) {
    $(".navLink").removeClass("selected");
    $(".navLink." + pageId).addClass("selected");
    $(".page").addClass("hidden");
    $("#" + pageId).removeClass("hidden");
}