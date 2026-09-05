<?php

function div_InfoName($divcontent)
{
	$return_str =	'<div id="'.$divcontent['divclass'].'">';
  $return_str .=	'<strong>&nbsp;'.$divcontent['label'].'</strong>';
  $return_str .=	'<span class="'.$divcontent['span'].'">&nbsp;'.$divcontent['value'].'</span>';
  $return_str .=	'</div>';
	return $return_str;
}

function div_InfoName2($divcontent)
{
	$return_str =	'<div id="'.$divcontent['divclass'].'">';
  $return_str .=	'<strong>&nbsp;'.$divcontent['label'].'</strong>';
  $return_str .=	'<span class="'.$divcontent['spandot'].'">&nbsp;'.$divcontent['space'].'</span>';
  $return_str .=	'<span class="'.$divcontent['span'].'">&nbsp;'.$divcontent['value'].'</span>';
  $return_str .=	'</div>';
	return $return_str;
}

function div_default($divcontent)
{
	$return_str =	'<div id="'.$divcontent['divid'].'"  class= "'.$divcontent['divclass'].'">';
	$return_str .= ''.$divcontent['content'];
	$return_str .=	'</div>';
	return $return_str;
}

function div_break($divcontent)
{
	$return_str =	'';
	$return_str .=	'<div style="clear:both">'.$divcontent['content'].'</div>';
	return $return_str;
}

function default_button($button)
{
	$return_str =	'';
	$return_str .=	'	<a class="pure-button pure-button-primary" ';
	$return_str .=	' href="'.$button['url'].'"> ';
	$return_str .=	$button['name'] . ' </a>';
	return $return_str;
}

function back_button($button)
{
	$return_str =	'';
	$return_str .=	'	<a class="pure-button pure-button-primary" ';
	$return_str .=	' href="'.$button['url'].'"> ';
	$return_str .=	'<i class="fa fa-arrow-left"> </i> Back</a>';
	return $return_str;
}

function print_button($button)
{
	$return_str =	'';
	$return_str .=	'<a class="pure-button pure-button-primary" ';
	$return_str .=	' href="'.$button['url'].'"> ';
	$return_str .=	'<i class="fa fa-print"> </i> Print</a>';
	return $return_str;
}

function divtest($divcontent)
{
	$return_str =	$divcontent;
	return $return_str;
}

?>