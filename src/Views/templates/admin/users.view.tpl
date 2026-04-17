<h1 id="CAPS-h1-productostitulo">Gestión de Usuarios</h1>

<section class="WWList">
  <div class="caps-table-topbar">
  </div>

  <table class="caps-products-table">
    <thead>
      <tr>
        <th>Id</th>
        <th class="left">Nombre</th>
        <th class="left">Correo</th>
        <th>Estado</th>
        <th>Roles</th>
        {{if showActions}}
        <th>Acciones</th>
        {{endif showActions}}
      </tr>
    </thead>
    <tbody>
      {{foreach usuarios}}
      <tr>
        <td>
          <a class="link" href="index.php?page=Admin_User&mode=DSP&usercod={{usercod}}">
            {{usercod}}
          </a>
        </td>
        <td>{{username}}</td>
        <td>{{useremail}}</td>
        <td>{{userestDsc}}</td>
        <td>{{roles}}</td>
        {{if ~showActions}}
        <td>
          {{if ~showUpdate}}
          <a href="index.php?page=Admin_User&mode=UPD&usercod={{usercod}}">Editar</a>
          {{endif ~showUpdate}}
          {{if ~showRoles}}
          <br />
          <a href="index.php?page=Admin_User&mode=ROL&usercod={{usercod}}">Roles</a>
          {{endif ~showRoles}}
          {{if ~showDelete}}
          <br />
          <a href="index.php?page=Admin_User&mode=DEL&usercod={{usercod}}">Eliminar</a>
          {{endif ~showDelete}}
        </td>
        {{endif ~showActions}}
      </tr>
      {{endfor usuarios}}
    </tbody>
  </table>
</section>