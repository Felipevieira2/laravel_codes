<?php 

   DB::enableQueryLog(); // Enable query log
   $contrato_tipo = ContratoTipo::find(17); //irá exibir a query feita no banco de dados;
   // Your Eloquent query executed by using get()

   dd(DB::getQueryLog()); // Show results of log


?>