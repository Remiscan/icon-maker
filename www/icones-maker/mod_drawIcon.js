// Dessine une icône à partir d'un svg encodé en string svgData
function svgToPng(
  svgData,
  size, 
  circle = true, 
  bgcolor = '#000', 
  app = false, 
  conteneur = document.querySelector('.liste-canvas')
) {
  return new Promise(resolve => {
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    canvas.style.setProperty('image-rendering', 'optimizeQuality', null);
    conteneur.appendChild(canvas); // je peux enlever ça quand tout marchera bien
    const ctx = canvas.getContext("2d");
    const DOMURL = self.URL || self.webkitURL || self;
    const img = new Image();
    
    const svg64 = btoa(new XMLSerializer().serializeToString(document.createRange().createContextualFragment(svgData)));
    const b64Start = 'data:image/svg+xml;base64,';
    img.onload = () => {
      ctx.filter = 'drop-shadow(0px 3px 1px rgba(0, 0, 0, .2)) drop-shadow(0px 2px 2px rgba(0, 0, 0, .14)) drop-shadow(0px 1px 5px rgba(0, 0, 0, .12))'; // ça anti-aliase quand y a pas d'ombre !!

      const centre = size / 2;
      const marge = size / 24;
      const rayon = centre - marge;

      if (circle)
      {
        ctx.beginPath();
        ctx.arc(centre, centre, rayon, 0, Math.PI * 2);

        // Ombre
        if (app)
        {
          ctx.fillStyle = bgcolor+'80' || '#000';
          console.log(ctx.fillStyle);
          ctx.fill();

          ctx.save();
        }

        ctx.clip();
        const taille = size - 2 * marge;
        ctx.drawImage(img, marge, marge, taille, taille); 

        if (app) ctx.restore();
      }
      else
        ctx.drawImage(img, 0, 0, size, size);

      return resolve(canvas);
    };
    img.src = b64Start + svg64;
  });
}



// Récupère le svg en fond d'un conteneur et l'envoie à svgToPng
export function drawIcon(
  icon, 
  size, 
  circle = true, 
  bgcolor = '#000', 
  app = false, 
  conteneur = document.querySelector('.liste-canvas')
) {
  let svg = '/' + icon.style.backgroundImage.match(/url\((?:\'|\")([a-z-\.\/]+)(?:\'|\")\)/)[1].replace('.svg', '--' + Date.now() + '.svg');
  return fetch(svg)
  .then(response => {
    if (response.status == 200)
      return response;
    else
      throw '[:(] Erreur ' + response.status + ' lors de la requête';
  })
  .then(response => response.text())
  .then(svgData => svgToPng(svgData, size, circle, bgcolor, app, conteneur));
}



// Télécharge l'icône en PNG affichée dans un canvas
function dlIcon(canvas, filename = 'icon.png') {
  let lien = canvas.toDataURL('image/png');
  lien = lien.replace(/^data:image\/[^;]*/, 'data:application/octet-stream');

  const a = document.createElement('a');
  a.href = lien;
  a.download = filename;
  document.body.appendChild(a);

  const clic = new MouseEvent('click', {
    bubbles: true,
    cancelable: true,
    view: window,
    clientX: 0,
    clientY: 0
  });
  a.dispatchEvent(clic); // Lance le téléchargement de l'image

  a.remove();
}



// Détecte les clics sur un canvas pour télécharger l'icône en fond
export function prepareDl(canvas, filename = 'icon.png') {
  canvas.addEventListener('click', () => dlIcon(canvas, filename));
}