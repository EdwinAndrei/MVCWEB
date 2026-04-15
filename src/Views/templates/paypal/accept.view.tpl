<div class="result-box success">

  <h1 class="result-title">Pago Completado</h1>
  <p class="result-text">Tu compra fue realizada con éxito</p>

  <div class="receipt-card">

    <div class="receipt-header">
      ✔ Transacción Aprobada
    </div>

    <div class="receipt-body">
      <p><strong>Estado:</strong> COMPLETADO</p>
      <p><strong>Cliente:</strong> {{clienteNombre}}</p>
      <p><strong>Email:</strong> {{clienteEmail}}</p>
      <p><strong>País:</strong> {{clientePais}}</p>
    </div>

    <details class="json-toggle">
      <summary>Ver detalle técnico</summary>
      <pre class="result-json">{{orderjson}}</pre>
    </details>

  </div>

  <a href="index.php?page=Products_Products" class="btn-primary">
    Volver a la tienda
  </a>

</div>