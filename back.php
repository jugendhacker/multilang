<?php
include "translate.php";
if (isset($_GET['langs'])){
	header_remove();
	http_response_code(200);
	header("Content-type:application/json");
	echo json_encode($dictionary);
}elseif (isset($_GET['keys'])){
	header_remove();
	http_response_code(200);
	header("Content-type: application/json");
	echo json_encode(array_keys($dictionary[array_keys($dictionary)[0]]));
}elseif (isset($_POST)){
	header_remove();
	http_response_code(200);
	save($HTTP_RAW_POST_DATA);
}
function save($data){
	global $dictionary;
	$data=json_decode($data);
	$dictionary=array();
	for ($i=0; $i < count($data); $i++) {
		$alias='';
		foreach ($data[$i] as $key => $value) {
			if($key=='Key'){
				$alias=$value;
			}else{
				$dictionary[$key][$alias]=$value;
			}
		}
	}
	var_dump($dictionary);
}
