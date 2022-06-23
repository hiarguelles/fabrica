<?php
session_start();
include('header_f.PHP');
if(!isset($_SESSION['id_user'])){
    header('location:index.php');
    die();
}
?>

        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Fábrica de Crédito</div>
                <div class="list-group list-group-flush">
                    <?php
                    switch( $_SESSION['menu']){
                        case "agente":
                            ?>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:home()">Inicio</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:bandeja('')">Bandeja</a>
                            <?php
                            break;
                        case "administrador":
                            ?>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:home()">Inicio</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:bandeja('')">Bandeja</a>
                            <?php
                            break;
                        default:
                            ?><a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Menu!</a><?php
                            break;
                    }
                    ?>

                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
 
                        <button class="btn btn-default" id="sidebarToggle">
                            <img src="img/bradescar.png" />
                        </button>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!"><?=$_SESSION['nombre']?>&nbsp;|</a></li>
                                <li class="nav-item active"><a class="nav-link" href="#!"><?=$_SESSION['puesto']?>&nbsp;|</a></li>

                                <li class="nav-item active"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>

                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <p></p>
                <p></p>
                <div class="container-fluid ui-tabs-panel" id="divSearch" name="divSearch">
                    <table class="table table-responsive" style="width:50%">
                        <tr>
                            <td>Búsqueda:</td>
                            <td>
                                <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="Cliente, caso, solicitud">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="javascript:search()">
                                    Buscar
                                </button>
                            </td>
                        </tr>
                    </table>
                    <p></p>
                </div>
                <div class="container-fluid ui-tabs-panel" id="divMain" name="divMain">
                    <h1 class="mt-4">Flujo de generación</h1>
                    <p></p>
                    <img src="img/flujo_generacion.png"/>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function(){
        bandeja('');
    })
    function home(){
        $("#divSearch").attr('display','none')
        $("#divMain").html("<h1 class=\"mt-4\">Flujo de generación</h1><p></p><img src=\"img/flujo_generacion.png\"/>");
    }
    function search(){
        let search_text= $("#txtSearch").val();
        if(search_text.trim()!=''){
            bandeja(search_text)
        }
    }
    function bandeja(search){
        var PARAM='{"id":"-1"}';
        var COLS=10;
        var URL="ajax.php?&action=bandeja&search=" + search;
        console.log(URL);
        var ROWS=0;
        var HTML=''
        $("#divMain").html("loading");
        $.ajax({
            type: "POST",
            url: URL,
            data: PARAM,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                const Datos= JSON.stringify(data);
                json= JSON.parse(Datos);
                    for (var key in json) {
                        var img = ''
                        var caso = (json[key])['caso'];

                        HTML += '<tr style="font-size:10px">';
                        HTML += '<td>' + (json[key])['fila'] + '</td>';
                        HTML += '<td>' + (json[key])['fecha'] + '</td>';
                        HTML += '<td>' + (json[key])['nombre'] + '</td>';
                        HTML += '<td>' + caso  + '</td>';
                        HTML += '<td>' + (json[key])['solicitud'] + '</td>';
                        HTML += '<td>' + (json[key])['status'] + '</td>';
                        HTML += '<td>' + (json[key])['hit'] + '</td>';
                        HTML += '<td>' + (json[key])['perfil'] + '</td>';
                        HTML += '<td>' + (json[key])['motivo'] + '</td>';
                        ROWS++;
                        var Message = 'Tooltip';
                        var PUESTO= '<?=$_SESSION['puesto']?>';
                        var ID_USU= '<?=$_SESSION['id_user']?>';
                        switch ( (json[key])['proceso'] ) {
                            case '':
                                img="<a href=\"javascript:evaluar('"+ PUESTO + "','" + caso  + "','EVALUAR')\">Evaluar</a>"
                                break;
                            default:
                                var array_list=   (json[key])['proceso'].split('|');
                                switch(array_list[0]){
                                    case 'T':
                                    case 'R':
                                        if(array_list[3]==ID_USU) { //VETNTA TOMADA POR EL AGENTE
                                            img="<a href=\"javascript:evaluar('"+ PUESTO + "','" + caso  + "','EVALUAR')\">Venta pendiente</a>"
                                        }
                                            else{
                                            Message = 'Venta en evaluación|' + array_list[1] + '|' + array_list[2];
                                            if(PUESTO=='Administrador'){
                                                console.log('ADMI');
                                                img = "<a href=\"javascript:liberar('"+ PUESTO + "','" + caso  + "','LIBERAR')\">Liberar Venta</a>";
                                            }else {
                                                img = '<div align="center"><a data-toggle="tooltip" title="' + Message + '"><img src="img/in-progress_192.gif" width="24px"></a></div>';
                                            }
                                            break;
                                        }

                                }
                                break;

                        }
                        HTML += '<td><div id="divData_'+ caso +'">' + img + '</div></td>';
                        HTML += '</tr>';
                    }
                    var R= TAbleHEader() + HTML + TAbleFooter(COLS, (ROWS +' resultados'));
                    $("#divMain").html(R);
            },
            error: function(e){
                console.log('Error='+ e);
            }
        });
    }
    function TAbleHEader(){
        var HTML='<table class="table table-bordered table-hover table-striped">';
        HTML+= '<thead>';
        HTML+= '<tr style="background-color:#0a53be;color: #FFFFFF;font-size: 11px">';
        HTML+= '<th><div align="center">NUM</div></th>';
        HTML+= '<th><div align="center">FECHA</div></th>';
        HTML+= '<th><div align="center">CLIENTE</div></th>';
        HTML+= '<th><div align="center">CASO</div></th>';
        HTML+= '<th><div align="center">SOLICITUD</div></th>';
        HTML+= '<th><div align="center">STATUS</div></th>';
        HTML+= '<th><div align="center">HIT</div></th>';
        HTML+= '<th><div align="center">PERFIL</div></th>';
        HTML+= '<th><div align="center">MOTIVO</div></th>';
        HTML+= '<th><div align="center">PROCESO</div></th>';
        HTML+= '</tr>';
        HTML+= '</thead>';
        HTML+= '<tbody>';
        return HTML;
    }
    function TAbleFooter(colSpan, sREsult){
        var HTML= '<tr style="font-size:10px"><td colspan="'+ colSpan +'"><div align="center"><strong>' + sREsult + '</strong></div></td></tr>';
        HTML+= '</tbody>';
        HTML+= '</table>';
        return HTML;
    }
    function liberar(puesto, id, action){
        var URL="controlador/fdc_bloqueo.php?&id="+id+'&action=LIBERAR';
        myWin= window.open(URL);
        myWin.opener=self;
        myWin.focus();
    }
    function evaluar(puesto, id, action){
        var URL="controlador/fdc_bloqueo.php?&id="+id+'&action=BLOQUEA';
        myWin= window.open(URL);
        myWin.opener=self;
        myWin.focus();
    }function retomarVta(id_amex, idusuario){
        var URL="frmTaken.php?&id="+id_amex+'&action=RETURN';
        myWin= window.open(URL);
        myWin.opener=self;
        myWin.focus();
    }
    function setVtaBloqueo(iId, sUser, dFecha){
        var control= '#divData_' + iId;
        var HTML= '<img src="img/in-progress_192.gif" width="24" heigt="24"';
        HTML += ' data-toggle="tooltip" ';
        HTML += ' data-html="true" title="Venta tomada por agente:&nbsp;'+sUser+' => '+dFecha+'"/>';
        $(control).prop('innerHTML', HTML);
    }
    function setVtaEval(iId, sUser, dFecha){
        var control= '#divData_' + iId;
        var HTML= 'Venta evaluada';
        $(control).prop('innerHTML', HTML);
    }
</script>

<?php include('controlador/footer.php') ?>
