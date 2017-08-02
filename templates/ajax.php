<?php

	//simple HTTP GET used by the ajax-stuff in the infin-payment-admin page

	$link 			= $_GET['url'];
	$http_response 	= "";
	$url 			= parse_url($link);

	$fp 			= fsockopen($url['host'], 80, $err_num, $err_msg, 30) or die("Socket-open failed--error: ".$err_num." ".$err_msg);

	fputs($fp, "GET {$url['path']}/?{$url['query']} HTTP/1.1\r\n");
	fputs($fp, "Host: {$url['host']}\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	
	while(!feof($fp)) {
		$http_response .= fgets($fp, 128);
	}
	fclose($fp);

	$output = explode("\n",$http_response);
	echo $output[count($output)-1];

?>