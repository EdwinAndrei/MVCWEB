<h1 id="CAPS-h1-productostitulo">Transacciones</h1>

<section class="WWList">
  <table class="caps-products-table">
    <thead>
      <tr>
        <th>Id</th>
        <th class="left">Usuario</th>
        <th class="left">Correo</th>
        <th>Monto</th>
        <th>Tipo</th>
        <th>Fecha</th>
        <th>Estado</th>
        {{if showActions}}
        <th>Acciones</th>
        {{endif showActions}}
      </tr>
    </thead>
    <tbody>
      {{foreach transacciones}}
      <tr>
        <td>
          <a class="link" href="index.php?page=Admin_Transaccion&mode=DSP&id={{id}}">
            {{id}}
          </a>
        </td>
        <td>{{username}}</td>
        <td>{{useremail}}</td>
        <td>L. {{monto}}</td>
        <td>{{tipo}}</td>
        <td>{{fecha}}</td>
        <td>{{estado}}</td>
        {{if ~showActions}}
        <td>
          {{if ~showDetail}}
          <a href="index.php?page=Admin_Transaccion&mode=DSP&id={{id}}">Ver</a>
          {{endif ~showDetail}}
          {{if ~showDelete}}
          <br />
          <a href="index.php?page=Admin_Transaccion&mode=DEL&id={{id}}">Eliminar</a>
          {{endif ~showDelete}}
        </td>
        {{endif ~showActions}}
      </tr>
      {{endfor transacciones}}
    </tbody>
  </table>
</section>