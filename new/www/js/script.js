$(document).ready(function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('.menuBox').on('click', function(event) {
      $('.navPane').toggleClass('expanded');
  });
  $(window).on('resize', function(event) {
    if($(window).width() > 800)
      $('.navPane').removeClass('expanded');
  });
});