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


public function allContratosActivePDF()
{
    try {                   
        $pdf = new PDFContratosAtivos();
        $pdf->AddPage('P', 'A4');            
        $pdf->SetFont('Arial', 'B', 12);
                   
        $allContracts = Contrato::all();
        $allcontractsGroupByType = $allContracts->groupBy('contrato_tipo_id');
        $numberReportContracts = 0;
        $valueReportContracts = 0;

        foreach ( $allcontractsGroupByType as $index => $contractsbelongToType )
        {   
            $contratoTipo = ContratoTipo::find($index);
            $pdf->SetFont('', 'B', 9);
            $pdf->Cell(45, 6, substr(utf8_decode($contratoTipo ? $contratoTipo->nome : "Contrato tipo Não existe!") , 0 , 40 ), 0, 1, 'L', false);  
           
            $numberOfContractsByType = 0;
            $valueOfContractsByType = 0;
            
            foreach ( $contractsbelongToType as $contract)
            {             
                $pdf->SetFont('', '', 8);                                                   
                /* --- Cell --- */                    
                $pdf->Cell(75, 6, substr(utf8_decode($contract->empresa->razao_social), 0 , 40), 1, 0, 'L', false);
                /* --- Cell --- */                   
                $pdf->Cell(35, 6, substr(utf8_decode($contract->contrato_tipos->nome ?? ""), 0 , 21), 1, 0, 'C', false);
                /* --- Cell --- */                   
                $pdf->Cell(10, 6, '10', 1, 0, 'C', false);
                /* --- Cell --- */                   
                $pdf->Cell(20, 6, number_format($contract->valor, 2, ',', '.'), 1, 0, 'C', false);
                /* --- Cell --- */                   
                $pdf->Cell(20, 6, number_format($contract->valor_adicional, 2, ',', '.'), 1,0, 'C', false);
                /* --- Cell --- */                   
                $pdf->Cell(10, 6, substr('0', 0, 6), 1, 0, 'C', false);
                /* --- Cell --- */                  
                $pdf->Cell(20, 6, substr(utf8_decode($contract->user->name), 0, 12), 1, 1, 'C', false); 

                $numberOfContractsByType++;               
                $valueOfContractsByType += $contract->valor;

                $numberReportContracts++;
                $valueReportContracts += $contract->valor;
            }
            $pdf->Ln(4); 
            $pdf->SetFont('', 'B', 9);  
            $pdf->Cell(160, 6, 'Total de ' .  $numberOfContractsByType . ' contrato(s)', "B", 0, 'L', false);
            $pdf->Cell(30, 6, 'R$: ' . number_format($valueOfContractsByType, 2, ',', '.'), "B", 1, 'C', false);
         
            $pdf->Ln(10);                                                           
              
        }

        $pdf->Cell(160, 6, utf8_decode('Total de ' .  $numberReportContracts . ' contrato(s) do relatório'), "B", 0, 'L', false);
        $pdf->Cell(30, 6, 'R$: ' . number_format($valueReportContracts, 2, ',', '.'), "B", 1, 'C', false);

        //return $file_path;
        $response = response($pdf->Output('S'));

        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'inline; filename="output.pdf"');
        $response->header('Cache-Control:', 'private, max-age=0, must-revalidate');

        return $response;
        
    } catch (\Exception $e) {
        \Log::error('function: contratosPDF() error:' . $e->getMessage());
    }
 
}