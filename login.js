
document.addEventListener('DOMContentLoaded', function(){ const form = document.getElementById('loginForm'); if(!form) return; form.addEventListener('submit', function(e){ const reg = document.getElementById('reg').value.trim(); const pass = document.getElementById('pass').value.trim(); if(!reg||!pass){ e.preventDefault(); alert('Please fill both fields'); } }); });
