<h1 id="CAPS-h1-productostitulo">Gestión de Productos</h1>

<section class="WWList">
  <div class="caps-table-topbar">
    {{if showNew}}
    <a class="caps-new-btn" href="index.php?page=Products_Product&mode=INS&productId=0">Nuevo</a>
    {{endif showNew}}
  </div>

  <table class="caps-products-table">
    <thead>
      <tr>
        {{if showActions}}
        <th>Id</th>
        {{endif showActions}}
        <th>Imagen</th>
        <th class="left">Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        {{if showActions}}
        <th>Estado</th>
        {{endif showActions}}
        {{if showCartActions}}
        <th>Comprar</th>
        {{endif showCartActions}}
        {{if showActions}}
        <th>Acciones</th>
        {{endif showActions}}
      </tr>
    </thead>
    <tbody>
      {{foreach products}}
      <tr>
      {{if ~showActions}}
        <td>{{productId}}</td>
      {{endif ~showActions}}
        <td>
          <img class="product-thumb" src="{{productImgUrl}}" alt="{{productName}}">
        </td>
        <td>
          {{if ~showActions}}
          <a class="link" href="index.php?page=Products_Product&mode=DSP&productId={{productId}}">
            {{productName}}
          </a>
          {{endif ~showActions}}
          {{ifnot ~showActions}}
          {{productName}}
          {{endifnot ~showActions}}
        </td>
        <td>{{productPrice}}</td>
        <td>{{productStock}}</td>
        {{if ~showActions}}
        <td>{{productStatusDsc}}</td>
        {{endif ~showActions}}
        {{if ~showCartActions}}
        <td>
          <form action="index.php?page=Carretilla_Carretilla" method="POST">
            <input type="hidden" name="productId" value="{{productId}}" />
            <input type="hidden" name="price" value="{{productPrice}}" />
            <input class="caps-cart-qty" type="number" name="quantity" min="1" max="{{productStock}}" value="1" onkeydown="return false;"/>
            <button class="caps-cart-btn" type="submit" title="Agregar al carrito">
              <i class="fas fa-cart-plus"></i>
            </button>
          </form>
        </td>
        {{endif ~showCartActions}}
        {{if ~showActions}}
        <td>
          {{if ~showUpdate}}
          <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}">Actualizar</a>
          {{endif ~showUpdate}}
          {{if ~showDelete}}
          <br />
          <a href="index.php?page=Products_Product&mode=DEL&productId={{productId}}">Eliminar</a>
          {{endif ~showDelete}}
        </td>
        {{endif ~showActions}}
      </tr>
      {{endfor products}}
    </tbody>
  </table>
</section>

<script>
console.log("JS cargado");
</script>