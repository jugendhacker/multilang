<?php
/*
language to use by default
NULL or unset means to use the language provided by the browser

can't be null if $strict is set to true
*/
$use_lang=null;
/*
wheter the translator module should be set up strict, meaning it stays with the default language
if set on false your users might get a better user experience
	because the page is presented in their preferred language automatically, if this language is supported
*/
$strict=false;

//a get parameter called lang overrides the default language, if not in strict mode
if(!$strict){
	if(isset($_GET['lang'])){
		$lang=strtolower(substr($_GET['lang'],0,2));
		if(language_supported($lang)){
			$use_lang=$lang;
		}else{
			echo $_GET['lang'].' '.__('notsupported').".<br>".__('but').' ';
		}
	}
}

dictionary_setup();

function dictionary_setup($strict=false){
	global $dictionary;
	global $use_lang;
	$dictionary=array();
	$template=file("lang/dictionary");
	$dir=scandir("lang/");
	foreach($dir as $f){
		if($f=='.'||$f=='..'||$f=='dictionary') continue;
		$dictionary_file=file("lang/$f");
		for($i=0;$i<count($dictionary_file);$i++){
			$key=$template[$i];
			$dictionary[$f][$key]=$dictionary_file[$i];
		}
	}
	if(!$strict&&isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		//selects the users preferred language (from browser settings)
		$langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		foreach($langs as $l){
			if(language_supported($l)){
				$use_lang=$l;
				break;
			}
		}
	}
}

function language_supported($lang){
	return file_exists("lang/".$lang);
}

/**
the actual translating function
*/
function __($translate,$lang=null){
	global $use_lang;
	global $dictionary;
	if(empty($lang)){
		$lang=$use_lang;
	}
	return $dictionary[$lang][$translate];
}
