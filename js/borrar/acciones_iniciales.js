$(document).ready(function(){
    $('#usserid').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $("#buscarcp").click(function(){
        buscarSepomex();
    });
    
    $("#bxcp").focus(function () {
        $("#bxcolonia").val('');
        $("#bxmunicipio").val('');
    });
    $("#bxcolonia").focus(function () {
        $("#bxcp").val('');
        $("#bxmunicipio").val('');
    });
    $("#bxmunicipio").focus(function () {
        $("#bxcp").val('');
        $("#bxcolonia").val('');
    });

    $('#bxcp').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('#bxcolonia').on('input', function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g,'');
    });

    $('#bxmunicipio').on('input', function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g,'');
    });

    load(1,$("#idsessionconfigslide").val());

    $("#searchregistervalidation").click(function () {

        $("body").removeClass('modal-open');
        $("#typesearchvalidation").modal('hide');
        $(".modal-backdrop").remove();

    });

    $("#seelistusersvalidation").click(function () {

        $("body").removeClass('modal-open');
        $("#typesearchvalidation").modal('hide');
        $(".modal-backdrop").remove();

    });

    $("#rangerRun").click(function () {

        $("body").removeClass('modal-open');
        $("#typeselectionRanger").modal('hide');
        $(".modal-backdrop").remove();

    });

    $("#rangerRan").click(function () {

        $("body").removeClass('modal-open');
        $("#typeselectionRanger").modal('hide');
        $(".modal-backdrop").remove();

    });

    $("#addimagennew").click(function () {
        $(".img-rounded").attr('src','img/img_slide/demo.png');
        $("#containerid").remove();
        $(".orden").val(1);
        $('.estado').val(1);
        $(".orden2").val(1);
        $('.estado2').val(1);
        $(".edicion").val("0");
        $("#idimagen").val('');
    });

});