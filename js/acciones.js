
var flag=true;
var conta=1;
var contaIn=0;
$(document).ready(function () {

    $("#actualiza").click(function () {
      if(flag){
        $("#actualizacionDatos").show();
        $("#telefonoNuevoInput").prop('required', true);
        $("#InputEmailNuevo").prop('required', true);
        flag=false;
    }else{
        $("#actualizacionDatos").hide();
        $("#telefonoNuevoInput").prop('required', false);
        $("#InputEmailNuevo").prop('required', false);
        flag=true;
    }
    });

    $("#actualizaIN").click(function () {
      if(flag){
        $("#actualizacionDatosIN").show();
        $("#telefonoNuevoInputIn").prop('required', true);
        $("#InputEmailNuevoIN").prop('required', true);
        flag=false;
    }else{
        $("#actualizacionDatosIN").hide();
        $("#telefonoNuevoInputI").prop('required', false);
        $("#InputEmailNuevoIN").prop('required', false);
        flag=true;
    }
    });

  $("input[name=PromocionRadioOptions]").change(function () {
    if($(this).val()==1){
      $("#divDatosPromocion").show();
     //enviaSMS();
    $("#codigo").html("Codigo: "+makeid(6));
     $("#CodSMSInput").prop('required', true);
    }else{
      $("#divDatosPromocion").hide();
      $("#CodSMSInput").prop('required', false);
    }
  });

  $("input[name=PromocionRadioOptionsIN]").change(function () {
    if($(this).val()==1){
      $("#divDatosPromocionIn").show();
     //enviaSMS();
     $("#codigoIN").html("Codigo: "+makeid(6));
     $("#CodSMSInputIN").prop('required', true);
    }else{
      $("#divDatosPromocionIn").hide();
      $("#CodSMSInputIN").prop('required', false);
    }
  });



$("#tiPoContactoOUT").change(function(){
  obtenCalificacion();
  $("#Calificacion2Div").show();

});


////// Prueba de envio SMS


$("#enviarSMSbtn").click(function () {
  enviaSMS(1,'',$("#telefonoInput").val(),'0');
});

//////



$("#tiPoContactoIN").change(function(){
  obtenCalificacionIN();
  $("#Calificacion2DivIN").show();

});

$('#telefonoNuevoInput').on('input', function () {
  this.value = this.value.replace(/[^0-9]/g,'');
});
$('#telefonoNuevoInputIN').on('input', function () {
  this.value = this.value.replace(/[^0-9]/g,'');
});

$("#Calificacionselect").change(function(){
  var calif = $("#Calificacionselect option:selected").val();
  if(calif==43||calif==44){
    obtenSubCalificacion();
    $("#SubcalifDiv").show();
    //$("#InputEmail").prop('required', true);
  }else{
    $("#SubcalifDiv").hide();
    $("#subcalificacion").val("");
    
    $("#subcalificacion").prop('required', false);
    //$("#InputEmail").prop('required', false);
  }

  if(calif==40||calif==41){
    
    $("#InputEmail").prop('required', true);
  }else{
    
    $("#InputEmail").prop('required', false);
  }

});

$("#CalificacionselectIN").change(function(){
  var calif = $("#CalificacionselectIN option:selected").val();
  if(calif==5){
    obtenSubCalificacionIN();
    $("#SubcalifDivIN").show();
    $("#InputEmailIN").prop('required', true);
  }else{
    $("#SubcalifDivIN").hide();
    $("#subcalificacionIN").val("");
    $("#InputEmailIN").prop('required', false);
  }

});

    var fechaInicio = $("#fechaInicio").val();
    if( fechaInicio != undefined ){


        if( fechaInicio == '' ){

            showdatedatepicker('fechaInicio',dia,mes,year);

        }else{

            dia3 = fechaInicio.substring(0,2);
            mes3 = fechaInicio.substring(3,5);
            year3 = fechaInicio.substring(6,11);
            showdatedatepicker('fechaInicio',dia3,mes3,year3);

        }

    }


        var fechaFin = $("#fechaFin").val();
    if( fechaFin != undefined ){


        if( fechaFin == '' ){

            showdatedatepicker('fechaFin',dia,mes,year);

        }else{

            dia3 = fechaFin.substring(0,2);
            mes3 = fechaFin.substring(3,5);
            year3 = fechaFin.substring(6,11);
            showdatedatepicker('fechaFin',dia3,mes3,year3);

        }

    }
/*

$("#CodSMSInputIN").change(function(){
  if(contaIn!=3){
    if(!($("#CodSMSInputIN").val()==$("#CODEIN").val())){
      alert("El codigo es incorrecto");
      $("#CodSMSInputIN").val("");
      contaIn=contaIn+1;
    }
  }else{
    alert("Numero de intentos superado, no es posible agregar la promocion");
    $("input[name=PromocionRadioOptionsIN][value='2']").prop("checked",true);
      $("#CodSMSInputIN").prop('required', false);
      $("#divDatosPromocionIn").hide();
  }
});
*/

$("#CodSMSInput").change(function(){
  if(conta!=3){
    if(!($("#CodSMSInput").val()==$("#CODE").val())){
      alert("El codigo es incorrecto");
      $("#CodSMSInput").val("");
      conta=conta+1;
    }
  }else{
    
    alert("Numero de intentos superado");
    $("#tiPoContactoOUT").val("1");
    $("#Calificacion2Div").show();
    obtenCalificacion();
    $("#enviarSMSbtn").hide();
    
    setTimeout(bloquaCampos, 400);
      $("#CodSMSInput").prop('required', false);
  }
});

});

function bloquaCampos(){
  $("#calificacion").val("51");
  $("#Calificacionselect").val("51");
}


function showdatedatepicker(campo,dia,mes,year){

    $('#' + campo).datepicker({
        changeMonth:true,
        changeYear: true,
        showOn:"button",
        buttonImage: "img/cal2.png",
        dateFormat: 'dd/mm/yy',
        buttonImageOnly: true,
    }).val();

}

function obtenCalificacion(){

    var estatus1 = $("#tiPoContactoOUT").val();
      
    if(estatus1 != ''){
        $.ajax({
            data:{
                accion:'tiPoContactoOUT',
                estatus1:estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function(data) {



                $("#Calificacionselect").html(data);
                $("#calificacion").prop('required', true);
            }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}

function obtenSubCalificacion(){

    var estatus1 = $("#calificacion").val();

    if(estatus1 != ''){
        $.ajax({
            data:{
                accion:'subCalificacion',
                estatus1:estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function(data) {
                $("#subcalificacionselect").html(data);
                $("#subcalificacion").val(23);
                $("#subcalificacion").prop('required', true);
            }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}

function obtenCalificacionIN(){

    var estatus1 = $("#tiPoContactoIN").val();

    if(estatus1 != ''){
        $.ajax({
            data:{
                accion:'tiPoContactoIN',
                estatus1:estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function(data) {



                $("#CalificacionselectIN").html(data);
                $("#calificacionIN").prop('required', true);
            }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}

function obtenSubCalificacionIN(){

    var calificacionIN = $("#calificacionIN").val();

    if(calificacionIN != ''){
        $.ajax({
            data:{
                accion:'subCalificacionIn',
                calificacionIN:calificacionIN,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function(data) {;
                $("#subcalificacionselectIN").html(data);
                $("#subcalificacionIN").val(8);
                $("#subcalificacionIN").prop('required', true);
            }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}
/*
function enviaSMS() {
  
  var myHeaders = new Headers();
  myHeaders.append("Access-Control-Allow-Headers", "Content-Type");
  myHeaders.append("mode", "no-cors");
  myHeaders.append("Content-Type", "application/json");
  
  var raw = JSON.stringify({
    "U": "i_Cts",
    "P": "Ct2xSl4e",
    "K": "637751617816282",
    "T": "5586782297",
    "M": "Test"
  });
  
  var requestOptions = {
    method: 'POST',
    headers: myHeaders
  };
  
  fetch("https://www.message-center.com.mx/webresources/Engine/SendMsg", requestOptions)
    .then(response => response.text())
    .then(result => console.log(result))
    .catch(error => console.log('error', error));

}

function makeid(length) {
   var result           = '';
   var characters       = '0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}*/


function consultar_ges(){
      msg="";
      if($("#fechaInicio").val()==""){
        msg += "La fecha Inicio es obligatoria. <br>";
      }
      if($("#fechaFin").val()==""){
        msg += "La fecha final es obligatoria. <br>";
      }
      if($("#cboReporte").val()==0){
        msg += "El reporte es obligatorio. <br>";
      }

      if(msg != ""){
        alert(msg);

    return false;

  } else {
    var DEL= $("#fechaInicio").val();
    var AL= $("#fechaFin").val();
    var REP= $("#cboReporte option:selected").val();
    var URL= 'Reportes.php?&report=' + REP + '&fec_ini=' + DEL + '&fec_fin=' + AL;
    window.location=URL;
  }

}
function generaReporte(){
     msg="";
    if($("#fechaInicio").val()==""){
      msg += "La fecha Inicio es obligatoria. <br>";
    }
    if($("#fechaFin").val()==""){
      msg += "La fecha final es obligatoria. <br>";
    }
    if($("#cboReporte").val()==0){
      msg += "El reporte es obligatorio. <br>";
    }

    if(msg != ""){
      alert(msg);

    return false;

    } else {
      javascript:window.open('exportData.php?&fechaInicio='+$("#fechaInicio").val()+'&fechaFin='+$("#fechaFin").val()+'&tipo='+$("#cboReporte").val()+'');
    }
}

function enviaSMS(paso, nombre, numero, prod) {

  $codigo = makeid(6);
  $shortLink = '';
  if (paso == 1) {
    $mensaje = "Autoriza la activación del beneficio exclusivo DESinterésate (MSI) por tan solo $99+ IVA mensual, solo confirma este folio: "+ $codigo + " al ejecutivo." 
  }
  if (prod != '0') {
      if (prod == 'BK_Bodega') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_Bodega.jpg";
      }
      if (prod == 'BK_C&A') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_CYA.jpg";
      }
      if (prod == 'BK_GCC') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_GCC.jpg";
      }
      if (prod == 'BK_PMD') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_Promoda.jpg";
      }
      if (prod == 'BK_Shasa') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_Shasa.jpg";
      }
      if (prod == 'BK_Sub') {
          $shortLink = "https://img.bradescard.apctsolutionsmx.com/210817_Desinteresate_Total.jpg";
      }
  }
  if (paso == 2) {
      $mensaje = nombre + " Bienvenido al programa DESinteresate, ¡ahora podrás disfrutar de 9MSI todo el año! para más información consulta: " + $shortLink;
  }
  // $("#codigo").html($codigo);
  $("#CODE").val($codigo);

  var settings = {
      "url": "https://www.message-center.com.mx/webresources/Engine/SendMsg",
      "method": "POST",
      "timeout": 0,
      "headers": {
          "Content-Type": "application/json"
      },
      "data": JSON.stringify({
          "U": "i_Cts",
          "P": "C&t2xSl4e",
          "K": "637751617816282",
          "T": "" + numero + "",
          "M": "" + $mensaje + ""
      }),
  };

  $("#enviarSMSbtn").fadeOut();
  setTimeout(reenviarBtnShow, 15000);

  $.ajax(settings).done(function (response) {
      console.log(response);
      alert(response.Result);

  });

}

function reenviarBtnShow() {
  $("#enviarSMSbtn").fadeIn();
}





