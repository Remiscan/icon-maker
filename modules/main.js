import { makeIcon } from 'draw-icon';
import { downloadFile, zipIcons } from 'zip-icons';



document.getElementById('choix-taille').addEventListener('input', event => {
  document.body.style.setProperty('--size', `${event.currentTarget.value}px`);
  document.getElementById('size').innerHTML = `${event.currentTarget.value}px`;
});

document.getElementById('circ').addEventListener('change', event => {
  document.body.dataset.round = String(event.currentTarget.checked);
});

for (const button of [...document.querySelectorAll('button[data-app]')]) {
  button.addEventListener('click', async event => {
    const app = event.currentTarget.dataset.app;
    const container = document.querySelector(`tr[data-app="${app}"]`)
    const svg = container.querySelector('.non-maskable img').src;
    const svgMaskable = container.querySelector('.maskable img').src;
    const color = event.currentTarget.dataset.color;

    const prepareIcon = async canvas => {
      return await canvas.convertToBlob();
    };

    const files = [
      {
        name: 'icon-192.png',
        data: await prepareIcon(await makeIcon(svg, 192, true, color, true)),
        options: { base64: true }
      }, {
        name: 'icon-512.png',
        data: await prepareIcon(await makeIcon(svg, 512, true, color, true)),
        options: { base64: true }
      }, {
        name: 'apple-touch-icon.png',
        data: await prepareIcon(await makeIcon(svgMaskable, 180, false, color, false)),
        options: { base64: true }
      }, {
        name: 'icon-192-maskable.png',
        data: await prepareIcon(await makeIcon(svgMaskable, 192, false, color, false)),
        options: { base64: true }
      }, {
        name: 'icon-512-maskable.png',
        data: await prepareIcon(await makeIcon(svgMaskable, 512, false, color, false)),
        options: { base64: true }
      }, {
        name: 'manifest.webmanifest',
        data: `{
          "icons": [{
            "src": "./icons/icon-192-maskable.png",
            "sizes": "192x192",
            "type": "image/png",
            "purpose": "maskable"
          }, {
            "src": "./icons/icon-192.png",
            "sizes": "192x192",
            "type": "image/png"
          }, {
            "src": "./icons/icon-512-maskable.png",
            "sizes": "512x512",
            "type": "image/png",
            "purpose": "maskable"
          }, {
            "src": "./icons/icon-512.png",
            "sizes": "512x512",
            "type": "image/png"
          }, {
            "src": "./icons/icon-maskable.svg",
            "type": "image/svg",
            "purpose": "maskable"
          }]
        }`,
        options: {}
      }
    ];

    const zip = await zipIcons(files);
    downloadFile(`icons-${app}.zip`, zip);
  });
}



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