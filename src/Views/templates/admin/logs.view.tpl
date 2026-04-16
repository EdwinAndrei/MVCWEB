<h1 id="CAPS-h1-productostitulo">Registro de Actividad</h1>

<section class="WWList">
  <table class="caps-products-table">
    <thead>
      <tr>
        <th>#</th>
        <th class="left">Usuario</th>
        <th class="left">Acción</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      {{foreach logs}}
      <tr>
        <td>{{id}}</td>
        <td>{{username}}</td>
        <td>{{accion}}</td>
        <td>{{fecha}}</td>
      </tr>
      {{endfor logs}}
    </tbody>
  </table>
</section>