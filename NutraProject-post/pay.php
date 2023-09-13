<?php
include "includes/conn.php";
$title = "Pedido Final - Antes de Pagar";
include "includes/header.php";
$j = 0; // Es el índice de los array de los productos, precios y cantidades.
$total = 0; // Hay que declarar y asignarle un valor a $total para poder hacer un += después.

for ($i = 0; $i < count($_SESSION["car"]); $i+=5) // Bucle para obtener en cada array lo que el cliente agrego al carro en el array de sesión $_SESSION["car"] incremento $i de 3 en 3.
{
    $id[$j] = $_SESSION["car"][$i];
    $qtty[$j] = $_SESSION["car"][$i + 1]; // Pongo el primer índice en el array $qtty.
    $product[$j] = $_SESSION["car"][$i + 3]; // Pongo el segundo índice en el array $product.
    $price[$j] = $_SESSION["car"][$i + 4]; // Pongo el tercer índice en el array $price.
    $j++; // Incremento $j en 1.
}
?>
<style>
    body{background: #f5f5f5}.rounded{border-radius: 1rem}.nav-pills .nav-link{color: #555}.nav-pills .nav-link.active{color: white}input[type="radio"]{margin-right: 5px}.bold{font-weight:bold}
</style>
<div class="container">
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div id="view1">
            <div class="col-12 mt-4">
                <div class="card p-3">
                    <p class="mb-0 fw-bold h4">Métodos de Pago</p>
                </div>
            </div>
            <div class="col-12">
                <div class="card p-3">
                    <div class="card-body border p-0">
                        <p>
                            <a class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-between"
                                data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true"
                                aria-controls="collapseExample">
                                <span class="fw-bold">PayPal y Tatjetas</span>
                                <span class="fab fa-cc-paypal">
                                </span>
                            </a>
                        </p>
                        <div class="collapse show p-3 pt-0" id="collapseExample">
                            <div class="row">
                                <div class="col-8">
                                    <p class="h4 mb-0">Detalle</p>
                                    <?php
                                    for ($i = 0; $i < count($qtty); $i++)
                                    {
                                        echo '<p class="mb-0"><span class="fw-bold">Artículo: </span><span class="c-green">' . $product[$i] . '</span></p>
                                        <p class="mb-0"><span class="fw-bold">Precio: </span><span class="c-green">' . $price[$i] . '</span></p>
                                        <p class="mb-0"><span class="fw-bold">Cantidad: </span><span class="c-green">' . $qtty[$i] . '</span></p>
                                        <p class="mb-0"><span class="fw-bold">Total a pagar: </span><span class="c-green">' . $price[$i] * $qtty[$i] . '</span></p>
                                        <br>';
                                        $total += $price[$i] * $qtty[$i]; // Ojo siempre la cago aquí. Para sumar en una variable hay que declararla y asignarle un valor primero.
                                    }
                                    ?>
                                    <div id="paypal-button"></div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<script>

  paypal.Button.render({

    // Configure environment

    env: 'sandbox',

    client: {

      sandbox: 'demo_sandbox_client_id',

      production: 'demo_production_client_id'

    },

    // Customize button (optional)

    locale: 'es_ES',

    style: {
        size: 'small', color: 'gold', shape: 'pill',
    },


    // Enable Pay Now checkout flow (optional)

    commit: true,


    // Set up a payment

    payment: function(data, actions) {
        var btn = document.getElementById('getQR');
        btn.style.visibility = "visible";

      return actions.payment.create({

        transactions: [{

            amount: {
                  total: '<?php echo $total; ?>', currency: 'EUR'
            }
        }]
      });
    },

    // Execute the payment

    onAuthorize: function(data, actions) {

      return actions.payment.execute().then(function() {

        // Show a confirmation message to the buyer

        window.alert('Gracias por tu Compra!');

      });

    }

  }, '#paypal-button');

</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="checkout.php" method="post">
                <?php
                for ($i = 0; $i < count($qtty); $i++)
                {
                    echo '<input type="hidden" name="id' . $i . '" value="' . $id[$i] . '">';
                    echo '<input type="hidden" name="product' . $i . '" value="' . $product[$i] . '">
                    <input type="hidden" name="price' . $i . '" value="' . $price[$i] . '">
                    <input type="hidden" name="qtty' . $i . '" value="' . $qtty[$i] . '">';
                }
                ?>
                <input class="btn btn-primary" type="submit" id="getQR" style="visibility: hidden;" value="Quiero Pagar mi Pedido">
            </form>
        </div>
    </div>
</div>
<?php
include "includes/footer.html";
?>