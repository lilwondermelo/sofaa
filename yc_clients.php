<?php
	$type = 'POST';
	$args = array('page_size' => 200);
	$data = array();
	require_once 'ycClass.php';
	$ycClass = new YCClass('ablaser');

	$result = $ycClass->apiQuery($type, $args);
	//$count = $result['meta']['total_count']/200;

	
	var_dump($result);
	


	


	



?>