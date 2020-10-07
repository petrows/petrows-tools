<?php
@header('Content-Type: text/plain; charset=UTF-8');
@header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
@header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
@header('Pragma: no-cache');

$out = array();

$out[] = @$_SERVER['REMOTE_ADDR'];
$out[] = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
$out[] = @$_SERVER['HTTP_USER_AGENT'];

$out = implode("\n", $out)."\n";

@header('Content-Length: '.strlen($out));

echo $out;
