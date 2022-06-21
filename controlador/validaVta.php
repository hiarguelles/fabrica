<?php
session_start();
require_once('funcionesGenerales.php');
require_once('../modelo/conexion.php');
require_once('../modelo/classData.php');
require_once('header.php');

$class= new classData();
$datos= $class->GetDataEval($_GET['id']);
$nombre= count($datos)>0 ? $datos[0]['nombre'] : '';
$fecha= count($datos)>0 ? $datos[0]['fecha'] : '';
$socio= count($datos)>0 ? $datos[0]['socio'] : '';
$caso= count($datos)>0 ? $datos[0]['caso'] : '';
$solicitud= count($datos)>0 ? $datos[0]['solicitud'] : '';
$status= count($datos)>0 ? $datos[0]['status'] : '';
$hit= count($datos)>0 ? $datos[0]['hit'] : '';

$perfil= count($datos)>0 ? $datos[0]['perfil'] : '';
$motivo= count($datos)>0 ? $datos[0]['motivo'] : '';
$rec1= count($datos)>0 ? $datos[0]['rec1'] : '';
$mensaje= count($datos)>0 ? $datos[0]['mensaje_tienda'] : '';
$rec2= count($datos)>0 ? $datos[0]['rec2'] : '';

$identifica= count($datos)>0 ? $datos[0]['identificacion'] : '';
$talon= count($datos)>0 ? $datos[0]['talon'] : '';
$foto= count($datos)>0 ? $datos[0]['foto_th_id'] : '';
$contrato= count($datos)>0 ? $datos[0]['contrato'] : '';
$aviso= count($datos)>0 ? $datos[0]['aviso_privacidad'] : '';
$firmas= count($datos)>0 ? $datos[0]['firmas'] : '';
$observa= count($datos)>0 ? $datos[0]['observaciones'] : '';

?>
    <form id="formSave" action="saveData.php" method="post">
        <input type="hidden" id="hddID" name="hddID" value="<?=$_GET['id'] ?>">
    <div class="container">
        <h2>CLIENTE: <?=$nombre?></h2>
        <div class="panel panel-default">
            <div class="panel" style="background-color: #3dd5f3"><strong>INFORMACIÓN</strong></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover table-condensed_1" >
                    <tr style=" semi-condensed;font-weight:bold">
                        <td><div style="text-align: center">FECHA</div></td>
                        <td><div style="text-align: center">SOCIO</div></td>
                        <td><div style="text-align: center">CASO</div></td>
                        <td><div style="text-align: center">SOLICITUD</div></td>
                        <td><div style="text-align: center">ESTATUS</div></td>
                        <td><div style="text-align: center">HIT</div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: center"><?=$fecha ?></div></td>
                        <td><div style="text-align: center"><?=$socio ?></div></td>
                        <td><div style="text-align: center"><?=$caso ?></div></td>
                        <td><div style="text-align: center"><?=$solicitud ?></div></td>
                        <td><div style="text-align: center"><?=$status ?></div></td>
                        <td><div style="text-align: center"><?=$hit ?></div></td>

                    </tr>
                </table>
            </div>
        </div>
    <!-- END INFORMACION -->

             <div class="panel panel-default">
            <div class="panel" style="background-color:#20c997"><strong>RECUPERACIÓN</strong></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover table-condensed_1" >
                    <tr style="font-stretch: semi-condensed;font-weight:bold">
                        <td><div style="text-align: center">PERFIL</div></td>
                        <td><div style="text-align: center">MOTIVO</div></td>
                        <td><div style="text-align: center">REC1</div></td>
                        <td><div style="text-align: center">MENSAJE TIENDA</div></td>
                        <td><div style="text-align: center">REC2</div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: center"><?=$perfil ?></div></td>
                        <td><div style="text-align: center"><?=$motivo ?></div></td>
                        <td><div style="text-align: center"><?=$rec1 ?></div></td>
                        <td><div style="text-align: center"><?=$mensaje ?></div></td>
                        <td><div style="text-align: center"><?=$rec2 ?></div></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- END RECUPERACION -->

        <div class="panel panel-default">
            <div class="panel" style="background-color:#dad55e"><strong>DOCUMENTACIÓN</strong></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover table-condensed_1" >
                    <tr style="font-stretch: semi-condensed;font-weight:bold">
                        <td><div style="text-align: center">IDENTIFICACIÓN</div></td>
                        <td><div style="text-align: center">TALÓN</div></td>
                        <td><div style="text-align: center">FOTO-TH-ID</div></td>
                        <td><div style="text-align: center">CONTRATO</div></td>
                        <td><div style="text-align: center">AVISO PRIV</div></td>
                        <td><div style="text-align: center">FIRMAS</div></td>
                        <td><div style="text-align: center">OBSERVACIONES</div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: center"><?=$identifica ?></div></td>
                        <td><div style="text-align: center"><?=$talon ?></div></td>
                        <td><div style="text-align: center"><?=$foto ?></div></td>
                        <td><div style="text-align: center"><?=$contrato ?></div></td>
                        <td><div style="text-align: center"><?=$aviso ?></div></td>
                        <td><div style="text-align: center"><?=$firmas ?></div></td>
                        <td><div style="text-align: center"><?=$observa ?></div></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- END DOCUMENTACION -->

        <h2>EVALUACION VENTA:</h2>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover table-condensed_1" style="width:50%" >
                    <tr style="font-stretch: semi-condensed;font-weight:bold">
                        <td><div style="text-align: center">DOCUMENTO</div></td>
                        <td><div style="text-align: center">EVALUACIÓN</div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Identificación</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkIden"  name="checkIden"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Talón</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkTalon" name="checkTalon"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Foto-TH-ID</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkFoto" name="checkFoto"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Contrato</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkCon" name="checkCon"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Aviso privacidad</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkPriv" name="checkPriv"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Firmas</div></td>
                        <td><div style="text-align: center"><INPUT type="checkbox" id="checkFirma" name="checkFirma"></div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Observaciones</div></td>
                        <td><div style="text-align: left">
                                <textarea placeholder="Escriba sus observaciones" rows="6" class="form-control" required="required" id="txtComenta" name="txtComenta"></textarea>
                            </div></td>
                    </tr>
                    <tr>
                        <td><div style="text-align: left">Finalizar</div></td>
                        <td><div style="text-align:right">
                                <button type="button" class="btn btn-primary" onclick="return confirma()">Grabar Evaluación</button>
                            </div></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- END EVALUACION  -->
    </div>
<!-- END DIV CONTAINER-->
    </form>
<script type="text/javascript">
    function confirma(){
        sComenta=$("#txtComenta").val();
        if(sComenta.trim()==''){
            $("#txtComenta").focus();
            return false;
        }
        if(window.confirm('Se grabará la evaluación')){
            $("#formSave").submit();
        }
    }
</script>

<?php require_once('footer.php');