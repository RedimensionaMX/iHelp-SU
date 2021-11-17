<?php
class Comunicacionesmodel extends CI_Model {
        function Formmodel() {
	        // load the parent constructor
                parent::Model();
	}

	function get_comunicaciones($equipo_id) {
                $sqc  = "SELECT comunicaciones.id,comunicaciones.fecha,comunicaciones.usuario_id,comunicaciones.asunto,";
                $sqc .= "comunicaciones.notas,usuarios.usuario ";
                $sqc .= "FROM comunicaciones INNER JOIN usuarios ON (comunicaciones.usuario_id = usuarios.id) " .
                        " where equipo_id=" . $equipo_id . " order by comunicaciones.fecha,comunicaciones.id";
                $arrc = $this->db->query($sqc);
                $comunicaciones = $arrc->result_array();
                return $comunicaciones;
        }

        function get_comunicados_sucursales($usuario,$sucursales,$usuarios){
                $resultado = [];
                if($usuario == ""){
                        for ($i=0; $i < sizeof($usuarios); $i++) {
                                $arr = ( $this->db->query("select c.fecha,c.hora,c.asunto,c.notas, c.equipo_id, u.usuario, e.num_orden FROM comunicaciones c INNER JOIN usuarios u ON (c.usuario_id = u.id) inner join equipos e on (c.equipo_id = e.id) where c.fecha >= '01/01/2020' and u.usuario = '".$usuarios[$i]."' order by c.fecha,c.id") );
                                $guard = $arr->result_array();
                                $resultado = array_merge($resultado, $guard);
                        }
                }else{
                        $arr = ( $this->db->query("select c.fecha,c.hora,c.asunto,c.notas, c.equipo_id, u.usuario, e.num_orden FROM comunicaciones c INNER JOIN usuarios u ON (c.usuario_id = u.id) inner join equipos e on (c.equipo_id = e.id) where c.fecha >= '01/01/2020' and u.usuario = '".$usuario."' order by c.fecha,c.id") );
                                $guard = $arr->result_array();
                                $resultado = array_merge($resultado, $guard);
                }
                return $resultado;
        }

        function get_comunicados_sucursales_mes($usuario,$sucursales,$usuarios){
                $resultado = [];
                $anio = date("Y");
                $mes =  date("m");
                if($usuario == ""){
                        for ($i=0; $i < sizeof($usuarios); $i++) {
                                $arr = ( $this->db->query("select c.fecha,c.hora,c.asunto,c.notas, c.equipo_id, u.usuario, e.num_orden FROM comunicaciones c INNER JOIN usuarios u ON (c.usuario_id = u.id) inner join equipos e on (c.equipo_id = e.id) where Extract(Month From c.fecha) = " . $mes . " and Extract(Year From c.fecha) = " . $anio . " and u.usuario = '".$usuarios[$i]."' order by c.fecha,c.id") );
                                $guard = $arr->result_array();
                                $resultado = array_merge($resultado, $guard);
                        }
                }else{
                        $arr = ( $this->db->query("select c.fecha,c.hora,c.asunto,c.notas, c.equipo_id, u.usuario, e.num_orden FROM comunicaciones c INNER JOIN usuarios u ON (c.usuario_id = u.id) inner join equipos e on (c.equipo_id = e.id) where Extract(Month From c.fecha) = " . $mes . " and Extract(Year From c.fecha) = " . $anio . " and u.usuario = '".$usuario."' order by c.fecha,c.id") );
                                $guard = $arr->result_array();
                                $resultado = array_merge($resultado, $guard);
                }
                return $resultado;
        }
}
?>