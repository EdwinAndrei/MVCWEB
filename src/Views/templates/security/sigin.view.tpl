<section class="caps-auth-wrapper">
  <div class="caps-auth-card">
    <div class="caps-auth-header">
      <h1>Crear Cuenta</h1>
      <p>Regístrate para agendar citas y usar los servicios de CAPS.</p>
    </div>

    <form method="post" action="index.php?page=sec_register">

      <div class="caps-form-group">
        <label for="txtName">Nombre</label>
        <input type="text" id="txtName" name="txtName" value="{{txtName}}" placeholder="Ingresa tu nombre" />
        {{if errorName}}
        <div class="caps-error">{{errorName}}</div>
        {{endif errorName}}
      </div>

      <div class="caps-form-group">
        <label for="txtEmail">Correo Electrónico</label>
        <input type="email" id="txtEmail" name="txtEmail" value="{{txtEmail}}" placeholder="correo@ejemplo.com" />
        {{if errorEmail}}
        <div class="caps-error">{{errorEmail}}</div>
        {{endif errorEmail}}
      </div>

      <div class="caps-form-group">
        <label for="txtPswd">Contraseña</label>
        <input type="password" id="txtPswd" name="txtPswd" value="{{txtPswd}}" placeholder="Crea una contraseña segura" />
        {{if errorPswd}}
        <div class="caps-error">{{errorPswd}}</div>
        {{endif errorPswd}}
      </div>

      {{if generalError}}
      <div class="caps-error caps-error-box">
        {{generalError}}
      </div>
      {{endif generalError}}

      <button class="caps-auth-btn" id="btnSignin" type="submit">Crear Cuenta</button>

      <div class="caps-auth-footer">
        <span>¿Ya tienes cuenta?</span>
        <a href="index.php?page=sec_login">Iniciar sesión</a>
      </div>
    </form>
  </div>
</section>
