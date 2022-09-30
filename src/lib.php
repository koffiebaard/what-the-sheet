<?php
// Load template file with given parameters and return a string
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

// Format an API error response
function error_response($response, $message, $status_code = 500, $errors = []) {
  $response->getBody()->write('{
    "message": "' . $message . '",
    "errors": ' . json_encode($errors) . '}
  ');
  return $response->withStatus($status_code)->withHeader('Content-type', 'application/json');
}
