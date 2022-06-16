<?php
include_once('functions.php');
$result="";
$result = isset($_GET['result']) ?  $_GET['result'] : '';
$pass  = isset($_GET['pass']) ?  $_GET['pass'] : '';

?>

<form id="form1" method="post" action="../controlador/functions.php?&gen_pass=1">
<h3>Generar pass</h3>
<table class="table table-bordered" style="width: 50%">
    <tr>
        <td>Password</td>
        <td><input type="text" class="form-control" name="txtPass" id="txtPass" value="<?=$pass?>"> </td>
    </tr>
    <tr>
        <td>Pass encriptado</td>
        <td><?= $result ?></td>
    </tr>
    <tr>
        <td></td>
        <td><button class="btn btn-primary">Generar</button> </td>
    </tr>
</table>
</form>


