<?php
    session_start();
    ob_end_clean();
    include '../../comunes/fpdf/fpdf.php';
    include '../../comunes/funciones.php';
    include '../../comunes/funcionesContabilidad.php';
    include '../../comunes/conexion.php';
    include '../../comunes/variableStream.php';

    $idEjercicio = $_SESSION['ejercicio_id'];
    $idCuentaMayor = $_GET['idCuentaMayor'];
    $dsEjercicio = fdescEjercicio($idEjercicio);
    $fecha =date('d/m/Y h:i:s');

    class PDF extends FPDF {
        function Header() {
            global $dsEjercicio,$fecha,$ctLineas,$idCuentaMayor;
            $this->SetMargins(1,1);
            // $this->Ln(1);
            $this->SetFont('arial','B',8);
            $this->Cell(200,10,utf8_decode('Fecha Impresión: ').$fecha,0,0,'R');
            $this->Ln(1);
            $this->SetFont('arial','B',15);
            $this->Cell(210,10,'C.D.B CARACAL FUENLABRADA ',0,0,'C');
            $this->Ln(6);
            $this->Cell(210,10,'APUNTES CONTABLES DE LA CUENTA',0,0,'C');
            $this->Ln(6);
            $this->SetFont('arial','BIU',13);
            $this->Cell(210,10,utf8_decode(fdescCuentaMayor($idCuentaMayor)),0,0,'C');
            $this->image('../../comunes/img/logo.jpg',2,2,25,25);
            $this->Ln(6);
            $this->SetFont('arial','B',12);
            $this->Cell(210,10,'EJERCICIO: '.$dsEjercicio,0,0,'C');
            $this->Ln(15);
            $this->SetFillColor(230);
            $this->SetFont('arial','BIU',8);
            $this->Cell(15,5, utf8_decode('Nº Asiento'),0,0,'C',1);
            $this->Cell(25,5,'Fecha Asiento',0,0,'C',1);
            $this->Cell(15,5,utf8_decode('Nº Apunte'),0,0,'C',1);
            $this->Cell(100,5,'Concepto',0,0,'C',1);
            $this->Cell(25,5,'Importe Debe',0,0,'C',1);
            $this->Cell(25,5,'Importe Haber',0,0,'C',1);
            $this->Ln();
            $this->SetFont('arial','',8);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('arial','BI',7);
            $this->Cell(200,5,utf8_decode('Página: ').$this->PageNo().' / {nb}',0,0,'R');
            $this->Ln();
        }
    }
  
    $rstApuntes = selectApuntesCuenta($idCuentaMayor, $idEjercicio);
    
    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFillColor(230);
    $pdf->AliasNbPages(); // ESTO NOS DEFINE EL NÚMERO TOTAL DE PÁGINAS DEL LISTADO
    $relleno=false;
    $borde=false;
    define('EURO', chr(128));
    $totalDebe=0;
    $totalHaber=0;
    $saldo=0;
    foreach ($rstApuntes as $Apunte){
        $pdf->Cell(15,5, $Apunte['nmAsiento'],0,0,'C',$relleno);
        $pdf->Cell(25,5,$Apunte['fcAsiento'],0,0,'C',$relleno);
        $pdf->Cell(15,5,utf8_decode($Apunte['nmApunte']),0,0,'C',$relleno);
        $pdf->Cell(100,5,utf8_decode($Apunte['dsApunte']),0,0,'L',$relleno);
        if ( $Apunte['importeDebe'] == 0 )
            $pdf->Cell(25,5,' ',$borde,0,'R',$relleno);
        else 
            $pdf->Cell(25,5,number_format($Apunte['importeDebe'],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
        if ( $Apunte['importeHaber'] == 0 )
            $pdf->Cell(25,5,' ',$borde,0,'R',$relleno);
        else
            $pdf->Cell(25,5,number_format($Apunte['importeHaber'],2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
        
        $totalDebe = $totalDebe + $Apunte['importeDebe'];
        $totalHaber = $totalHaber + $Apunte['importeHaber'];
        $pdf->Ln();
   }
    $relleno=true;
    $borde =false;
    $saldo = $totalHaber -$totalDebe;
    $pdf->SetFont('arial','BI',8);
    $pdf->Cell(155,5,'Totales',$borde,0,'R',$relleno);
    if ($totalDebe == 0 )
        $pdf->Cell(25,5,' ',$borde,0,'R',$relleno);
    else 
        $pdf->Cell(25,5,number_format($totalDebe,2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
    if ($totalHaber == 0 )
        $pdf->Cell(25,5,' ',$borde,0,'R',$relleno);
    else
        $pdf->Cell(25,5,number_format($totalHaber,2, ',', '.').' '.EURO,$borde,0,'R',$relleno);
    $pdf->Ln();
    $pdf->Cell(155,5,'Saldo',$borde,0,'R',$relleno);
    $pdf->Cell(50,5,number_format($saldo,2, ',', '.').' '.EURO,$borde,0,'C',$relleno);
    
    $pdf->Output('D','apuntesCuenta.pdf');
    
?>