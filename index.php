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
                    <table class="table" style="width: 33%;horiz-align: center">
                        <tr>
                            <td colspan="2">
                                <h2 style=""><span class="log-in" style="color:#0000ff">Inicio de sesi&oacute;n</span></h2>
                            </td>
                        </tr>
                        <tr>
                               <td> <label for="Usuario"><i class="icon-user"></i>&nbsp;Usuario</label></td>
                            <td><input type="text" name="txtUser" placeholder="user" maxlength="15" minlength="5" tabindex="1" class="form-control" required="required"></td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password"><i class="icon-lock"></i>&nbsp;Contraseña</label>

                            </td>
                            <td>
                                <input type="password" name="txtPass" placeholder="Pass" class="showpassword" tabindex="2"  class="form-control" required="required">

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>						<input type="submit" class="btn-primary showConfirmButton" name="submitLog" value="Ingresar">
                            </td>
                        </tr>

                    </table>

					<p></p>



				</form>
			</section>
        </div>
<?php require_once 'controlador/footer.php'; ?>
