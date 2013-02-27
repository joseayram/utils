<?php

require_once 'Rif.php';

// Crear la instancia y pasar como parámetro el RIF a verificar
$rif = new Rif('V153895500');

// Obtener los datos fiscales
$datosFiscales = json_decode( $rif->getInfo() );

var_dump($datosFiscales);

// Validar sin conectar al portal del seniat
if ( $rif->validar() ) {
    echo 'EL RIF EXISTE';
}elseif (!$rif->validar) {
    echo 'EL RIF NO EXISTE';
}