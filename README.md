# Rutinas de utilidades generales

## Requerimientos

- PHP 5.0 o superior
- [Librería CURL](http://php.net/manual/es/intro.curl.php)

## Archivos

### 1. Rif.php

Clase que valida el rif indicado contra la información arrojada por el portal del seniat.

### 2. Ejemplo.php:

 ``` php
<?php
require_once 'Rif.php';

$rif = new Rif('G200003030');
$datosFiscales = json_decode($rif->getInfo());

switch ($datosFiscales->code_result) {
  case 1:
    $texto  = "Razón social: {$datosFiscales->seniat->nombre}<br />"
            . "Agente Retención: {$datosFiscales->seniat->agenteretencioniva}<br />"
            . "Contribuyente IVA: {$datosFiscales->seniat->contribuyenteiva}<br />"
            . "Tasa: {$datosFiscales->seniat->tasa}<br />";
    break;

  default:
    $texto = $datosFiscales->message;
  break;
}

echo utf8_decode($texto);
 ```
