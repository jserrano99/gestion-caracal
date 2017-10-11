<?php
/* LIBRO MAYOR */

namespace ContabilidadBundle\Reports;

class Balance extends \FPDF {
    /**
     * @var string
     */
	private $rootDir;
	
    /**
     * @var \ContabilidadBundle\Entity\Ejercicio
     */
	private $ejercicio;
            
	public function setRoorDir($rootDir) {
		$this->rootDir = $rootDir;
        return $this;
	}
	
	public function getRootDir () {
        return $this->rootDir;
	}
   
	public function setEjercicio (\ContabilidadBundle\Entity\Ejercicio $ejercicio=null) {
		$this->ejercicio = $ejercicio;
        return $this;
	}
	
	public function getEjercicio () {

        return $this->ejercicio;
	}
	
    function __construct($orientation='P', $unit='mm', $format='A4', $ejercicio=null, $apuntes=null,$rootDir=null) {    
        parent::__construct($orientation, $unit, $format);
        $this->ejercicio = $ejercicio;
        $this->rootDir = $rootDir;
        $this->genera($apuntes);
    }
    
    function Header() {
        $this->SetMargins(3,3);
        $this->image($this->rootDir.'/src/img/LogoCaracal.png',2,2,25,30);
        $this->SetFont('Arial','B',8);
        $this->Cell(200,10,'Fecha: '.date('d/m/Y'),0,0,'R');
        $this->Ln(5);
        $this->SetFont('Arial','B',15);
        $this->Cell(210,10,'C.D.B CARACAL FUENLABRADA ',0,0,'C');
        $this->Ln(7);
        $this->Cell(210,10,'BALANCE EJERCICIO',0,0,'C');
        $this->Ln(7);
        $this->SetFont('Arial','B',12);
        $this->Cell(210,10,'EJERCICIO: '.$this->getEjercicio()->getDescripcion(),0,0,'C');
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial',"B",8);  
        $this->Cell(200,5,utf8_decode('Página: ').$this->PageNo().' / {nb}',0,0,'R');
        $this->Ln();
    }

    public function genera($Apuntes) {
        $this->AddPage();
        $relleno=false;
        $borde=false;
        $antNivel0= null;
        $antNivel1= null;
        $antNivel2= null;
        $antNivel3= null;
        $antNivel4= null;
        $totalDebe =0;
        $totalHaber = 0;
        $this->AliasNbPages();
        define('EURO', chr(128));
        foreach ($Apuntes as $Apunte) {
            if ($antNivel0 != $Apunte["nivel_0"]) {
                $antNivel0 = $Apunte["nivel_0"];
                $this->SetFont('Arial','B',10);
                $this->Cell(210,5, utf8_decode($Apunte["nivel_0"]),$borde,0,'L',$relleno);
                $this->Ln();
            }
            if ($antNivel1 != $Apunte["nivel_1"]) {
                $antNivel1 = $Apunte["nivel_1"];
                $this->SetFont('Arial','',9);
                $this->Cell(5,5, ' ',$borde,0,'L',$relleno);
                $this->Cell(200,5, utf8_decode($Apunte["nivel_1"]),$borde,0,'L',$relleno);
                $this->Ln();
            }
            if ($antNivel2 != $Apunte["nivel_2"]) {
                $antNivel2 = $Apunte["nivel_2"];
                $this->SetFont('Arial','',8);
                $this->Cell(10,5, ' ',$borde,0,'L',$relleno);
                $this->Cell(190,5, utf8_decode($Apunte["nivel_2"]),$borde,0,'L',$relleno);
                $this->Ln();
            }
            if ($antNivel3 != $Apunte["nivel_3"]) {
                $antNivel3 = $Apunte["nivel_3"];
                $this->SetFont('Arial','',8);
                $this->Cell(15,5, ' ',$borde,0,'L',$relleno);
                $this->Cell(180,5, utf8_decode($Apunte["nivel_3"]),$borde,0,'L',$relleno);
                $this->Ln();
            }
            $this->Cell(155,5, utf8_decode($Apunte["cuenta_mayor"]),$borde,0,'L',$relleno);
            $this->Cell(20,5,number_format($Apunte["importe_debe"],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
            $this->Cell(20,5,number_format($Apunte["importe_haber"],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
            $this->ln();
            $totalDebe += $Apunte["importe_debe"];
            $totalHaber += $Apunte["importe_haber"];
            
            if ($antNivel4 != $Apunte["nivel_4"]) {
                $antNivel4 = $Apunte["nivel_4"];
                $this->SetFont('Arial','',8);
                $this->Cell(20,5, ' ',$borde,0,'L',$relleno);
                $this->Cell(155,5, utf8_decode($Apunte["nivel_4"]),$borde,0,'L',$relleno);
                $saldo = $totalDebe + $totalHaber;
                $this->Cell(20,5,number_format($saldo,2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
                $this->ln();
                $totalDebe=0;
                $totalHaber=0;
            }
            
        }
    }
}
?>