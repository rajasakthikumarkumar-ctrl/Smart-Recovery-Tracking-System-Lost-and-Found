
document.getElementById('uploadForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const form = e.target;
  const fd = new FormData(form);
  try{
    const res = await fetch('upload_item.php', { method: 'POST', body: fd });
    const text = await res.text();
    if(text.includes('success')){
      document.getElementById('successPopup').style.display = 'flex';
    } else alert('Upload error: ' + text);
  } catch(err){ alert('Upload failed: ' + err); }
});
function goHome(){ window.location.href='feed.html'; }
