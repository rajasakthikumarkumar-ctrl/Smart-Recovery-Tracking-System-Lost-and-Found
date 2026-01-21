
const params = new URLSearchParams(location.search);
const itemId = params.get('item_id') || 0;
const currentUser = localStorage.getItem('currentUser') || 'Guest';
const chatArea = document.getElementById('chatArea');
const hdr = document.getElementById('chatHeader');
hdr && (hdr.innerText = 'Chat - Item #' + itemId);
async function fetchMsgs(){ if(!itemId) return; try{ const res = await fetch('fetch_messages.php?item_id='+itemId); const msgs = await res.json(); chatArea.innerHTML = msgs.map(m=>`<div><strong>${m.sender}:</strong> ${m.message} <div style="font-size:0.8rem;color:#666">${m.created_at}</div></div>`).join(''); chatArea.scrollTop = chatArea.scrollHeight; }catch(e){console.error(e);} }
setInterval(fetchMsgs,2000); fetchMsgs();
document.getElementById('sendBtn').addEventListener('click', async ()=>{
  const txt = document.getElementById('chatMessage').value.trim();
  if(!txt) return;
  await fetch('send_message.php', { method:'POST', body: new URLSearchParams({ item_id: itemId, user: currentUser, message: txt }) });
  document.getElementById('chatMessage').value='';
  fetchMsgs();
});
