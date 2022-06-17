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
    $(document).ready(function(){
        console.log('Inicializa')
    })
    function home(){
        $("#divMain").html("<h1 class=\"mt-4\">Flujo de generación</h1><p></p><img src=\"img/flujo_generacion.png\"/>");
    }
    function bandeja(){
        console.log('bandeja principal');
        var URL="ajax.php?&action=bandeja";
        $("#divMain").html("");
        $.ajax({
            type: "POST",
            dataType: "text",
            url: URL,
            success: function(data) {
                console.log('data='+data)
                $("#divMain").html(data);
            },
            error: function(e){
                console.log('Error='+ e);
            }
        });
    }
</script>

<?php include('footer.php') ?>
