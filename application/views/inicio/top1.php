<?php
//Restricciones de acceso a usuarios no registrados
if ($this->session->userdata('session_id')===FALSE)
    redirect('/');
if ($this->session->userdata('username')=="")
    redirect('/');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>iHelp - iDoctor<?php if ($this->session->userdata('sucursal')!="") {
            echo " - " . $this->session->userdata('sucursal');
        }?></title>

        <!-- Estilos -->
        <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700|Titillium+Web:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/skeleton.css">
        <link rel="stylesheet" href="/css/style1.css" type="text/css">
        <link rel=stylesheet href="/js/datePicker.css" type="text/css">
        <link rel=stylesheet href="/css/cupertino/jquery-ui.css" type="text/css">
        <link rel=stylesheet href="/css/themes/cupertino/jquery.ui.all.css" type="text/css">

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">

        <!-- jQuery -->
        <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>

        <!-- Required plugins -->
        <script type="text/javascript" src="/js/date.js"></script>

        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
        <!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.js"></script><![endif]-->

        <!-- jquery.datePicker.js -->
        <script type="text/javascript" src="/js/jquery.datePicker.js"></script>
        <script type="text/javascript" src="/js/thickbox.js"></script>
        <link rel="stylesheet" href="/js/thickbox.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/dropdown-menu.css" />
        <script type="text/javascript" src="/js/dropdown-menu.min.js"></script>

        <script type="text/javascript" charset="utf-8">
            $(function(){
                $('.date-pick').datePicker({startDate:'1996-01-01',autoFocusNextInput:true});
                $( "input:submit", ".demo" ).button();
                $( "input:button,a", ".demo" ).button();
                $('.dropdown-menu').dropdown_menu();
            });
        </script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="three columns">
                    <a href="/catalogo/index.php/inicio/iniciar"><img border="0" src="/images/idoctor2018.png"></a>
                </div>
                <div class="nine columns" align="center">
                    </br>
                    <h5>Módulo de Catálogos y Administración</h5>
                </div>
            </div>
            <div class="row" style="height:34px"></div>
            <div class="row">
                <ul class="dropdown-menu" id="divmenu">
                    <li><a href="/catalogo/index.php/inicio/iniciar" title="Inicio"><img src="/images/ico_mnu_home1.png"><span class='mnuNav1'>Home</a></a>
                        <ul class="navigation-2">
                            <li><a href="/catalogo/index.php/inicio/terminar" title="Agregar orden">Terminar sesi&oacute;n</a></li>
                        </ul>
                    </li>
                    <li><a href="#" title="Cat&aacute;logos"><img src="/images/ico_mnu_servicios2.png"><span class='mnuNav1'>Catálogos</span></a>
                        <ul class="navigation-2">
                            <li><a href="/catalogo/index.php/registroacciones" title="Acciones">Lista de Acciones</a></li>
                            <li><a href="/catalogo/index.php/clases" title="Equipos">Lista de Equipos</a></li>
                            <li><a href="/catalogo/index.php/tipos" title="Tipos y subtipos">Lista de Modelos</a></li>
                            <li><a href="/catalogo/index.php/clientes" title="Lista de clientes">Lista de Clientes</a></li>
                            <li><a href="/catalogo/index.php/estados" title="Lista de estados">Lista de Estados</a></li>
                            <li><a href="/catalogo/index.php/servicios" title="Lista de precios de servicios">Lista de Precios</a></li>
                            <li><a href="/catalogo/index.php/proveedores" title="Lista de proveedores">Lista de Proveedores</a></li>
                            <li><a href="/catalogo/index.php/subtipos" title="Lista de subtipos">Lista de Subtipos</a></li>
                            <li><a href="/catalogo/index.php/piezas" title="Precios de refacciones (piezas)">Lista de Refacciones</a></li>
                            <li><a href="/catalogo/index.php/articulos" title="Lista de precios de accesorios">Lista de Accesorios</a></li>
                            <li><a href="/catalogo/index.php/paquetes" title="Lista de precios de paquetes">Lista de Paquetes</a></li>
                            <li><a href="/catalogo/index.php/usuarios" title="Usuarios">Lista de Usuarios</a></li>
                        </ul>
                    </li>
                    <li><a href="#" title="Reportes del sistema"><img src="/images/ico_mnu_reportes1.png"><span class='mnuNav1'>Reportes</span></a>
                        <ul>
                            <li><a href="#" title="Propias">Propias<b> Equipos Recibidos</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiapropias" title="Equipos Recibidos Dia Suc Propias">Recibidos <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiapropiasresumen" title="Equipos Recibidos Dia Suc Propias">Recibidos<b> HOY RESUMEN</b> </a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmespropias" title="Equipos Recibidos Dia Suc Propias">Recibidos <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmespropiasprueba" title="Equipos Recibidos Dia Suc Propias">Recibidos <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Propias">Propias <b>Ventas</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiapropias" title="Entradas y salidas por mes">Ventas <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasdiapropiasresumen" title="Entradas y salidas por mes">Ventas <b>HOY RESUMEN</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasmespropias" title="Entradas y salidas por mes">Ventas <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasmespropiasresumen" title="Entradas y salidas por mes">Ventas <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Propias">Propias <b>Accesorios</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosdiapropias" title="Entradas y salidas por mes">Accesorios <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosdiapropiasresumen" title="Entradas y salidas por mes">Accesorios <b>HOY RESUMEN</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosmespropias" title="Entradas y salidas por mes">Accesorios <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosmespropiasresumen" title="Entradas y salidas por mes">Accesorios <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Propias">Propias <b>Reparados</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/equiposreparadospropiasat" title="Reparaciones de área técnica">Área Técnica</a></li>
                                    <li><a href="/catalogo/index.php/reportes/equiposreparadospropiasac" title="Reparaciones de área comercial">Area Comercial</a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Propias">Propias <b>Comunicados</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/comunicadospropias" title="Comunicados de área comercial">Área Comercial</a></li>
                                </ul>
                            </li>
                            <li><a href="/catalogo/index.php/reportes/equiposEsperaRefaccionPropias" title="Equipos en Espera de Refaccion">Propias <b>Espera de Refaccion</b></a></li>
                            <li><a href="/catalogo/index.php/reportes/equiposLaboratorioPropias" title="Equipos En Laboratorio">Propias <b>En Laboratorio</b></a></li>
                            <li><a href="/catalogo/index.php/reportes/devolucionesPendientesPropias" title="Devoluciones Pendientes">Propias <b>Devoluciones Pendientes</b></a></li>
                            <li><a href="#" title="Franquicias">Franquicias<b> Equipos Recibidos</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiafranquicias" title="Equipos Recibidos Dia Franquicias">Recibidos <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiafranquiciasresumen" title="Equipos Recibidos Dia Franquicias">Recibidos<b> HOY RESUMEN</b> </a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmesfranquicias" title="Equipos Recibidos Dia Franquicias">Recibidos <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmesfranquiciasprueba" title="Equipos Recibidos Dia Franquicias">Recibidos <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Franquicias">Franquicias <b>Ventas</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiafranquicias" title="Entradas y salidas por mes">Ventas <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasdiafranquiciasresumen" title="Entradas y salidas por mes">Ventas <b>HOY RESUMEN</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasmesfranquicias" title="Entradas y salidas por mes">Ventas <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/ventasmesfranquiciasresumen" title="Entradas y salidas por mes">Ventas <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Franquicias">Franquicias <b>Accesorios</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosdiafranquicias" title="Entradas y salidas por mes">Accesorios <b>HOY DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosdiafranquiciasresumen" title="Entradas y salidas por mes">Accesorios <b>HOY RESUMEN</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosmesfranquicias" title="Entradas y salidas por mes">Accesorios <b>MES DETALLE</b></a></li>
                                    <li><a href="/catalogo/index.php/reportes/accesoriosmesfranquiciasresumen" title="Entradas y salidas por mes">Accesorios <b>MES RESUMEN</b></a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Franquicias">Franquicias <b>Reparados</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/equiposreparadosfranquiciasat" title="Reparaciones de área técnica">Área Técnica</a></li>
                                    <li><a href="/catalogo/index.php/reportes/equiposreparadosfranquiciasac" title="Reparaciones de área comercial">Area Comercial</a></li>
                                </ul>
                            </li>
                            <li><a href="#" title="Franquicias">Franquicias <b>Comunicados</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/comunicadosfranquicias" title="Comunicados de área comercial">Área Comercial</a></li>
                                </ul>
                            </li>
                            <li><a href="/catalogo/index.php/reportes/equiposEsperaRefaccionFranquicias" title="Equipos en Espera de Refaccion">Franquicias <b>Espera de Refaccion</b></a></li>
							<li><a href="/catalogo/index.php/reportes/equiposLaboratorioFranquicias" title="Equipos En Laboratorio">Franquicias <b>En Laboratorio</b></a></li>
							<li><a href="/catalogo/index.php/reportes/devolucionesPendientesFranquicias" title="Devoluciones Pendientes">Franquicias <b>Devoluciones Pendientes</b></a></li>
                            <li><a href="#" title="Culiacán"><b>Culiacán</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiaculiacan" title="Equipos Dia Suc Gestionadas">Hoy Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosdiaculiacanprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiaculiacan" title="Equipos Hoy Suc Gestionadas">Hoy Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/equiposdiaculiacanprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmesculiacan" title="Entradas y salidas por mes">Mes Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosmesculiacanprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/cierredemesculiacan" title="Entradas y salidas por mes">Mes Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/cierredemesculiacanprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#" title="Poza Rica"><b>Poza Rica</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiapozarica" title="Equipos Dia Suc Gestionadas">Hoy Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosdiapozaricaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiapozarica" title="Equipos Hoy Suc Gestionadas">Hoy Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/equiposdiapozaricaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmespozarica" title="Entradas y salidas por mes">Mes Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosmespozaricaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/cierredemespozarica" title="Entradas y salidas por mes">Mes Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/cierredemespozaricaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#" title="Riviera Veracruzana"><b>Riviera V.</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiariviera" title="Equipos Dia Suc Gestionadas">Hoy Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosdiarivieraprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiariviera" title="Equipos Hoy Suc Gestionadas">Hoy Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/equiposdiarivieraprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmesriviera" title="Entradas y salidas por mes">Mes Recibidos</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosmesrivieraprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/cierredemesriviera" title="Entradas y salidas por mes">Mes Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/cierredemesrivieraprueba" title="Equipos Recibidos Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#" title="Propias"><b>Villahermosa</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/recibidosdiavillahermosa" title="Equipos Dia Suc Gestionadas">Equipos Recibidos Hoy</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosdiavillahermosaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/equiposdiavillahermosa" title="Equipos Hoy Suc Gestionadas">Ventas del Día</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/equiposdiavillahermosaprueba" title="Equipos Entregados Dia Suc Propias">Resumen Mes</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/recibidosmesvillahermosa" title="Entradas y salidas por mes">Equipos Recibidos Mes</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/recibidosmesvillahermosaprueba" title="Equipos Entregados Dia Suc Propias">Resumen Mes</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/catalogo/index.php/reportes/cierredemesvillahermosa" title="Entradas y salidas por mes">Mes Entregados</a>
                                        <ul>
                                            <li><a href="/catalogo/index.php/reportes/cierredemesvillahermosaprueba" title="Equipos Entregados Dia Suc Propias">Resumen</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="/catalogo/index.php/reportes/cierredemesvarios" title="Entradas y salidas por mes">Ventas por Sucursal y Fecha</a></li>
                            <li><a href="#" title="Supervisión">Supervisión</b></a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/supervision" title="Supervisión de ordenes generales">Ordenes Generales</a></li>
                                    <li><a href="/catalogo/index.php/reportes/supervisionactivas" title="Supervisión de ordenes activas">Ordenes Activas</a></li>
                                </ul>
                            </li>
                            <!--<li><a href="/catalogo/index.php/reportes/accesoriosVariables" title="Entradas y salidas por mes">Venta Accesorios por Sucursal y Fecha</a></li>-->
							<!-- <li><a href="/catalogo/index.php/reportes/supervision" title="Entradas y salidas por mes">Supervisión Ordenes</a></li> -->
                            <li ><a href="#" title="Remisiones">Otros
                                <ul>
                                    <li><a href="/catalogo/index.php/reportesadministracion/listadoremisiones" title="Reporte de remisiones">Remisiones por fechas</a></li>
                                    <li><a href="/catalogo/index.php/reportesadministracion/entradassalidaspormes" title="Entradas y salidas por mes">Reporte de entradas y salidas por mes</a></li>
                                    <li><a href="/catalogo/index.php/reportes/equiposreparadospordia" title="Equipos recibidos por día">Equipos reparados por día</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" title="Reportes del sistema"><img src="/images/ico_mnu_reportes1.png"><span class='mnuNav1'>Reportes 2</span></a>
                        <ul>
                            <li><a href="/catalogo/index.php/reportes/detallereporte" title="Detalle reporte">Detalle reporte</a></li>
                            <li><a href="/catalogo/index.php/reportes/ordenesentregadasporfecha" title="">Ordenes Entregadas Por Fecha</a></li>
                            <li><a href="/catalogo/index.php/reportes/piezaspendientes" title="">Piezas pendientes</a></li>
                            <li><a href="/catalogo/index.php/reportes/exportarequipos" title="">Exportar equipos</a></li>
                            <li><a href="/catalogo/index.php/reportes/reporteequipospordia" title="Equipos Dia Suc Gestionadas">Reporte de equipos por día</a></li>
                            <li><a href="/catalogo/index.php/reportes/equipospordia" title="Equipos Hoy Suc Gestionadas">Equipos por día</a>
                                <ul>
                                    <li><a href="/catalogo/index.php/reportes/equipospordiaprueba" title="Equipos Hoy Suc Gestionadas">Equipos por día prueba</a></li>
                                </ul>
                            </li>
                            <!--<li><a href="/catalogo/index.php/reportes/equipospordia" title="Equipos Hoy Suc Gestionadas">Equipos por día</a></li>-->
                            <li><a href="/catalogo/index.php/reportes/cierredemes" title="Entradas y salidas por mes">Cierre de mes</a></li>
                            <li><a href="/catalogo/index.php/reportes/cierredemesvarios" title="Entradas y salidas por mes">Cierre de mes varios</a></li>
                            <li><a href="/catalogo/index.php/reportes/recibidosdiapozarica" title="Equipos Dia Suc Gestionadas">Exportar cierre de mes</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="row" style="height:34px"></div>