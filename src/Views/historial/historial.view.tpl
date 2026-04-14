<h1>Historial</h1>

<table>
<tr>
  <th>Usuario</th>
  <th>Acción</th>
  <th>Fecha</th>
</tr>

{{foreach historial}}
<tr>
  <td>{{username}}</td>
  <td>{{accion}}</td>
  <td>{{fecha}}</td>
</tr>
{{endfor historial}}
</table>