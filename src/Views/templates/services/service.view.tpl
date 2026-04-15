<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Services_Service&mode={{mode}}&service_id={{service_id}}" method="POST" class="col-12 col-m-8 offset-m-2 caps-form-card">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="serviceIdD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="serviceIdD" id="serviceIdD" value="{{service_id}}" />
      <input type="hidden" name="service_id" value="{{service_id}}" />
      <input type="hidden" name="uuid" value="{{xsrf_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="nombre">Nombre</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="text" name="nombre" id="nombre" value="{{nombre}}" />
    </div>
    {{if nombreError}}
    <div class="col-12 col-m-9 offset-m-3 error">
      {{nombreError}}
    </div>
    {{endif nombreError}}

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="descripcion">Descripción</label>
      <textarea class="col-12 col-m-9" {{isReadonly}} name="descripcion" id="descripcion">{{descripcion}}</textarea>
    </div>
    {{if descripcionError}}
    <div class="col-12 col-m-9 offset-m-3 error">
      {{descripcionError}}
    </div>
    {{endif descripcionError}}

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="precio">Precio</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="number" step="0.01" name="precio" id="precio" value="{{precio}}" />
    </div>
    {{if precioError}}
    <div class="col-12 col-m-9 offset-m-3 error">
      {{precioError}}
    </div>
    {{endif precioError}}

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="estado">Estado</label>
      <select name="estado" id="estado" class="col-12 col-m-9" {{if isReadonly}} readonly disabled {{endif isReadonly}}>
        <option value="ACT" {{estado_ACT}}>Activo</option>
        <option value="IACT" {{estado_IACT}}>Inactivo</option>
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
      window.location.assign("index.php?page=Services_Services");
    });
  });
</script>