<?php
class Npdf{
	private  $_fpdf;

	private function __construct(){
			$this->_fpdf = new Fpdf();
	}
	
	public function Header($title){
		$_fpdf->Image('images/mpa_oldlogo1.png',10,6,20
		$_fpdf->SetFont('Times','B',15);
		$_fpdf->Cell(80);
		$_fpdf->Cell(30,10,$title,1,0,'C');
		$_fpdf->Ln(20);
	}

	public function Chapter(){
	}

	public function Mybody(){
	}

	public function Layout(){
	}

	public function Footer(){
		$_fpdf->SetY(-15);
    	$_fpdf->SetFont('Arial','I',8);
    	$_fpdf->Cell(0,10,'Page '.$_fpdf->PageNo().'/{nb}',0,0,'C');
	}

	
}


?>  