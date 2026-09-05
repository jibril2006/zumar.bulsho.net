<?php
class Boxmenu {
	
  private $frontrow_data;
  public $pginfo = array();
	
	
	public static function frontrow($class, $frontrow_data){

		$frontrow .= '<div class="frontrow1">';
		$frontrow .= $frontrow_data;
		$frontrow .= '</div>';

		return $frontrow;
	}
	
	public static function frontdiv($class, $value){
		$frontdiv .= '<div class="frontdiv">';
		$frontdiv .= '<a class="hMenuKnap" href="../'.$name.'/">';
		$frontdiv .= '	<span class="hIcon'.$name.'"></span>';
		$frontdiv .= '	<span class="hMenuKnapHl">'.$name.'</span>';
		$frontdiv .= '	<span class="hMenuKnapText">'.$name.'</span>';
		$frontdiv .= '</a>';
		$frontdiv .= '</div>';
		return $frontdiv;

	}
	
	
}

?>  