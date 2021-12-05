// Génère une icône
export async function makeIcon(
  svgData,
  size, 
  circle = true, 
  bgcolor = '#000', 
  shadow = false
) {
  const canvas = document.createElement('canvas');
  canvas.width = size;
  canvas.height = size;
  canvas.style.setProperty('image-rendering', 'optimizeQuality', null);

  const ctx = canvas.getContext("2d");
  const img = new Image();  

  return new Promise(resolve => {
    img.addEventListener('load', () => {
      ctx.filter = 'drop-shadow(0px 3px 1px rgba(0, 0, 0, .2)) drop-shadow(0px 2px 2px rgba(0, 0, 0, .14)) drop-shadow(0px 1px 5px rgba(0, 0, 0, .12))'; // ça anti-aliase quand y a pas d'ombre !!

      const centre = size / 2;
      const marge = size / 24;
      const rayon = centre - marge;

      if (circle) {
        ctx.beginPath();
        ctx.arc(centre, centre, rayon, 0, Math.PI * 2);

        // Ombre
        if (shadow) {
          ctx.fillStyle = bgcolor+'80' || '#000';
          ctx.fill();
          ctx.save();
        }

        ctx.clip();
        const taille = size - 2 * marge;
        ctx.drawImage(img, marge, marge, taille, taille); 

        if (shadow) ctx.restore();
      } else {
        ctx.drawImage(img, 0, 0, size, size);
      }

      return resolve(canvas);
    });

    img.src = svgData;
  });
}