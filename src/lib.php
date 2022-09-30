<?php

function template($template_filename, $parameters = []){
  $filename = "template/$template_filename";

  if ( !file_exists($filename) || stristr($template_filename, '..') ) {
    return '';
  }

  extract($parameters);

  ob_start();
  include $filename;
  return ob_get_clean();
}
