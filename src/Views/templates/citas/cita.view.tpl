<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Citas_Cita&mode={{mode}}&id={{id}}" method="POST" class="col-12 col-m-8 offset-m-2 caps-form-card">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="idD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="idD" id="idD" value="{{id}}" />
      <input type="hidden" name="id" value="{{id}}" />
      <input type="hidden" name="uuid" value="{{xsrf_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usercod">Creado por</label>
      <input class="col-12 col-m-9" type="text" value="{{username}}" readonly/>
      <input type="hidden" name="usercod" value="{{usercod}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="servicio_id">Servicio</label>
      <select name="servicio_id" id="servicio_id" class="col-12 col-m-9" {{isDisabled}}>
        {{foreach services}}
        <option value="{{servicio_id}}" {{selected}}>{{nombre}}</option>
        {{endfor services}}
      </select>
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fecha">Fecha</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="date" name="fecha" id="fecha" value="{{fecha}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="hora">Hora</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="time" name="hora" id="hora" value="{{hora}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="estado">Estado</label>
      <select name="estado" id="estado" class="col-12 col-m-9" {{isDisabled}}>
        <option value="pendiente" {{estado_pendiente}}>Pendiente</option>
        <option value="confirmada" {{estado_confirmada}}>Confirmada</option>
        <option value="cancelada" {{estado_cancelada}}>Cancelada</option>
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
      window.location.assign("index.php?page=Citas_Citas");
    });
  });
</script>