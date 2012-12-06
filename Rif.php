<?php
/**
 * Rutina para la obtención de datos fiscales desde el portal del seniat
 * 
 * Creado:
 * Inicialmente la rutina fue creada con el paradigma de la programación estructurada.
 * @author Ronald E Aybar Duno <read424@gmail.com>
 * @since 31/05/2012
 * @link http://goo.gl/kj46r Grupo Google Canaima Universitario
 * 
 * Modificado:
 * Se realizaron los cambios correspondientes para llevar el script al paradigma de la POO.
 * @author José Ayrám <ayramj@gmail.com>
 * @category Libs
 * @since 06/12/2012
 * @version 1.0
 * @todo Agregar rutina de dígito verificador
 * 
 */
class Rif {
    /**
     *[code_result] =  -1: No hay soporte a curl
     *                  0: No hay conexion a internet
     *                  1: Consulta satisfactoria
     *      Otherwise:
     *                450:formato de rif invalido
     *                452:rif no existe
     *
     * [seniat]      =  nombre: [CADENA CON EL NOMBRE]
     *                  agenteretensioniva: [SI|NO]
     *                  contribuyenteiva: [SI|NO]
     *                  tasa: [VACIO|ENTERO MONTO TASA]
     * @var Array
     */
    private $_responseJson = array(
        'code_result' => '', 
		'seniat' => array()
    );  
    /**
     * 
     * @var String
     */
    private $_url = 'http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=';
    /**
     *
     * @var String
     */
    private $_rif;
    /**
     * 
     * @param String $rif
     */
    public function __construct($rif) {
        $this->_rif = $rif;
    }
    /**
     * Obtener la data en formato Json
     * 
     * @param String $rif
     * @return Json
     * @throws Exception
     */
    public function getData() {
        if(function_exists('curl_init')) {
            $this->_url .= $this->_rif;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $result = curl_exec ($ch);
            
            if ($result) {
                try {
                    if(substr($result,0,1)!= '<' ) {
						throw new Exception($result);
                    }
                    
                    $xml = simplexml_load_string($result);
                    
                    if(!is_bool($xml)) {
                        $elements = $xml->children('rif');
                        $seniat = array();
                        $this->_responseJson['code_result'] = 1;
                        
                        foreach($elements as $key => $node) {
                            $index = strtolower($node->getName());
							$seniat[$index] = (string)$node;
                        }
                        $this->_responseJson['seniat'] = $seniat;
				   }
                } catch(Exception $e) {
                    $exception = explode(' ', $result, 2);
                    $this->_responseJson['code_result'] =(int) $exception[0];
               }
            } else {
                 $this->_responseJson['code_result'] = 0;
            }
        } else {
            $this->_responseJson['code_result'] = -1;
        }
        
        return json_encode($this->_responseJson);
    }
}