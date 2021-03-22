$(document).ready(function() {

  $('#popup-okay, .popup .overlay, .close-popup').click(function(e) {
    e.preventDefault();
    $('.popup').removeClass('open');
  });

  $('.location-tabs a').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    var $target = $this.attr('href');

    $('.location-tabs a, .location-inner').removeClass('active');
    $this.addClass('active');
    $($target).addClass('active');

  });


  $('.check-block').click(function(e) {
    e.preventDefault();
    
    var $this = $(this);
    var $input = $this.find('input');
    var checked = $input.prop('checked');
    checked = !checked;

    $this.toggleClass('active');
    $input.prop('checked', checked);
  });

  $('.radio-group label').click(function() {
    var $this = $(this);
    $this.prev().prop('checked', true);
  });

  $('a.side-clear').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    var $form = $this.parents('form');

    $form.trigger('reset');
    $('.check-block').removeClass('active');
  });

  $('.side-line-title').click(function() {
    var $this = $(this);
    var $parent = $this.parent();
    $parent.toggleClass('active');
  });

  

});