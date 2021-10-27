<?php
include_once('../plugins/fpdf/fpdf.php');

setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');
date_default_timezone_set('America/Caracas');



class PDF extends FPDF
{
	


	function Footer(){
	        // Posición: a 1,5 cm del final
	 
      
    }

    function Header(){
		//Define tipo de letra a usar, Arial, Negrita, 15
		$this->SetFont('Arial','B',9);
		/* Líneas paralelas
		 * Line(x1,y1,x2,y2)
		 * El origen es la esquina superior izquierda
		 * Cambien los parámetros y chequen las posiciones
		 * */
		/* Explicaré el primer Cell() (Los siguientes son similares)
		 * 30 : de ancho
		 * 25 : de alto
		 * ' ' : sin texto
		 * 0 : sin borde
		 * 0 : Lo siguiente en el código va a la derecha (en este caso la segunda celda)
		 * 'C' : Texto Centrado
		 * $this->Image('images/logo.png', 152,12, 19) Método para insertar imagen
		 *     'images/logo.png' : ruta de la imagen
		 *         152 : posición X (recordar que el origen es la esquina superior izquierda)
		 *         12 : posición Y
		 *     19 : Ancho de la imagen <span class="wp-smiley emoji emoji-wordpress" title="(w)">(w)</span>
		 *     Nota: Al no especificar el alto de la imagen (h), éste se calcula automáticamente
		 * */
		//$this->Cell($this->Image('../images/logo.png',5,5,100,15));
		
	}


	function Titulo($titulo)
    {
        $this->SetXY(0, 10);
        $this->SetFont('Arial','B',14);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->Cell(30,6, utf8_decode($titulo),0,0,'C' );
        
    }
    function Cajetin()
    {
        $this->SetXY(0, 16);
        $this->SetFont('Arial','B',11);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->Cell(140,130,'',1,0,'C');
        
    }

    function Confirmation($Confirmation)
    {
        $this->SetXY(0, 20);
        $this->SetFont('Arial','B',8);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->Cell(42,7, utf8_decode($Confirmation),0,0,'C' );
        
    }

    function Fecha($fecha)
    {
        $this->SetXY(0, 14);
        $this->SetFont('Arial','B',8);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->Cell(200,20, utf8_decode($fecha),0,0,'C' );
        
    }

    function Encabezados($linea1)
    {
        $this->SetXY(25, 42);
        $this->SetFont('Arial','',10);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->MultiCell(160,5, utf8_decode($linea1),0,'J' );
        

    }

    function Titulo2($titulo2)
    {
        $this->SetXY(0, 60);
        $this->SetFont('Arial','B',14);
            //Atención!! el parámetro valor 0, hace que sea horizontal
        $this->Cell(210,6, utf8_decode($titulo2),0,0,'C' );
        
    }

   
    function TitulosTabla($titulos_t)
    {
        $posicion_x = -40;
        $posicion_y = 25;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','',7);
        foreach($titulos_t as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($fila == 'Name') {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                 
            }
            elseif($fila == 'Addres') {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                 
            }elseif($fila == 'Airline and Arrival time') {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
            }elseif($fila == 'Comments'){
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
            }else{
                $posicion_x = $posicion_x+40;
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
            }
                  
        } 
    }

    function DatosTabla($datos)
    {
        $posicion_x = -40;
        $posicion_y = 32;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','B',7);
        $i=0;
        foreach($datos as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($i == 3) {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++; 
                 
            }
            elseif($i ==6) {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++; 
                 
            }elseif($i == 9) {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++; 
            }elseif ($i == 12) {
                $posicion_x= 0;
                $posicion_y = $posicion_y+14;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++; 
            }else{
                $posicion_x = $posicion_x+40;
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++; 
            }
                   
        } 
    }

    function TitulosTabla2($titulos_t2,$posy)
    {
        $posicion_x = 0;
        $posicion_y = $posy;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','B',7);
        $i = 0;
        foreach($titulos_t2 as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($i > 0) {
                $posicion_x= 5;
                $posicion_y = $posicion_y+7;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(20,7, utf8_decode($fila),'T','L');
                $i++;
            }else{
                $posicion_x = $posicion_x+5;
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(20,7, utf8_decode($fila),'T','L');
                $i++;
            }
                  
        } 
    }

    function TitulosTablaExtras($titulos_te,$max)
    {
        $posicion_x = 0;
        $posicion_y = 90;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('');
        $flagLong = 0;
        foreach($titulos_te as $fila)
        {
            $posicion_x += 15;
            $this->SetXY($posicion_x, $posicion_y); 
            $width = 0;
            if($flagLong == 0){
                //$width = 50;
                $posicion_x += 15;
            }elseif ($flagLong == 1) {
                //$width = 50;
            }{
                $width = 20;
            }
            $flagLong++;
            $this->Cell($width,7, utf8_decode($fila),1,'T','L');
        } 
    }

    function BasicTable($header, $data,$isReturn)
    {
        $posicion_x = 30;
        $posicion_y = 80;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','',7);
        $this->MultiCell(40,7, utf8_decode("Extras"),0,'L');

        $posicion_x = 30;
        $posicion_y = 90;
        $this->SetXY($posicion_x, $posicion_y);
        // Column widths
        if($isReturn){
            $w = array(40, 15, 15, 15);    
        }else{
            $w = array(40, 15, 15);    
        }
        
        // Header
        $posicion_y += 6;
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->SetXY($posicion_x, $posicion_y);
        // Data
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR');
            $this->Cell($w[1],6,$row[1],'LR');
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
            if($isReturn){
                $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');    
            }
            $posicion_y += 6;
            $this->SetXY($posicion_x, $posicion_y);
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

    function DatosTablaExtras($datos_te,$posy)
    {
        $posicion_x = 0;
        $posicion_y = 100+$posy;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('');
        $flagLong = 0;
        foreach($datos_te as $fila)
        {
                
                $posicion_x += 15;
                $this->SetXY($posicion_x, $posicion_y); 
                foreach ($fila as $data) {
                    $width = 0;
                    if(strlen($data) > 20){
                        $width = 50;
                    }elseif ($flagLong == 1) {
                        $width = 50;
                    }{
                        $width = 20;
                    }
                    $flagLong++;
                    $this->Cell($width,7, utf8_decode($data),1,'T','L');
                }
                
        } 
    }

    function DatosTabla2($datos2,$posy)
    {
        $posicion_x = 0;
        $posicion_y = $posy;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','B',7);
        $i=0;
        foreach($datos2 as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($i > 0) {
                $posicion_x= 25;
                $posicion_y = $posicion_y+7;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(30,7, utf8_decode($fila.',00 USD'),'T','L');
                $i++; 
                 
            }
            else{
                $posicion_x = $posicion_x+25;
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(30,7, utf8_decode($fila.',00 USD'),'T','L');
                $i++; 
            }
                   
        } 
    }


    function TitulosTabla3($titulos_t3)
    {
        $posicion_x = 0;
        $posicion_y = 90;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','',7);
        $i=0;
        foreach($titulos_t3 as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($i == 1) {
                $posicion_x= 0;
                $posicion_y = $posicion_y+12;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++;
                 
            }else{
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(40,7, utf8_decode($fila),0,'L');
                $i++;
            }
                  
        } 
    }

    function DatosTabla3($datos3)
    {
        $posicion_x = 0;
        $posicion_y = 95;
        $this->SetXY($posicion_x, $posicion_y);
        $this->SetFont('Arial','B',7);
        $i=0;
        foreach($datos3 as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($i == 1) {
                $posicion_y = $posicion_y+12;
                $this->SetXY($posicion_x, $posicion_y);
                $this->MultiCell(30,7, utf8_decode($fila),0,'L');
                $i++; 
                 
            }
            else{
                $this->SetXY($posicion_x, $posicion_y); 
                $this->MultiCell(30,7, utf8_decode($fila),0,'L');
                $i++; 
            }
                   
        } 
    }
};//fin clase PDF
?>