<!-- Modal Button, El contenido del carro de la compra, tiene un formulario que llama al script payment.php. -->
<button id="car" type="button" class="btn btn-primary" style="visibility: hidden;" data-bs-toggle="modal" data-bs-target="#carDialog">Diálogo</button>

<!-- Modal -->
<div class="modal fade" id="carDialog" tabindex="-1" aria-labelledby="carDialogLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
  <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="carDialogLabel">Carro de la Compra</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">_</button>
      </div>
      <div class="modal-body">
          <p>Este es el contenido de tu carro:</p>
          <form action="pagar.php" method="post">
          <?php
            for ($i = 0; $i < count($_SESSION["articulo"]); $i++)
            {
                if ($_SESSION["articulo"][$i] != "")
                {
                    echo ' Cantidad: <label><input type="number" name="qtty' . $i . '" value="' . $_SESSION["qtty"][$i] . '" min=".25" max="15" step=".25"> Has Pedido: ' . $_SESSION["qtty"][$i] . ' Kg.</label>';
                    echo '<label><input type="hidden" name="articulo' . $i . '" value="' . $_SESSION["articulo"][$i] . '"> de ' . $_SESSION["articulo"][$i] . '</label>';
                    echo '<input type="hidden" name="price' . $i . '" value="' . $_SESSION["precio"][$i] . '">';
                    echo "<br><br>";
                }
            }
          ?>
          <input type="submit" class="btn btn-info" value="Quiero estos Artículos">
          </form>
      </div>
      <div class="modal-footer">
      <button type="button" id="close_car_dialog" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
  </div>
  </div>
</div>