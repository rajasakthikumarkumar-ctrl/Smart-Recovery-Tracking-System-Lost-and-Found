
document.addEventListener('DOMContentLoaded', function(){ const form = document.getElementById('signupForm'); if(!form) return; form.addEventListener('submit', function(e){ const p = document.getElementById('pass')||{}; const cp = document.getElementById('confirmPass')||{}; if(p.value && cp.value && p.value !== cp.value){ e.preventDefault(); alert('Passwords do not match'); } }); });
