<?php

use Slim\Psr7\Response as Response;

// Load template file with given parameters and return a string
function template(string $template_filename, array $parameters = []): string {
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
function error_response(Response $response, string $message, int $status_code = 500, array $errors = []): Response {
  $response->getBody()->write('{
    "message": "' . $message . '",
    "errors": ' . json_encode($errors) . '}
  ');
  return $response->withStatus($status_code)->withHeader('Content-type', 'application/json');
}

function send_purge_request(string $url): void {
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

function clear_varnish_cache(string $id, string $share_token): void {
  // Only purge when it's enabled
  if (getenv('WTS_CLEAR_CACHE') != 1) {
    return;
  }

  // Purge the admin page (by ID)
  send_purge_request(getenv('WTS_WEB_ADDRESS')."/$id");

  // Purge the share page (by share token)
  send_purge_request(getenv('WTS_WEB_ADDRESS')."/share/$share_token");
}
