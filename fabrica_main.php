<?php
include('header_f.PHP');
session_start();
/*
 * $_SESSION['id_user']=$res[0]['id_usuario'];
        $_SESSION['agente']=$res[0]['usuario'];
        $_SESSION['puesto']=$res[0]['puesto'];
        $_SESSION['menu']=$res[0]['menu'];

 * */
?>
<style>
    .table-hover thead tr:hover th, .table-hover tbody tr:hover td {
        background-color: yellow;
        cursor:pointer;}
    }
    .table-hover thead tr:hover th, .table-hover tbody tr:hover td {
        background-color: yellow;
        cursor:pointer;
    }

    .linkR a:link{
        color:coral;
        text-decoration:initial;
    }
    .linkA a:link{
        color:darkgreen;
        text-decoration:initial;
    }
    .ResizedTExtbox{
        height:30px;
        font-size:14px;
    }
    .table-condensed_1>thead>tr>th,
    .table-condensed_1>tbody>tr>th,
    .table-condensed_1>tfoot>tr>th,
    .table-condensed_1>thead>tr>td,
    .table-condensed_1>tbody>tr>td,
    .table-condensed_1>tfoot>tr>td{
        padding: 0px;
        border-color:white;
    }

</style>


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
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:bandeja()">Bandeja</a>
                            <?php
                            break;
                        case "administrador":
                            ?>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="javascript:home()">Inicio</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Overview</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Events</a>
                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Profile</a>
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
                                <!--<li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                                 <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#!">Action</a>
                                        <a class="dropdown-item" href="#!">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#!">Something else here</a>
                                    </div>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <p></p>
                <p></p>
                <div class="container-fluid ui-tabs-panel" id="divMain" name="divMain">
                    <h1 class="mt-4">Flujo de generación</h1>
                    <p></p>
                    <img src="img/flujo_generacion.png"/>
                </div>
            </div>
        </div>
<script type="text/javascript">
    var PUESTO='';
    $(document).ready(function(){
        console.log('Inicializa')
        PUESTO= '<?=$_SESSION['puesto']?>';
        bandeja();
    })
    function home(){
        $("#divMain").html("<h1 class=\"mt-4\">Flujo de generación</h1><p></p><img src=\"img/flujo_generacion.png\"/>");
    }
    function bandeja(){
        console.log('Inicializa AJAX');
        var PARAM='{"id":"-1"}';
        var COLS=10;
        var URL="ajax.php?&action=bandeja";
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
                        HTML += '<td>' + (json[key])['socio'] + '</td>';
                        HTML += '<td>' + caso  + '</td>';
                        HTML += '<td>' + (json[key])['solicitud'] + '</td>';
                        HTML += '<td>' + (json[key])['status'] + '</td>';
                        HTML += '<td>' + (json[key])['hit'] + '</td>';
                        HTML += '<td>' + (json[key])['perfil'] + '</td>';
                        HTML += '<td>' + (json[key])['motivo'] + '</td>';
                        ROWS++;
                        var Message = 'Tooltip'
                        switch ((json[key])['process']) {
                            case 'BLOCKED':// +24hrs
                                img = '<div align="center"><a data-toggle="tooltip" title="' + Message + '"><img src="img/box-important_192.gif" width="24px"></a></div>';
                                break;
                            case 'EVAL':// EN EVALUACIÓN
                                img = '<div align="center"><a data-toggle="tooltip" title="' + Message + '"><img src="img/in-progress_192.gif" width="24px"></a></div>';
                                break;
                            default:
                                img='<a href="javascript:evaluar(\''+ PUESTO + '\', \'' + caso  + '\',\'EVALUAR\')">Evaluar</a>';
                                break;
                        }
                        HTML += '<td><div id="divData_'+ caso +'">' + img + '</div></td>';
                        HTML += '</tr>';
                    }
                    var R= TAbleHEader() + HTML + TAbleFooter(COLS, (ROWS +' resultados'));
                    //$("#divResult").html(R);
                    $("#divMain").html(R);
                    console.log(HTML);
                //}
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
        HTML+= '<th><div align="center">SOCIO</div></th>';
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

<?php include('footer.php') ?>
