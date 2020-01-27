<?php

namespace App;

use Fpdf\Fpdf;
use App\Contrato;
use Illuminate\Database\Eloquent\Model;

class PDFContratosAtivos extends Fpdf
{  
   // Page header
   function Header()
   { 
      $this->SetTopMargin(10);
      $this->SetLeftMargin(10);
      $this->SetRightMargin(10);      
      $this->SetFont('Arial', 'B', 12);            
      $this->Image(public_path('/storage/logos/logo-FCAti-512.png'), 10, 0, 30);  
      $this->Ln(3);
      $this->Cell(50, 6, '' , 0, 0, 'L', false);     
      $this->Cell(60, 6, utf8_decode('Impresão de contratos ativos em '. \Carbon\Carbon::now()->format('d/m/Y')) , 0, 1, 'L', false);
      $this->Ln(15);
      $this->SetFont('Arial', 'B', 8);    
      $this->Cell(90, 6,'Empresa', 'B', 0, 'C', false);                  
      $this->Cell(19, 6,'Contrato', 'B', 0, 'C', false);
      $this->Cell(19, 6,'Vencimento', 'B', 0, 'C', false);
      $this->Cell(10, 6,'Valor', 'B', 0, 'C', false);
      $this->Cell(19, 6,'Adicional','B', 0, 'C', false);
      $this->Cell(19, 6,'Hora Extra', 'B', 0, 'C', false);
      $this->Cell(15, 6, utf8_decode('Usuário'), 'B', 0, 'c', false);
      $this->Ln(15);
   }           
  
}

//////outra parte 


