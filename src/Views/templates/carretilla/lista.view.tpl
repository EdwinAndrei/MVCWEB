<section class="container-carrito">

    <div class="carrito-panel">

        <div class="carrito-header">
            Carrito
        </div>

        {{if carretilla}}
        <div class="carrito-body">

            {{foreach carretilla}}
            <div class="carrito-item">
                
                <div>
                    <img src="{{productImgUrl}}" alt="{{productName}}" class="carrito-img">
                </div>

                <div class="carrito-info">
                    <div class="carrito-nombre">
                        {{productName}}
                    </div>

                    <div class="carrito-texto">
                        Precio: L {{precio}}
                    </div>

                    <div class="carrito-texto">
                        Cantidad: {{cantidad}}
                    </div>

                    <div class="carrito-subtotal">
                        Subtotal: L {{subtotal}}
                    </div>

                    <a href="index.php?page=Carretilla-Carretilla&remove={{productId}}" class="carrito-eliminar">
                        Eliminar
                    </a>
                </div>
            </div>
            {{endfor carretilla}}

        </div>
        {{endif carretilla}}

        {{ifnot carretilla}}
        <div class="carrito-vacio">
            <p>Tu carrito está vacío</p>
        </div>
        {{endifnot carretilla}}

        <div class="carrito-footer">
            <div class="carrito-total">
                <span>Total</span>
                <span>L {{total}}</span>
            </div>

            <a href="index.php?page=Carretilla-Carretilla&clear=1" class="btn-vaciar">
                Vaciar carrito
            </a>

            <a href="#" class="btn-comprar">
                Realizar compra
            </a>

            <!-- BOTÓN AGREGADO -->
            <a href="index.php?page=Products_Products" style="display:block; width:100%; background:black; color:white; text-align:center; padding:14px; text-decoration:none; margin-top:10px; font-weight:bold;">
                Regresar
            </a>

        </div>

    </div>
</section>