<?php
	$file = "/ssl-cert/server.pem";

if (file_exists($file) && is_file($file))
{
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="localhost.crt"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush();
    readfile($file);
}
else {
	header("HTTP/1.0 404 Not Found");
	die("Error: The file $file does not exist!");
}
