// JavaScript Document
$(function() {
//Hide label when focus on input
  $('.label-over').focus(function() {
    $('label.label-hide[for="' + $(this)[0].id + '"]').hide();
  }).blur(function() {
    if($(this).val() == '') {
      $('label.label-hide[for="' + $(this)[0].id + '"]').show();
    }
  });
});