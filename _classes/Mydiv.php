<?php
class Mydiv {
	
	private $div;
	private $divStart;
  private $divEnd;
  private $div_pagenr;
  private $li_pagenr_left;
  private $li_pagenr_center;
  private $li_pagenr_right;
  public $pginfo = array();
	
	public static function exists($name){
		return (isset($_SESSION[$name])) ? true: false;	
	}
	
	public static function div($class, $value){
		return '<div class="'.$class.'">'.$value.'</div>';
	}
	
	public static function div_left($class, $value){
		return '<div class="'.$class.'" style="float:left;">'.$value.'</div>';
	}
	
	public static function div_right($class, $value){
		return '<div class="'.$class.'" style="float:right;">'.$value.'</div>';
	}
	
	public static function div_space($pxnr,$value){
		if($value == '') $value = '&emsp;';
		return '<div style="float:left;width:'.$pxnr.'px;">'.$value.'</div>';
	}
	
	public static function div_input($star, $inputname, $name, $class, $value){
		
		$starvalue = '<strong>*</strong>';
		$divresult = '<div>
    <label for="'.$inputname.'">'.$name.' '. ( isset( $star ) ? $starvalue : '' ) .' </label>
    <input type="text" name="'.inputname.'" value="' . ( isset( $value ) ? $value : '' ) . '">
    </div>';
		return $divresult;
		
	}
	
	public static function span($class, $value){
		return '<span class="'.$class.'">'.$value.'</span>';
	}
	
	
}

?>  