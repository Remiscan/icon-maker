export async function zipIcons(files = []) {
  const zip = new JSZip();
  for (const file of files) {
    zip.file(file.name, file.data.replace('data:image/png;base64,', ''), file.options);
  }
  const zipFile = zip.generateAsync({ type: 'blob' });
  return zipFile;
}



export function downloadFile(name, blob) {
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');

  a.href = url;
  a.download = name;
  document.body.appendChild(a);

  a.dispatchEvent(
    new MouseEvent('click', { 
      bubbles: true, 
      cancelable: true, 
      view: window 
    })
  );

  document.body.removeChild(a);
}