$(document).ready(function(){
    bandeja('');
});

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