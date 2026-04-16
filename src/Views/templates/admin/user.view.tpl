<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Admin_User&mode={{mode}}&usercod={{usercod}}" method="POST"
        class="col-12 col-m-8 offset-m-2 caps-form-card">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usercodD">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="usercodD" id="usercodD" value="{{usercod}}" />
      <input type="hidden" name="usercod" value="{{usercod}}" />
      <input type="hidden" name="uuid" value="{{xsrf_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="username">Nombre</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="text" name="username" id="username" value="{{username}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="useremail">Correo</label>
      <input class="col-12 col-m-9" {{isReadonly}} type="email" name="useremail" id="useremail" value="{{useremail}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userest">Estado</label>
      <select name="userest" id="userest" class="col-12 col-m-9" {{isDisabled}}>
        <option value="ACT" {{userest_ACT}}>Activo</option>
        <option value="INA" {{userest_INA}}>Inactivo</option>
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
      window.location.assign("index.php?page=Admin_Users");
    });
  });
</script>