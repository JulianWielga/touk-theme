$ = jQuery

$socialIcons = $('.social-icons a')

$socialIcons.hover ->
  $(this).fadeTo 'fast', 1
, ->
  $(this).fadeTo 'fast', 0.5

$socialIcons.fadeTo 0.5
