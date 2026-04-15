<section class="caps-auth-wrapper">
  <div class="caps-auth-card">
    <div class="caps-auth-header">
      <h1>Iniciar Sesión</h1>
      <p>Ingresa con tu correo y contraseña para acceder a CAPS.</p>
    </div>

    <form method="post" action="index.php?page=sec_login{{if redirto}}&redirto={{redirto}}{{endif redirto}}">
      
      <div class="caps-form-group">
        <label for="txtEmail">Correo Electrónico</label>
        <input type="email" id="txtEmail" name="txtEmail" value="{{txtEmail}}" placeholder="correo@ejemplo.com" />
        {{if errorEmail}}
        <div class="caps-error">{{errorEmail}}</div>
        {{endif errorEmail}}
      </div>

      <div class="caps-form-group">
        <label for="txtPswd">Contraseña</label>
        <input type="password" id="txtPswd" name="txtPswd" value="{{txtPswd}}" placeholder="Ingresa tu contraseña" />
        {{if errorPswd}}
        <div class="caps-error">{{errorPswd}}</div>
        {{endif errorPswd}}
      </div>

      {{if generalError}}
      <div class="caps-error caps-error-box">
        {{generalError}}
      </div>
      {{endif generalError}}

      <button class="caps-auth-btn" id="btnLogin" type="submit">Iniciar Sesión</button>

      <div class="caps-auth-footer">
        <span>¿No tienes cuenta?</span>
        <a href="index.php?page=sec_register">Crear cuenta</a>
      </div>
    </form>
  </div>
</section>
