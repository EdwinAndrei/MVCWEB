<h1 id="CAPS-h1-productostitulo">Gestión de Servicios</h1>

<section class="WWList">
  <div class="caps-table-topbar">
    {{if showNew}}
    <a class="caps-new-btn" href="index.php?page=Services_Service&mode=INS&service_id=0">Nuevo</a>
    {{endif showNew}}
  </div>

  <table class="caps-products-table">
    <thead>
      <tr>
        {{if showActions}}
        <th>Id</th>
        {{endif showActions}}
        <th class="left">Nombre</th>
        <th class="left">Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        {{if showActions}}
        <th>Acciones</th>
        {{endif showActions}}
      </tr>
    </thead>
    <tbody>
      {{foreach services}}
      <tr>
      {{if ~showActions}}
        <td>{{servicio_id}}</td>
      {{endif ~showActions}}
        <td>
        {{if ~showActions}}
          <a class="link" href="index.php?page=Services_Service&mode=DSP&service_id={{servicio_id}}">
            {{nombre}}
          </a>
          {{endif ~showActions}}
          {{ifnot ~showActions}}
          {{nombre}}
          {{endifnot ~showActions}}
        </td>
        <td>{{descripcion}}</td>
        <td>{{precio}}</td>
        <td>{{statusDsc}}</td>
        {{if ~showActions}}
        <td>
          {{if ~showUpdate}}
          <a href="index.php?page=Services_Service&mode=UPD&service_id={{servicio_id}}">Actualizar</a>
          {{endif ~showUpdate}}
          {{if ~showDelete}}
          <br />
          <a href="index.php?page=Services_Service&mode=DEL&service_id={{servicio_id}}">Eliminar</a>
          {{endif ~showDelete}}
        </td>
        {{endif ~showActions}}
      </tr>
      {{endfor services}}
    </tbody>
  </table>
</section>