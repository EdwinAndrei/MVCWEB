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

    <div class="invoice">

      <div class="invoice-top">
        <div>
          <h2>Factura</h2>
          <p><strong>ID Orden:</strong> {{orderId}}</p>
          <p><strong>Referencia:</strong> {{referenceId}}</p>
          <p><strong>Fecha:</strong> {{fecha}}</p>
        </div>
        <div class="invoice-status">
          ✔ COMPLETADO
        </div>
      </div>

      <hr>

      <div class="invoice-section">
        <h3>Cliente</h3>
        <p><strong>Nombre:</strong> {{clienteNombre}}</p>
        <p><strong>Email:</strong> {{clienteEmail}}</p>
        <p><strong>País:</strong> {{clientePais}}</p>
      </div>

      <div class="invoice-section">
        <h3>Datos PayPal</h3>
        <p><strong>Nombre:</strong> {{paypalNombre}}</p>
        <p><strong>Email:</strong> {{paypalEmail}}</p>
        <p><strong>Payer ID:</strong> {{payerId}}</p>
      </div>

      <div class="invoice-section">
        <h3>Dirección de Envío</h3>
        <p>{{direccion}}</p>
        <p>{{ciudad}}, {{region}}</p>
        <p>Código Postal: {{postal}}</p>
      </div>

      <div class="invoice-section">
        <h3>Pago</h3>
        <p><strong>ID Transacción:</strong> {{captureId}}</p>
        <p><strong>Monto:</strong> ${{monto}}</p>
        <p><strong>Moneda:</strong> {{moneda}}</p>
        <p><strong>Protección:</strong> {{proteccion}}</p>
      </div>

      <div class="invoice-section">
        <h3>Detalle de Pago</h3>
        <p><strong>Monto bruto:</strong> ${{bruto}}</p>
        <p><strong>Comisión PayPal:</strong> ${{fee}}</p>
        <p><strong>Total recibido:</strong> ${{neto}}</p>
      </div>

      <div class="invoice-section total">
        <p><strong>Total Pagado:</strong> ${{monto}}</p>
      </div>

    </div>

  </div>

  <div class="result-actions">
    <a href="index.php?page=Products_Products" class="btn-primary">
       Volver a la tienda
    </a>
  </div>

</div>