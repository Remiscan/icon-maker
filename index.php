<?php
$apps = [
  [
    'id' => 'colori',
    'icon' => '../colori/demo/icons/icon.svg',
    'color' => '#4AE5B3'
  ], [
    'id' => 'csswitch',
    'icon' => '../csswitch/icons/icon.svg',
    'color' => '#FFFFFF'
  ], [
    'id' => 'solaire',
    'icon' => '../solaire/icons/icon.svg',
    'color' => '#201115'
  ], [
    'id' => 'shinydex',
    'icon' => '../shinydex/images/app-icons/icon.svg',
    'color' => '#4151B2'
  ], [
    'id' => 'mon-portfolio',
    'icon' => '../mon-portfolio/icons/icon.svg',
    'color' => '#311931'
  ]
];
?>
<!doctype html>
<html>
  <head>
    <title>Icônes de mes projets - remiscan.fr</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1">
    <meta name="theme-color" content="hsl(250, 40%, 20%)">

    <?php versionizeStart(); ?>

    <!-- Import map -->
    <script defer src="/_common/polyfills/es-module-shims.js"></script>
    <script type="importmap">
    {
      "imports": {
        "draw-icon": "./modules/drawIcon.js",
        "zip-icons": "./modules/zipIcons.js"
      }
    }
    </script>
    <script defer src="./ext/jszip.min.js"></script>
    <script type="module" src="./modules/main.js"></script>

    <link href="styles.css" rel="stylesheet">

    <?php versionizeEnd(__DIR__); ?>
  </head>

  <body>

    <h2>SVG 😍 | 
      <input id="choix-taille" type="range" value="512" min="16" max="1024" step="16">
      <span id="size">512px</span>
      | 
      <label for="circ">Icônes rondes</label> 
      <input id="circ" type="checkbox">
    </h2>

    <table>
      <thead>
        <tr>
          <th>App</th>
          <th>Icon</th>
          <th>Maskable icon</th>
          <th></th>
        </tr>
      </thead>

      <tbody class="icon-list">
      <?php foreach($apps as $app) { ?>
        <tr data-app="<?=$app['id']?>">
          <td class="app-name"><?=$app['id']?></td>
          <td class="icone non-maskable">
            <div>
              <img src="<?=$app['icon']?>" width="512" height="512">
            </div>
          </td>
          <td class="icone maskable">
            <div>
              <img src="<?=str_replace('.svg', '-maskable.svg', $app['icon'])?>" width="512" height="512">
            </div>
          </td>
          <td>
            <button type="button" data-app="<?=$app['id']?>" data-color="<?=$app['color']?>">Generate icons</button>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

    <!--<div class="conteneur liste-canvas"></div>

    <h2>Mosaïque d'aperçu de mes projets</h2>

    <div class="mosaique">
      <div class="mosaicone"><div class="svg" style="background-image: url('../colori/demo/icons/icon.svg');"></div></div>
      <div class="mosaicone"><div class="svg" style="background-image: url('../csswitch/icons/icon.svg');"></div></div>
      <div class="mosaicone"><div class="svg" style="background-image: url('../solaire/icons/icon.svg');"></div></div>
      <div class="mosaicone"><div class="svg" style="background-image: url('../remidex/images/app-icons/icon.svg');"></div></div>
      <div class="fleche"></div>
    </div>-->
  </body>
</html>