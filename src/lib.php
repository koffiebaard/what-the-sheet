<?php
// Load template file with given parameters and return a string
function template($template_filename, $parameters = []) {
  $filename = __DIR__."/template/$template_filename";

  if (!file_exists($filename) || stristr($template_filename, '..')) {
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

function send_purge_request($url) {
  $curl = curl_init();
  // I tried CURLOPT_TIMEOUT_MS on 100-200ms to speed things up, but it's very buggy < 1000ms
  curl_setopt_array($curl, [
     CURLOPT_URL                  => $url
    ,CURLOPT_CUSTOMREQUEST        => "PURGE"
    ,CURLOPT_TIMEOUT_MS           => 1500
    ,CURLOPT_CONNECTTIMEOUT       => 1
    ,CURLOPT_NOSIGNAL             => 1
    ,CURLOPT_RETURNTRANSFER       => true
  ]);
  curl_exec($curl);
  curl_close($curl);
}

function clear_varnish_cache($id, $share_token) {
  // Only purge when it's enabled
  if (getenv('WTS_CLEAR_CACHE') != 1) {
    return;
  }

  // Purge the admin page (by ID)
  send_purge_request(getenv('WTS_WEB_ADDRESS')."/$id");

  // Purge the share page (by share token)
  send_purge_request(getenv('WTS_WEB_ADDRESS')."/share/$share_token");
}
