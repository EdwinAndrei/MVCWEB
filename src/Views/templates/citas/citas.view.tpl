<h1 id="CAPS-h1-productostitulo">Trabajar con Citas</h1>

<section class="WWList">
    <div class="caps-table-topbar">
      {{if showNew}}
      <a class="caps-new-btn" href="index.php?page=Citas_Cita&mode=INS&id=0">Agendar</a>
      {{endif showNew}}
    </div>
  <table class="caps-products-table">
    <thead>
      <tr>
        {{if showActions}}
        <th>Id</th>
        {{endif showActions}}
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
      {{if ~showActions}}
        <td><a class="link" href="index.php?page=Citas_Cita&mode=DSP&id={{id}}">
        {{id}}
          </a>
        </td>
        {{endif ~showActions}}
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