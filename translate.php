<?php
//your dictionary here!
$dictionary_file="dict.ini";
//language fallback
$use_lang="en";

dictionary_setup();

if(isset($_GET['lang'])){
	$lang=strtolower(substr($_GET['lang'],0,2));
	if(language_supported($lang)){
		$use_lang=$lang;
	}else{
		echo $_GET['lang'].' '.__('notsupported').".<br>".__('but').' ';
	}
}

function dictionary_setup(){
	global $dictionary_file;
	global $dictionary;
	global $use_lang;
	$dictionary_read=file($dictionary_file);
	$dictionary=array();
	$found_lang=false;
	foreach($dictionary_read as $l){
		if(strpos($l,'[')!==FALSE){//new language
			if($found_lang){//push previous language
				$dictionary[$found_lang]=$lang;
			}
			$lang=array();//reset current language
			$found_lang=substr($l,1,strlen($l)-4);//put name of active language
			continue;
		}elseif(strpos($l,':')===FALSE){continue;}//skip invalid lines
		$l=trim(explode("#",$l, 2)[0]);//remove comments (starting with #)
		if($l==''){continue;}//skip empty lines
		if(!$found_lang){continue;}//skip if a language was not yet found
		list($key,$value)=explode(":",$l,2);//explode key:value pairs
		$lang[$key]=$value;
	}
	$dictionary[$found_lang]=$lang;

	$langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
	for($i=0;$i<count($langs);$i++){
		if(language_supported(substr($langs[$i],0,2))){
			$use_lang=substr($langs[$i],0,2);
			break;
		}
	}
}

function __($translate,$lang=null){
	global $use_lang;
	global $dictionary;
	if(empty($lang)){
		$lang=$use_lang;
	}
	return $dictionary[$lang][$translate];
}

function language_supported($lang){
	global $dictionary;
	return in_array($lang,array_keys($dictionary));
}

?>
