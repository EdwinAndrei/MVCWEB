<h1 id="CAPS-h1-productostitulo">Trabajar con Citas</h1>

<section class="WWList">
  <table class="caps-products-table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Creador de la cita</th>
        <th>Servicio</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        {{if showActions}}
        <th>Acciones</th>
        {{endif showActions}}
      </tr>
    </thead>
    <tbody>
      {{foreach citas}}
      <tr>
        <td><a class="link" href="index.php?page=Citas_Cita&mode=DSP&id={{id}}">
        {{id}}
          </a>
        </td>
        <td>{{username}}</td>
        <td>{{servicio_nombre}}</td>
        <td>{{fecha}}</td>
        <td>{{hora}}</td>
        <td>{{estadoDsc}}</td>
        {{if ~showActions}}
        <td>
          {{if ~showUpdate}}
          <a href="index.php?page=Citas_Cita&mode=UPD&id={{id}}">Actualizar</a>
          {{endif ~showUpdate}}
          {{if ~showDelete}}
          <br />
          <a href="index.php?page=Citas_Cita&mode=DEL&id={{id}}">Eliminar</a>
          {{endif ~showDelete}}
        </td>
        {{endif ~showActions}}
      </tr>
      {{endfor citas}}
    </tbody>
  </table>
</section>