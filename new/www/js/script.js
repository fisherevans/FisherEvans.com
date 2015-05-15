$(document).ready(function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('.menu').on('click', function(event) {
      $('.leftPane').toggleClass('expanded');
  });
  $(window).on('resize', function(event) {
    if($(window).width() > 800)
      $('.leftPane').removeClass('expanded');
  });
});