<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Products_Product&mode={{mode}}&productId={{productId}}" method="POST" class="col-12 col-m-8 offset-m-2 caps-form-card">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productIdD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="productIdD" id="productIdD" value="{{productId}}" />
      <input type="hidden" name="productId" value="{{productId}}" />
      <input type="hidden" name="uuid" value="{{xsrf_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productName">Producto</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="text" name="productName" id="productName" value="{{productName}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productDescription">Descripción</label>
      <textarea class="col-12 col-m-9" {{isReadonly}} name="productDescription" id="productDescription">{{productDescription}}</textarea>
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productPrice">Precio</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="number" step="0.01" name="productPrice" id="productPrice" value="{{productPrice}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productImgUrl">Url de Imagen</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="text" name="productImgUrl" id="productImgUrl" value="{{productImgUrl}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productStock">Stock</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="number" name="productStock" id="productStock" value="{{productStock}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="productStatus">Estado</label>
      <select name="productStatus" id="productStatus" class="col-12 col-m-9" {{if isReadonly}} readonly disabled {{endif isReadonly}}>
        <option value="ACT" {{productStatus_ACT}}>Activo</option>
        <option value="INA" {{productStatus_INA}}>Inactivo</option>
      </select>
    </div>

    <div class="row my-4 align-center flex-end caps-form-actions">
  {{ifnot hideConfirm}}
  <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar" title="{{confirmToolTip}}">Confirmar</button>
  &nbsp;
  {{endifnot hideConfirm}}

  <button class="caps-secondary-btn col-12 col-m-2" type="button" id="btnCancelar">
    {{ifnot hideConfirm}}
    Cancelar
    {{endifnot hideConfirm}}
    {{if hideConfirm}}
    Regresar
    {{endif hideConfirm}}
  </button>
</div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Products_Products");
    });
  });
</script>