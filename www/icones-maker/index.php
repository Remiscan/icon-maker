<?php
$commonDir = dirname(__DIR__, 1).'/_common';
require_once $commonDir.'/php/version.php';
?>
<!doctype html>
<html>
  <head>
    <title>Icônes de mes projets - remiscan.fr</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1">
    <meta name="theme-color" content="hsl(250, 40%, 20%)">

    <link href="styles--<?=version(__DIR__, 'styles.css')?>.css" rel="stylesheet">
  </head>

  <body>

  <h2>SVG 😍 | 
    <input id="choix-taille" type="range" value="512" min="16" max="1024" step="16" oninput="
      document.body.style.setProperty('--size', this.value + 'px');
      document.getElementById('size').innerHTML = this.value + 'px';
    ">
    <span id="size">512px</span>
     | 
    <label for="circ">Icônes rondes</label> 
    <input id="circ" type="checkbox" oninput="console.log(this.checked); Array.from(document.getElementsByClassName('svg')).forEach(e => { if (this.checked) e.classList.add('round'); else e.classList.remove('round'); })">
  </h2>

  <div class="conteneur">

<!-- COLORI -->
<div class="icone" data-app="colori"><div class="svg" data-bgcolor="#4AE5B3" style="background-image: url('../colori/demo/icons/icon.svg');"></div></div>

<!-- CSSWITCH -->
<div class="icone" data-app="csswitch"><div class="svg" data-bgcolor="#FFFFFF" style="background-image: url('../csswitch/icons/icon.svg');"></div></div>

<!-- SOLAIRE -->
<div class="icone" data-app="solaire"><div class="svg" data-bgcolor="#201115" data-app="true" style="background-image: url('../solaire/icons/icon.svg');"></div></div>

<!-- RÉMIDEX -->
<div class="icone" data-app="shinydex"><div class="svg" data-bgcolor="#4151B2" data-app="true" style="background-image: url('../shinydex/images/app-icons/icon.svg');"></div></div>

<!-- REMISCAN.FR -->
<div class="icone" data-app="mon-portfolio"><div class="svg" data-bgcolor="#311931" style="background-image: url('../mon-portfolio/icons/icon.svg');"></div></div>

  </div>

  <h2>Maskable</h2>

  <div class="conteneur maskable">

<!-- COLORI -->
<div class="icone maskable" data-app="colori"><div class="svg" data-bgcolor="#4AE5B3" style="background-image: url('../colori/demo/icons/icon-maskable.svg');"></div></div>

<!-- CSSWITCH -->
<div class="icone maskable" data-app="csswitch"><div class="svg" data-bgcolor="#FFFFFF" style="background-image: url('../csswitch/icons/icon-maskable.svg');"></div></div>

<!-- SOLAIRE -->
<div class="icone maskable" data-app="solaire"><div class="svg" data-bgcolor="#201115" data-app="true" style="background-image: url('../solaire/icons/icon-maskable.svg');"></div></div>

<!-- RÉMIDEX -->
<div class="icone maskable" data-app="shinydex"><div class="svg" data-bgcolor="#4151B2" data-app="true" style="background-image: url('../shinydex/images/app-icons/icon-maskable.svg');"></div></div>

<!-- REMISCAN.FR -->
<div class="icone maskable" data-app="mon-portfolio"><div class="svg" data-bgcolor="#311931" style="background-image: url('../mon-portfolio/icons/icon-maskable.svg');"></div></div>

  </div>

  <div class="conteneur liste-canvas"></div>

  <h2>Mosaïque d'aperçu de mes projets</h2>

  <div class="mosaique">
    <div class="mosaicone"><div class="svg" style="background-image: url('../colori/demo/icons/icon.svg');"></div></div>
    <div class="mosaicone"><div class="svg" style="background-image: url('../csswitch/icons/icon.svg');"></div></div>
    <div class="mosaicone"><div class="svg" style="background-image: url('../solaire/icons/icon.svg');"></div></div>
    <div class="mosaicone"><div class="svg" style="background-image: url('../remidex/images/app-icons/icon.svg');"></div></div>
    <div class="fleche"></div>
  </div>

  <?php //include 'icones-css.html'; ?>

  <script type="module">
    import { drawIcon, prepareDl } from './mod_drawIcon--<?=version(__DIR__, 'mod_drawIcon.js')?>.js';

    
    // Détecte le clic sur chaque icône pour créer les icônes
    Array.from(document.querySelectorAll('.icone')).forEach((e, k) => {
      e.addEventListener('click', async event => {
        const app = event.currentTarget.dataset.app;
        const svg = document.querySelector(`.icone[data-app="${app}"]:not(.maskable) > .svg`);
        const svgMaskable = document.querySelector(`.icone[data-app="${app}"].maskable > .svg`);
        const conteneur = document.querySelectorAll('.conteneur')[k];
        document.querySelector('.liste-canvas').innerHTML = '<h2>Icônes générées</h2>';

        //let ask = window.confirm('Télécharger les icônes ?');
        let ask = true;
        if (!ask) return;

        // Icône ronde avec ombre, 192px pour Android
        await drawIcon(svg, 192, true, svg.dataset.bgcolor, true)
        .then(canvas => prepareDl(canvas, 'icon-192.png'));

        // Icône ronde avec ombre, 512px pour Android (splash screen)
        await drawIcon(svg, 512, true, svg.dataset.bgcolor, true)
        .then(canvas => prepareDl(canvas, 'icon-512.png'));

        // Icône carrée, 180px pour iOS
        await drawIcon(svgMaskable, 180, false, svg.dataset.bgcolor, false)
        .then(canvas => prepareDl(canvas, 'apple-touch-icon.png'));

        // Icône carrée, 192px pour Android (splash screen)
        await drawIcon(svgMaskable, 192, false, svg.dataset.bgcolor, false)
        .then(canvas => prepareDl(canvas, 'icon-192-maskable.png'));

        // Icône carrée, 512px pour Android (splash screen)
        await drawIcon(svgMaskable, 512, false, svg.dataset.bgcolor, false)
        .then(canvas => prepareDl(canvas, 'icon-512-maskable.png'));
      });
    });


    // Gère le redimensionnement de page
    function recalcSize() {
      const input = document.getElementById('choix-taille');
      let maxSize = 1024;
      const currentValue = input.value;
      while (window.innerWidth - 26 < maxSize) {
        maxSize -= 16;
      }
      
      input.max = maxSize;
      if (maxSize < 512 && currentValue > maxSize) input.value = maxSize;
      document.body.style.setProperty('--size', input.value + 'px');
      document.getElementById('size').innerHTML = input.value + 'px';
    }

    window.onload = recalcSize();
    window.addEventListener('resize', recalcSize);
    window.addEventListener('orientationchange', recalcSize);


    // Convertit les coordonnées d'une icône non-maskable pour ajouter sa marge de sécurité à la version maskable
    window.tomask = nombres => {
      let array = nombres;
      if (typeof array == 'string' || typeof array == 'number') array = [Number(nombres)];
      array.forEach(x => { console.log('x =', x, ' ; x2 =', 51.2 + 0.8 * x) })
    };
  </script>
  </body>
</html>