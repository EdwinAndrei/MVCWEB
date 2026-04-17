<section class="caps-cart-page">
    <div class="caps-cart-sidebar">

        <div class="caps-cart-header">
            Carrito
        </div>

        {{if carretilla}}
        <div class="caps-cart-body">

            {{foreach carretilla}}
            <div class="caps-cart-item">
                
                <div class="caps-cart-image-wrap">
                    <img src="{{productImgUrl}}" alt="{{productName}}" class="caps-cart-image">
                </div>

                <div class="caps-cart-info">
                    <div class="caps-cart-name">
                        {{productName}}
                    </div>

                    <div class="caps-cart-text">
                        Precio: L {{precio}}
                    </div>

                    <div class="caps-cart-text">
                        Cantidad: {{cantidad}}
                    </div>

                    <div class="caps-cart-subtotal">
                        Subtotal: L {{subtotal}}
                    </div>

                    <a href="index.php?page=Carretilla-Carretilla&remove={{productId}}" class="caps-cart-remove">
                        Eliminar
                    </a>
                </div>
            </div>
            {{endfor carretilla}}

        </div>
        {{endif carretilla}}

        {{ifnot carretilla}}
        <div class="caps-cart-empty">
            <p>Tu carrito está vacío</p>
        </div>
        {{endifnot carretilla}}

        <div class="caps-cart-footer">
            <div class="caps-cart-total-row">
                <span>Total</span>
                <span>L {{total}}</span>
            </div>

            <a href="index.php?page=Carretilla_Carretilla&clear=1" class="caps-cart-action caps-cart-action-dark">
                Vaciar carrito
            </a>

            <a href="index.php?page=Checkout_Checkout" class="caps-cart-action caps-cart-action-primary">
                Realizar compra
            </a>

            <a href="index.php?page=Products_Products" class="caps-cart-action caps-cart-action-dark">
                Regresar
            </a>
        </div>

    </div>
</section>