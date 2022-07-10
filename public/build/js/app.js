let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),idCliente(),nombreCliente(),sleccionarFecha(),sleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t="#paso-"+paso;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):2===paso&&(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e="https://guarded-journey-74842.herokuapp.com/",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:n}=e,a=document.createElement("P");a.classList.add("nombre-servicio"),a.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$"+n;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(a),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,n=document.querySelector(`[data-id-servicio="${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!==t),n.classList.remove("seleccionado")):(cita.servicios=[...o,e],n.classList.add("seleccionado"))}function idCliente(){cita.id=document.querySelector("#id").value}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function sleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Fines de semana no abrimos","error",".formulario")):cita.fecha=e.target.value}))}function sleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value,o=t.split(":")[0];o<10||o>18?(e.target.value="",mostrarAlerta("Hora no valida","error",".formulario")):cita.hora=t}))}function mostrarAlerta(e,t,o,n=!0){const a=document.querySelector(".alerta");a&&a.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),n&&setTimeout(()=>{c.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido-resumen"),t=document.querySelector(".alerta");for(;e.firstChild;)e.removeChild(e.firstChild);if(t&&t.remove(),Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos o Servicios","error",".contenido-resumen",!1);const{nombre:o,fecha:n,hora:a,servicios:c}=cita,r=document.createElement("H3");r.textContent="Resumen de Servicios",e.appendChild(r),c.forEach(t=>{const{id:o,precio:n,nombre:a}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=a;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+n,c.appendChild(r),c.appendChild(i),e.appendChild(c)});const i=document.createElement("H3");i.textContent="Resumen de Servicios",e.appendChild(i);const s=document.createElement("P");s.innerHTML="<span>Nombre:</span> "+o;const d=new Date(n),l=d.getMonth(),u=d.getDate()+2,m=d.getFullYear(),p=new Date(Date.UTC(m,l,u)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),v=document.createElement("P");v.innerHTML="<span>Fecha:</span> "+p;const h=document.createElement("P");h.innerHTML="<span>Hora:</span> "+a;const f=document.createElement("BUTTON");f.classList.add("boton"),f.textContent="Reservar Cita",f.onclick=reservarCita,e.appendChild(s),e.appendChild(v),e.appendChild(h),e.appendChild(f)}async function reservarCita(){const{nombre:e,fecha:t,hora:o,servicios:n,id:a}=cita,c=n.map(e=>e.id),r=new FormData;r.append("fecha",t),r.append("hora",o),r.append("usuarioId",a),r.append("servicios",c);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:r});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Agendada",text:"Tu cita fue agendada correctamente!",button:"OK"}).then(()=>{setTimeout(()=>{window.location.reload()},3e3)})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al agendar tu cita!"})}window.location.origin}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));