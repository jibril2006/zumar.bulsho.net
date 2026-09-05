<?php

class Currentvaluta {
	
	public function show($currency){

		$file = 'http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da';
		$hndl = @fopen($file,'r');
		
		if($hndl !== false){
		   
				$xml = simplexml_load_file($file);
				$element = $xml->xpath('dailyrates/currency[@code="' . $currency . '"]/@rate');
				return $element[0];
		   
		}
		else
		{
		   return false;
		}
			
	}
		

}


?>