$socialIcons = jQuery('.social-icons a')

$socialIcons.hover ->
  jQuery(this).fadeTo 'fast', 1
, ->
  jQuery(this).fadeTo 'fast', 0.5

$socialIcons.fadeTo 'fast', 0.5