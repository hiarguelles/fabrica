<?php
session_start();

if(isset($_SESSION['id_user'])){
    header("Location: fabrica_main.php");
}
include('header_f.php');
if(isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg'] == '1'){
    }
	?>
        <div class="container">
			<section class="main">
				<form class="form-1" method="post" action="validate.php" autocomplete="off">
					<h2 style=""><span class="log-in" style="color:#0000ff">Inicio de sesi&oacute;n</span></h2>
					<p></p>
					<p class="float">
						<label for="Usuario"><i class="icon-user"></i>&nbsp;Usuario</label>
						<input type="text" name="txtUser" placeholder="user" maxlength="15" minlength="5" tabindex="1" class="form-control" required="required">
					</p>
					<p class="float">
						<label for="password"><i class="icon-lock"></i>&nbsp;Contraseña</label>
						<input type="password" name="txtPass" placeholder="Pass" class="showpassword" tabindex="2"  class="form-control" required="required">
					</p>
					<p class="clearfix"> 
						<div align="center">
						<input type="submit" class="btn-primary showConfirmButton" name="submitLog" value="Ingresar">
</div>
					</p>
				</form>​​
			</section>
        </div>
<?php require_once 'controlador/footer.php'; ?>
