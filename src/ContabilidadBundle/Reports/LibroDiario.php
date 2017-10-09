<?php

namespace ContabilidadBundle\Reports;
    
class LibroDiario extends \FPDF {
    /**
     * @var string
     */
	private $rootDir;
	
    private $cuentaMayor;
    
    public function setCuentaMayor($cuentaMayor) {
        $this->cuentaMayor =$cuentaMayor;
        return $this;
    }
    
    public function getCuentaMayor() { 
        return $this->cuentaMayor;
    }
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
	
    function __construct($orientation='L', $unit='mm', $format='A4', $ejercicio=null, $apuntes=null,$rootDir=null) {    
        parent::__construct($orientation, $unit, $format);
        $this->ejercicio = $ejercicio;
        $this->rootDir = $rootDir;
        $this->genera($apuntes);
    }
    
    function Header() {
        $this->SetMargins(1,1);
        $this->SetFont('arial','B',8);
        $this->Cell(280,10,utf8_decode('Fecha Impresión: ').date('d/m/Y'),0,0,'R');
        $this->Ln(1);
        $this->SetFont('arial','B',15);
        $this->Cell(290,10,'C.D.B CARACAL FUENLABRADA ',0,0,'C');
        $this->Ln(6);
        $this->Cell(290,10,'LIBRO DIARIO DE ASIENTOS CONTABLES',0,0,'C');
        $this->image($this->rootDir.'/src/img/LogoCaracal.png',2,2,25,30);
        $this->SetFont('arial','B',12);
        $this->Cell(290,10,'EJERCICIO: '.$this->getEjercicio()->getDescripcion(),0,0,'C');
        $this->Ln(25);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('arial','B',8);
        $this->Cell(280,5,utf8_decode('Página: ').$this->PageNo().' / {nb}',0,0,'R');
        $this->Ln();
    }
    
    function cabeceraAsiento($Apunte) {
        $this->SetFillColor(230);
        $this->SetFont('arial','B',9);
        $this->Cell(25,8, utf8_decode(' Nº Asiento: ').$Apunte['asientoNumero'],0,0,'C',1);
        $this->Cell(45,8,' Fecha Asiento: '.$Apunte['asientoFecha'],0,0,'C',1);
        $this->Cell(220,8,' Concepto: '.utf8_decode($Apunte['asientoDescripcion']),0,0,'L',1);
        $this->Ln();
        $this->SetFont('arial','BIU',8);
        $this->Cell(20,5,utf8_decode('Nº Apunte'),0,0,'C',1);
        $this->Cell(100,5,utf8_decode('Concepto'),0,0,'C',1);
        $this->Cell(120,5,utf8_decode('Cuenta de Mayor'),0,0,'C',1);
        $this->Cell(25,5,utf8_decode('Importe Debe'),0,0,'C',1);
        $this->Cell(25,5,utf8_decode('Importe Haber'),0,0,'C',1);
        $this->Ln();
        $this->SetFont('arial','',8);
    }
    
    public function genera($Apuntes) { 
        
        $this->AddPage();
        $this->AliasNbPages(); 
        $relleno=true;
        $borde=false;
        define('EURO', chr(128));
        $antAsiento = 0;
        $ctLineas = 0;
        $numLineas = 18;
        foreach ($Apuntes as $Apunte){
            
            if ($Apunte["asientoId"] != $antAsiento) {
                $this->cabeceraAsiento($Apunte);
                $antAsiento = $Apunte["asientoId"];
                $ctLineas+2;
            }       
        
            $borde=false;
            if ($ctLineas > $numLineas ) {
                $this->AddPage ();
                $this->cabeceraAsiento($Apunte);
                $ctLineas=0;
            }
            
            $this->Cell(20,5,$Apunte['apunteNumero'],0,0,'C',0);
            $this->Cell(100,5,utf8_decode($Apunte['apunteDescripcion']),0,0,'L',0);
            $this->Ln(3);
            if ( $Apunte['importeDebe'] > 0 ) {
                if ($ctLineas > $numLineas ) {
                    $this->AddPage ();
                    $this->cabeceraAsiento($Apunte);
                    $ctLineas=0;
                }
                $this->Cell(80,5,'',0,0,'C',0);
                $this->Cell(160,5,utf8_decode($Apunte['cuentaDebe']),0,0,'L',0);
                $this->Cell(25,5,number_format($Apunte['importeDebe'],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
                $this->ln();
                $ctLineas++;
            }
            if ( $Apunte['importeHaber'] > 0 ) {
                if ($ctLineas > $numLineas ) {
                    $this->AddPage ();
                    $this->cabeceraAsiento($Apunte);
                    $ctLineas=0;
                }
                $this->Cell(80,5,'',0,0,'C',0);
                $this->Cell(160,5, utf8_decode($Apunte['cuentaHaber']),0,0,'L',0);
                $this->Cell(25,5,'',0,0,'C',0);
                $this->Cell(25,5,number_format($Apunte['importeHaber'],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
                $this->Ln();
                $ctLineas++;
            }
            $ctLineas++;
        }
   }
   
}
?>