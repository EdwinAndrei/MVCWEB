<section class="container-m row px-4 py-4">
  <h1 id="CAPS-h1-productotitulo">{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <div class="col-12 col-m-8 offset-m-2 caps-form-card">

    <h3>Roles asignados</h3>
    {{foreach rolesUsuario}}
    <form action="index.php?page=Admin_User&mode=ROL&usercod={{&usercod}}" method="POST"
          class="row my-2 align-center">
      <input type="hidden" name="accion" value="quitar">
      <input type="hidden" name="rolescod" value="{{rolescod}}">
      <input type="hidden" name="uuid" value="{{&xsrf_token}}">
      <span class="col-9">{{rolescod}}</span>
      <button class="caps-secondary-btn col-3" type="submit">Quitar</button>
    </form>
    {{endfor rolesUsuario}}

    <hr style="margin: 1.5rem 0;">

    <h3>Asignar nuevo rol</h3>
    <form action="index.php?page=Admin_User&mode=ROL&usercod={{usercod}}" method="POST"
          class="row my-2 align-center">
      <input type="hidden" name="accion" value="asignar">
      <input type="hidden" name="uuid" value="{{xsrf_token}}">
      <select name="rolescod" class="col-9">
        {{foreach roles}}
        <option value="{{rolescod}}">{{rolesdsc}}</option>
        {{endfor roles}}
      </select>
      &nbsp;
      <button class="primary col-2" type="submit">Asignar</button>
    </form>

    <div class="row my-4 flex-end caps-form-actions">
      <button class="caps-secondary-btn" type="button" id="btnRegresar">Regresar</button>
    </div>

  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnRegresar").addEventListener("click", (e) => {
      e.preventDefault();
      window.location.assign("index.php?page=Admin_Users");
    });
  });
</script>