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

function obtenCalificacion() {

    var estatus1 = $("#tiPoContactoOUT").val();

    if (estatus1 != '') {
        $.ajax({
            data: {
                accion: 'tiPoContactoOUT',
                estatus1: estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function (data) {



                $("#Calificacionselect").html(data);
                $("#calificacion").prop('required', true);
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}


function obtenCalificacionIN() {

    var estatus1 = $("#tiPoContactoIN").val();

    if (estatus1 != '') {
        $.ajax({
            data: {
                accion: 'tiPoContactoIN',
                estatus1: estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function (data) {



                $("#CalificacionselectIN").html(data);
                $("#calificacionIN").prop('required', true);
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}


function obtenSubCalificacion() {

    var estatus1 = $("#calificacion").val();

    if (estatus1 != '') {
        $.ajax({
            data: {
                accion: 'subCalificacion',
                estatus1: estatus1,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function (data) {
                $("#subcalificacionselect").html(data);
                $("#subcalificacion").val(23);
                $("#subcalificacion").prop('required', true);
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}

function obtenSubCalificacionIN() {

    var calificacionIN = $("#calificacionIN").val();

    if (calificacionIN != '') {
        $.ajax({
            data: {
                accion: 'subCalificacionIn',
                calificacionIN: calificacionIN,
            },
            type: "POST",
            dataType: "html",
            url: "controlador/ajax-filtrosPDO_controller.php",
            success: function (data) {
                ;
                $("#subcalificacionselectIN").html(data);
                $("#subcalificacionIN").val(8);
                $("#subcalificacionIN").prop('required', true);
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'La Calificación es requerida.',
        });
    }
}

function makeid(length) {
    var result = '';
    var characters = '0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
/*

const  generateRandomString = (num) => {
    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result1= '';
    const charactersLength = characters.length;
    for ( let i = 0; i < num; i++ ) {
        result1 += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result1;*/
