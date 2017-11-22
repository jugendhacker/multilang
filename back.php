<?php
include "translate.php";
if(empty($_POST['update'])){
	header_remove();
	header("Content-type:application/json",true,200);
	echo json_encode($dictionary);
	exit;
}else{
	$update = json_decode($_POST['update']);
	if(!is_array($update))
		exit(1);
	foreach ($update as $elem) {
		if(property_exists($elem,'key')){
			// this is a value update for a particular language
			$lang_path=$dict_dir.DIRECTORY_SEPARATOR.$elem->lang;
			if(file_exists($lang_path)){
				$f=file($dict_dir.DIRECTORY_SEPARATOR.'dictionary',FILE_IGNORE_NEW_LINES);
				$lineno=array_search($elem->key,$f);
				$f=file($dict_dir.DIRECTORY_SEPARATOR.$elem->lang);
				$f[$lineno]=$elem->value."\n";
				file_put_contents($lang_path,$f);
			}
		}else{
			// this is a key update
			$f=file($dict_dir.DIRECTORY_SEPARATOR.'dictionary',FILE_IGNORE_NEW_LINES);
			$lineno=array_search($elem->prev,$f);
			$f[$lineno]=$elem->new;
			file_put_contents($dict_dir.DIRECTORY_SEPARATOR.'dictionary',implode("\n",$f)."\n");
		}
	}
}
