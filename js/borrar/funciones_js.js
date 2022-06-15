function notbotonback(){
    if (history.forward(1)) {
        location.replace(history.forward(1));
    }
}

function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}

$(function(){
    $(".showpassword").each(function(index,input) {
        var $input = $(input);
        $("<p class='opt'/>").append(
            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
                var change = $(this).is(":checked") ? "text" : "password";
                var rep = $("<input placeholder='Password' type='" + change + "' />")
                    .attr("id", $input.attr("id"))
                    .attr("name", $input.attr("name"))
                    .attr('class', $input.attr('class'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;
            })
        ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());
    });

    $('#showPassword').click(function(){
        if($("#showPassword").is(":checked")) {
            $('.icon-lock').addClass(' icon-lock-open-1');
            $('.icon-unlock').removeClass('icon-lock');
        } else {
            $('.icon-unlock').addClass('icon-lock');
            $('.icon-lock').removeClass(' icon-lock-open-1');
        }
    });
});

function activarLogin(){

    var pass1 = $("#usserpass").val();
    var pass2 = $("#usserconfirmpass").val();
    var usserid = $("#usserid").val();
    var error="";
    var reg=/(?=^.{8,15}$)(?=.*\d)(?=.*\W+)(?![.\n])(?!.*[,'"])(?=.*[A-Z])(?=.*[a-z]).*$/;

    if( usserid == "" ) {

        error += "El campo id User no debe estar vació.<br/>";

    }
    if( usserid != "" && usserid.length < 6){
        error += "El campo id User no es valido, ingresa un id User valido.<br/>";
    }
    if( pass1 == "" ) {

        error += "El campo Password no debe estar vació.<br/>";

    }else{

        if(!pass1.match(reg)){
            error += "Contraseña no VALIDA, Ingrese una contraseña con las características solicitadas.<br/>";
        }

    }
    if( pass2 == "" ){

        error += "El campo Confirmar Password no debe estar vació.<br/>";

    }else{

        if(!pass2.match(reg)){

            error += "Confirmación de Contraseña no VALIDA, Ingrese una contraseña con las características solicitadas.<br/>";

        }

    }

    if( pass1 != "" && pass2 != "" ){

        if(pass1 != pass2){

            error += "El Password y la Confirmación deben de ser iguales.<br>";

        }
    }



    if ( error != "" ){

        muestramensaje('error','Oops...',error);

    }else{

        $("#activeuser").attr('action','valida_login.php').submit();

    }
}

function buscarSepomex(){

    var cp =  $("#bxcp").val();
    var col = $("#bxcolonia").val();
    var mun = $("#bxmunicipio").val();
    var tipoBusqueda = '';
    var mensaje = '';

    if(cp == '' && col == '' && mun == ''){

        muestramensaje('error','Oops...','Para realizar la busqueda ingresa un valor, en cualquiera de los campos.');
        mensaje = 1;

    }else if(cp != '' && col != '' && mun!= ''){

        muestramensaje('error','Oops...','La busqueda debe de ser solo por uno de los campos.');
        mensaje = 1;

    }else if(cp != '' && col != ''){

        muestramensaje('error','Oops...','La busqueda debe de ser solo por uno de los campos.');
        mensaje = 1;

    }else if(cp != '' && mun != ''){

        muestramensaje('error','Oops...','La busqueda debe de ser solo por uno de los campos.');
        mensaje = 1;

    }else if(mun != '' && col != ''){

        muestramensaje('error','Oops...','La busqueda debe de ser solo por uno de los campos.');
        mensaje = 1;

    }

    if(cp != '' && cp.length != 5){

        muestramensaje('error','Oops...','Para realizar la busqueda por codigo postal es necesarios introducir 5 digitos.');
        mensaje = 1;

    }
    if(mensaje == ''){

        $.ajax({
            data:{
                accion:'obtienedatosPostales',
                cp:cp,
                col:col,
                mun:mun,
            },
            type: "POST",
            dataType: "html",
            url: "controller/ajax-filtros_controller.php",
            success: function(data) {
                $("#resultbcp").html(data);
            }
        });

    }


}


function  muestramensaje(tipo,title,mensaje){
    Swal.fire({
        icon: tipo,
        title: title,
        html: mensaje,
    });
}

function load(page,idsession){

    $.ajax({
        data:{
            accion:'loadimageslider',
            page:page,
            idsession:idsession,
        },
        type: "POST",
        dataType: "html",
        url: "controller/ajax-filtros_controller.php",
        beforeSend: function(objeto){
            $("#loader").html("<img src='img/ajax-loader.gif'>");
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $("#loader").html("");
        }
    });

}

function eliminar_slide(id){
    page=1;
    Swal.fire({
        title: 'Estas seguro?',
        text: "Recuerda que si eliminas la imagen ya no podras recupararla!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si Borrar!'
    }).then((result) => {

        if (result.value) {
            var idsessionslide = $("#idsessionconfigslide").val();
            $.ajax({
                data: {
                    accion: 'deleteimageslide',
                    page: page,
                    id: id,
                    idsessionslide:idsessionslide,
                },
                type: "POST",
                dataType: "html",
                url: "controller/ajax-filtros_controller.php",
                beforeSend: function (objeto) {
                    $("#loader").html("<img src='img/ajax-loader.gif'>");
                },
                success: function (data) {

                    if( data == 'false' || data == '' ){
                        window.location = "../newmega/index.php?msg=21";
                    }

                    $(".mensaje").html(data);
                    window.setTimeout(function() {
                        $(".alert-disable").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                        });	}, 2000);
                    load(1,idsessionslide);
                }
            });

        }

    });
}

function upload_image(tipe){
    $(".upload-msg").text('Cargando...');
    var valor = '';
    if(tipe == 1){

        valor = "fileToUpload2";

    }else{

        valor = "fileToUpload";

    }
    var inputFileImage = document.getElementById(valor);
    var file = inputFileImage.files[0];
    var idimagen = '';
    var data = new FormData();
    var idsession = $("#idsessionconfigslide").val();
    var edicion = $(".edicion").val();
    if(edicion == 1 ){

        idimagen = $("#idimagen").val();

    }
    data.append('fileToUpload',file);
    data.append('accion','loadImgMiniature');
    data.append('idsession',idsession);
    data.append('idimagen',idimagen);

    $.ajax({
        url: "controller/ajax-filtros_controller.php",
        type: "POST",             // Type of request to be send, called as method
        data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
            var obj = JSON.parse(data);

            if( obj.errores != undefined ){
                    $(".upload-msg").html('<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: center">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong>Error!</strong>'
                        + obj.errores +
                    '</div>');
                $(".img-rounded").attr('src','img/img_slide/demo.png');
                $("#containerid").remove();
            }
            if( obj.mensaje != undefined ){
                $(".upload-msg").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong>Aviso!</strong>'
                        + obj.mensaje +
                    '</div>');
                $(".img-rounded").attr('src','img/img_slide/'+obj.nameimagen);
                $(".idimage").html('<div id="containerid"><input type="hidden" name="idimagen" id="idimagen" value="' + obj.id + '"></div>');
            }

            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                    load(1,idsession);
                });	}, 5000);
        }
    });
}

function muestramensajev2(icon,title,timer){
    Swal.fire({
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer:timer
    })
}

//editar desde el boton que llama al pop-up
function editar_slide(id) {
    var idsession = $("#idsessionconfigslide").val();
    $('#editarimagen').modal();

    $.ajax({
        url: "controller/ajax-filtros_controller.php",
        type: "POST",
        dataType: "json",
        data: {
            accion:'getImageforId',
            idsession:idsession,
            idimagen:id,
        },
        success:function(data){
            console.log(data);
            $(".img-rounded").attr('src','img/img_slide/' + data.nombre_imagen);
            $(".estado2").val(data.estado);
            $(".orden2").val(data.orden);
            $(".edicion").val("1");
            $(".idimage").html('<div id="containerid"><input type="hidden" name="idimagen" id="idimagen" value="' + data.id + '"></div>');
        }
    });
}

function guardaEdicion(tipo){

    var idsession = $("#idsessionconfigslide").val();
    var id = $("#idimagen").val();
    var msg = '';
    var estado = $(".estado option:selected").val();
    var orden = $(".orden").val();

    if(tipo == 2){
        estado = $(".estado2 option:selected").val();
        orden = $(".orden2").val();
    }

    if(id == undefined || id == ''){

        msg = 'Error no existe un id valido. vuelve a cargar otra imagen';

    }

    if(msg == ''){

        $.ajax({
            url: "controller/ajax-filtros_controller.php",
            type: "POST",
            data:{
                id:id,
                estado:estado,
                orden:orden,
                idsession:idsession,
                accion:'actualizaDatosImagen',
            },
            beforeSend: function(objeto){
                $("#loader").html("Cargando...");
            },
            success:function(data){
                $(".upload-msg").html('<div class="alert alert-success alert-dismissible" role="alert" style="text-align: center">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong>Aviso!</strong>'
                    + data +
                    '</div>');
            }
        });
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
                load(1,idsession);
            });	}, 5000);
    }else{

        muestramensaje('warning','Error','El id de la imagen esta vacio, favor de cargar otra imagen o modificar la imagen que esta agregada en este listado.')

    }

}