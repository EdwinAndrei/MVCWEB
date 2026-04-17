<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{BASE_DIR}}/public/css/colors.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{BASE_DIR}}/public/css/appstyle.css" />
  <script src="https://kit.fontawesome.com/{{FONT_AWESOME_KIT}}.js" crossorigin="anonymous"></script>
  {{foreach SiteLinks}}
    <link rel="stylesheet" href="{{~BASE_DIR}}/{{this}}" />
  {{endfor SiteLinks}}
  {{foreach BeginScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor BeginScripts}}
</head>
<body>
  <header>
    <input type="checkbox" class="menu_toggle" id="menu_toggle" />
    <label for="menu_toggle" class="menu_toggle_icon">
      <div class="hmb dgn pt-1"></div>
      <div class="hmb hrz"></div>
      <div class="hmb dgn pt-2"></div>
    </label>
   <a href="index.php?page=Home_Home" class="caps-brand">
  <img src="{{BASE_DIR}}/public/imgs/CAPSLOGO.jpg" alt="CAPS Logo" class="caps-logo-img">
  <div class="caps-brand-text">
    <span class="caps-logo-text">CAPS</span>
    <span class="caps-logo-sub">Centro de Atención Psicopedagógica</span>
  </div>
</a>
    <nav id="menu">
      <ul>
        <li><a href="index.php?page=Home_Home"><i class="fas fa-home"></i>&nbsp;Inicio</a></li>
        {{foreach PUBLIC_NAVIGATION}}
            <li><a href="{{nav_url}}">{{nav_label}}</a></li>
        {{endfor PUBLIC_NAVIGATION}}
      </ul>
    </nav>
  </header>
  <main>
  {{{page_content}}}
  </main>
  <footer>
    <div class="caps-footer-inner">
      <div class="caps-footer-brand">
        <span class="caps-footer-logo">CAPS</span>
        <span class="caps-footer-tagline">Centro de Atención Psicopedagógica</span>
      </div>
      <div class="caps-footer-contact">
        <i class="fas fa-phone"></i>&nbsp;+504 9464-9581
      </div>
    <div class="caps-footer-social">
       <a href="https://www.facebook.com/caps.hn.2025" target="_blank" aria-label="Facebook">
        <i class="fab fa-facebook-f"></i>
       </a>
       <a href="https://www.instagram.com/capshn01?igsh=MTk4Nm5iZDJ2ajc1cA==" target="_blank" aria-label="Instagram">
        <i class="fab fa-instagram"></i>
       </a>
    </div>
      <div class="caps-footer-copy">
        &copy; 2026 CAPS &mdash; Todos los derechos reservados.
      </div>
    </div>
  </footer>
  {{foreach EndScripts}}
    <script src="{{~BASE_DIR}}/{{this}}"></script>
  {{endfor EndScripts}}

  
</body>
</html>