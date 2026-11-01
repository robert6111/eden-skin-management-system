document.addEventListener('click',e=>{const t=e.target.closest('[data-toggle-menu]');if(t)document.querySelector('#sidebar')?.classList.toggle('open');const m=e.target.closest('[data-modal-open]');if(m)document.querySelector(m.dataset.modalOpen)?.classList.add('open');const c=e.target.closest('[data-modal-close]');if(c)c.closest('.modal')?.classList.remove('open');const d=e.target.closest('[data-confirm]');if(d&&!confirm(d.dataset.confirm||'Are you sure?'))e.preventDefault();});
document.querySelectorAll('[data-autosubmit]').forEach(x=>x.addEventListener('change',()=>x.form.submit()));
window.api=async(path,data={})=>{const r=await fetch((window.APP_BASE||'')+'/'+path.replace(/^\//,''),{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-Token':window.CSRF},body:JSON.stringify(data)});const j=await r.json().catch(()=>({ok:false,message:'Invalid server response'}));if(!r.ok||j.ok===false)throw new Error(j.message||'Request failed');return j;};

// Prevent accidental double-submission of POST forms.
document.querySelectorAll('form[method="post"], form[method="POST"]').forEach(form=>{
  form.addEventListener('submit', e=>{
    if(form.dataset.submitted==='1'){
      e.preventDefault();
      return false;
    }
    if(typeof form.checkValidity==='function' && !form.checkValidity()) return;
    form.dataset.submitted='1';
    form.querySelectorAll('button[type="submit"],button:not([type]),input[type="submit"]').forEach(btn=>{
      btn.dataset.originalText=btn.innerText||btn.value||'';
      btn.disabled=true;
      if(btn.tagName==='BUTTON') btn.innerText='Please wait...';
    });
  });
});
