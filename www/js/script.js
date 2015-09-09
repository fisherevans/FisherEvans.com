$(document).ready(function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('.navToggle').on('click', function(event) {
    $('.sideBar').toggleClass('expanded');
  });
  $(window).on('resize', function(event) {
    if($(window).width() > 800)
      $('.navPane').removeClass('expanded');
  });
});