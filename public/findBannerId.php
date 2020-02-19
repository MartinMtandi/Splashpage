<?php

session_start();

$raw_url = '';
if(array_key_exists('rawURL', $_GET)){
	$raw_url =  $_GET['rawURL'];
}

$arr = parse_url($raw_url);
$raw_get = '';

if(array_key_exists('query', $arr)){
	 $raw_get = $arr['query'];
}

//split on &
$parts = explode('&',$raw_get);
$banner_id = 0;

foreach($parts as $part)
{
	//find banner id
	if(strpos($part, 'banner_id') !== false)
	{
		//split on =
		$tmp = explode('=', $part);
		$banner_id =  (int)$tmp[1];
		
		//store in session
		$_SESSION['banner_id'] = $banner_id;
		
		//exit the looping
		break;
	}
	
}
echo $banner_id;