<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  </head>
  <body>
    <h1>Empleados</h1>
    <div class="container">
      <form class="d-flex" action="" method="post">
        <div class="col">
          <div class="mb-3">
            <label for="lbl_codigo" class="form-label">Código</label>
            <input type="text" name="txt_codigo" id="txt_codigo" class="form-control" placeholder="Código" aria-describedby="helpId" Required>
            <small id="helpId" class="text-muted">Codigo: 001</small>
            
          </div>
          <div class="mb-3">
            <label for="lbl_nombres" class="form-label">Nombres</label>
            <input type="text" name="txt_nombres" id="txt_nombres" class="form-control" placeholder="Nombres" aria-describedby="helpId" Required>
            
          </div>
          <div class="mb-3">
            <label for="lbl_apellidos" class="form-label">Apellidos</label>
            <input type="text" name="txt_apellidos" id="txt_apellidos" class="form-control" placeholder="Apellidos" aria-describedby="helpId" Required>
            
          </div>
          <div class="mb-3">
            <label for="lbl_direccion" class="form-label">Dirección</label>
            <input type="text" name="txt_direccion" id="txt_direccion" class="form-control" placeholder="Dirección" aria-describedby="helpId" Required>
            
          </div>
          <div class="mb-3">
            <label for="lbl_telefono" class="form-label">Teléfono</label>
            <input type="number" name="txt_telefono" id="txt_telefono" class="form-control" placeholder="telefono" aria-describedby="helpId" Required>
            
          </div>

          <div class="mb-3">
            <label for="lbl_fecha_nacimiento" class="form-label">Teléfono</label>
            <input type="date" name="txt_fecha_nacimiento" id="txt_fecha_nacimiento" class="form-control" placeholder="Fecha Nacimiento" aria-describedby="helpId" Required>
            <small id="helpId" class="text-muted">Formato: dd/mm/aaaa</small>
          </div>
          <div class="mb-3">
            <label for="cb_puesto" class="form-label"></label>
            <select class="form-select" name="cb_puesto" id="cb_puesto">
              <?php
                include("Conexion.php");
                $db_conexion = new mysqli($db_host,$db_usr,$db_pass,$db_name);
                $result_query = $db_conexion->query('SELECT id_puesto as id,puesto FROM Puestos');
                //echo $result_query;
                $jobs = $result_query->fetch_object();
                echo "<option value=0> -- Seleccione -- </option>";
                while($jobs != null){
                  echo "<option value=". $jobs->id .">". $jobs->puesto ."</option>";
                  $jobs = $result_query->fetch_object();
                }
                $result_query->free();
                $db_conexion->close();
              ?>
            </select>
          </div>
          <button type="submit" name="btn_enviar" id="btn_enviar" class="btn btn-primary">Enviar</button>
        </div>
      </form>
      <table class="mt-2 table table-dark table-striped table-inverse table-responsive">
        <thead class="thead-default">
          <tr>
            <th>Código</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Dirección</th>
            <th>Telefono</th>
            <th>Fecha Nacimiento</th>
            <th>Puesto</th>
            <th></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <?php
            include("Conexion.php");
            $db_conexion = new mysqli($db_host,$db_usr,$db_pass,$db_name);
            $result_query = $db_conexion->query('SELECT codigo, nombres, apellidos, direccion, telefono, fecha_nacimiento, P.puesto FROM Empleados E JOIN Puestos P ON E.id_puesto=P.id_puesto');
            //echo $result_query;
            $workers = $result_query->fetch_object();
            while($workers != null){
              echo "<tr>";
              echo "<td>". $workers->codigo ."</td>";
              echo "<td>". $workers->nombres ."</td>";
              echo "<td>". $workers->apellidos ."</td>";
              echo "<td>". $workers->direccion ."</td>";
              echo "<td>". $workers->telefono ."</td>";
              echo "<td>". $workers->fecha_nacimiento ."</td>";
              echo "<td>". $workers->puesto ."</td>";
              echo '<td><input name="btn_editar" id="btn_editar_'. $workers->codigo .'" class="btn btn-warning" type="button" value="Editar"></td>';
              echo '<td><input name="btn_eliminar" id="btn_eliminar_'. $workers->codigo .'" class="btn btn-danger" type="button" value="Eliminar"></td>';
              echo "</tr>";
              $workers = $result_query->fetch_object();
            }
            $result_query->free();
            $db_conexion->close();
          ?>
          </tbody>
      </table>
      
    </div>
    <?php
      if(isset($_POST["btn_enviar"])){
        include("Conexion.php");
        $db_conexion = new mysqli($db_host,$db_usr,$db_pass,$db_name);
        $txt_codigo =utf8_decode($_POST["txt_codigo"]);
        $txt_nombres =utf8_decode($_POST["txt_nombres"]);
        $txt_apellidos =utf8_decode($_POST["txt_apellidos"]);
        $txt_direccion =utf8_decode($_POST["txt_direccion"]);
        $txt_telefono =utf8_decode($_POST["txt_telefono"]);
        $cb_puesto =utf8_decode($_POST["cb_puesto"]);
        $txt_fecha_nacimiento =utf8_decode($_POST["txt_fecha_nacimiento"]);
        $sql = "INSERT INTO Empleados(codigo,nombres,apellidos,direccion,telefono,fecha_nacimiento,id_puesto) VALUES(". $txt_codigo .",'". $txt_nombres ."','". $txt_apellidos ."','". $txt_direccion ."','". $txt_telefono ."','". $txt_fecha_nacimiento ."',". $cb_puesto .")";
        if($db_conexion->query($sql)){
          header("Refresh:0");
        }else{
          echo"Error" . $sql ."<br>";
        }
        $db_conexion->close();
      }
    ?>
  </body>
</html>