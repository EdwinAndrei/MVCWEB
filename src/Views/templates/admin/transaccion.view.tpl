<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Admin_Transaccion&mode={{mode}}&id={{id}}" method="POST"
        class="col-12 col-m-8 offset-m-2 caps-form-card">

    <input type="hidden" name="id" value="{{id}}" />
    <input type="hidden" name="uuid" value="{{xsrf_token}}" />

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="idD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" id="idD" value="{{id}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="username">Usuario</label>
      <input class="col-12 col-m-9" readonly type="text" id="username" value="{{username}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="useremail">Correo</label>
      <input class="col-12 col-m-9" readonly type="text" id="useremail" value="{{useremail}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="monto">Monto</label>
      <input class="col-12 col-m-9" readonly type="text" id="monto" value="L. {{monto}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="tipo">Tipo</label>
      <input class="col-12 col-m-9" readonly type="text" id="tipo" value="{{tipo}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="referencia">Referencia</label>
      <input class="col-12 col-m-9" readonly type="text" id="referencia" value="{{referencia}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fecha">Fecha</label>
      <input class="col-12 col-m-9" readonly type="text" id="fecha" value="{{fecha}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="estado">Estado</label>
      <input class="col-12 col-m-9" readonly type="text" id="estado" value="{{estado}}" />
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
      window.location.assign("index.php?page=Admin_Transacciones");
    });
  });
</script>