<?php
/**
 * Clase para validacion de parametros pasados desde frontend
 */

/**
 * Description of Parameters
 *
 * @author ubuntu
 */
class WsParameters {
    
    const F_TIPO_INMUEBLE = "tipoBien";
    const F_TIPO_TRANSACCION = "tipoTransaccion";
    const F_FILTRO_STR = "filtroStr";
    const F_CANT_HABITACIONES = "cantidadHabitaciones";
    const F_CANT_BANIOS = "cantidadBanios";
    const F_BARRIOS = "barrios";
    const F_PRECIO_DESDE = "precioDesde";
    const F_PRECIO_HASTA = "precioHasta";
    const INICIO = "inicio";
    const CANT_ITEMS = "cantItems";
    
    /**
     * Valida los filtros pasados como parametros al buscar inmuebles por filtros
     * @param jsonFilters $filters
     * @return void
     */
    public static function validatePropertiesFilters($filters){
        $filtros = CJSON::decode($filters);
        if (!array_key_exists(WsParameters::F_TIPO_INMUEBLE, $filtros) 
                || !array_key_exists(WsParameters::F_FILTRO_STR, $filtros)
                || !array_key_exists(WsParameters::F_TIPO_TRANSACCION, $filtros) 
                || !array_key_exists(WsParameters::F_CANT_BANIOS, $filtros)
                || !array_key_exists(WsParameters::F_CANT_HABITACIONES, $filtros)
                || !array_key_exists(WsParameters::F_BARRIOS, $filtros) 
                || !array_key_exists(WsParameters::F_PRECIO_DESDE, $filtros)
                || !array_key_exists(WsParameters::F_PRECIO_HASTA, $filtros)
                || !array_key_exists(WsParameters::INICIO, $filtros)
                || !array_key_exists(WsParameters::CANT_ITEMS, $filtros))
                    throw new Exception("estructura de filtros invalida");
        
        
        if (!is_numeric($filtros[WsParameters::INICIO]) || $filtros[WsParameters::INICIO] < 0)
            throw new Exception("inicio debe ser un entero positivo");
        if (!is_numeric($filtros[WsParameters::CANT_ITEMS]) || $filtros[WsParameters::CANT_ITEMS] < 0)
            throw new Exception("cantItems debe ser un entero positivo");
            
    }
}
