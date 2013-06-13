﻿# Rutinas de utilidades generales

## 1. Rif.php

Clase que valida el rif indicado contra la información arrojada por el portal del seniat.

<?php
require_once 'Rif.php';

$rif = new Rif('V153895500');
$datosFiscales = json_decode($rif->getInfo());

switch ($datosFiscales->code_result) {
  case 1:
		$texto  = "Razón social: {$datosFiscales->seniat->nombre}\n"
				. "Agente Retención: {$datosFiscales->seniat->agenteretencioniva}\n"
				. "Contribuyente IVA: {$datosFiscales->seniat->contribuyenteiva}\n"
				. "Tasa: {$datosFiscales->seniat->tasa}\n";
		echo $texto;
		break;
}
?>
