!function(){!async function(){try{const t="api/tareas?id="+c(),a=await fetch(t),o=await a.json();e=o.tareas,n()}catch(e){console.log(e)}}();let e=[],t=[];document.querySelector("#agregar-tarea").addEventListener("click",(function(){o()}));function a(a){const o=a.target.value;t=""!==o?e.filter(e=>e.estado===o):[],n()}function n(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const t=e.filter(e=>"0"===e.estado),a=document.querySelector("#pendientes");0===t.length?a.disabled=!0:a.disabled=!1}(),function(){const t=e.filter(e=>"1"===e.estado),a=document.querySelector("#completadas");0===t.length?a.disabled=!0:a.disabled=!1}();const a=t.length?t:e;if(0===a.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const i={0:"Pendiente",1:"Completa"};a.forEach(t=>{const a=document.createElement("LI");a.dataset.tareaId=t.id,a.classList.add("tarea");const d=document.createElement("P");d.textContent=t.nombre,d.ondblclick=function(){o(editar=!0,{...t})};const s=document.createElement("DIV");s.classList.add("opciones");const l=document.createElement("BUTTON");l.classList.add("estado-tarea"),l.classList.add(""+i[t.estado].toLowerCase()),l.textContent=i[t.estado],l.dataset.estadoTarea=t.estado,l.onclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,r(e)}({...t})};const u=document.createElement("BUTTON");u.classList.add("eliminar-tarea"),u.dataset.idTarea=t.id,u.textContent="Eliminar",u.onclick=function(){!function(t){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(a=>{a.isConfirmed&&async function(t){const{estado:a,id:o,nombre:r}=t,i=new FormData;i.append("id",o),i.append("nombre",r),i.append("estado",a),i.append("proyecto_id",c());try{const a="http://localhost:3000/api/tarea/eliminar",o=await fetch(a,{method:"POST",body:i}),r=await o.json();r.resultado&&(Swal.fire("Eliminado!",r.mensaje,"success"),e=e.filter(e=>e.id!==t.id),n())}catch(e){console.log(e)}}(t)})}({...t})},s.appendChild(l),s.appendChild(u),a.appendChild(d),a.appendChild(s);document.querySelector("#listado-tareas").appendChild(a)})}function o(t=!1,a={}){const o=document.createElement("DIV");o.classList.add("modal"),o.innerHTML=`\n        <form class="formulario nueva-tarea">\n            <legend>${a.nombre?"Editar Tarea":"Añade una nueva tarea"}</legend>\n            <div class="campo">\n                <label>Tarea</label>\n                <input \n                    type="text"\n                    name="tarea"\n                    placeholder="${a.nombre?"Editar Tarea":"Añade una nueva tarea"}"\n                    id="tarea"\n                    value="${a.nombre?a.nombre:""}"\n                >\n            </div>\n            <div class="opciones">\n                <input type="submit" class="submit-nueva-tarea" value="${a.nombre?"Guardar Cambios":"Añadir tarea"}">\n                <button type="button" class="cerrar-modal">Cancelar</button>\n            </div>\n        </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),o.addEventListener("click",(function(i){if(i.preventDefault(),i.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{o.remove()},400)}if(i.target.classList.contains("submit-nueva-tarea")){const o=document.querySelector("#tarea").value.trim();if(""===o)return void function(e,t,a){const n=document.querySelector(".alertas");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alertas",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},2e3)}("El nombre de la tarea es Obligatorio","error",document.querySelector(".formulario legend"));t?(a.nombre=o,r(a)):async function(t){const a=new FormData;a.append("nombre",t),a.append("proyecto_id",c());try{const o="http://localhost:3000/api/tarea",r=await fetch(o,{method:"POST",body:a}),c=await r.json();if(Swal.fire("Agregando tarea",c.mensaje,"success"),"exito"===c.tipo){const a=document.querySelector(".modal");setTimeout(()=>{a.remove()},0);const o={id:String(c.id),nombre:t,estado:"0",proyecto_id:c.proyecto_id};e=[...e,o],n()}}catch(e){console.log(e)}}(o)}})),document.querySelector(".dashboard").appendChild(o)}async function r(t){const{estado:a,id:o,nombre:r,proyecto_id:i}=t,d=new FormData;d.append("id",o),d.append("nombre",r),d.append("estado",a),d.append("proyecto_id",c());try{const t="http://localhost:3000/api/tarea/actualizar",c=await fetch(t,{method:"POST",body:d}),i=await c.json();if("exito"===i.respuesta.tipo){Swal.fire("Actualizando tarea",i.respuesta,"success");const t=document.querySelector(".modal");t&&t.remove(),e=e.map(e=>(e.id===o&&(e.estado=a,e.nombre=r),e)),n()}}catch(e){console.log("error")}}function c(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelectorAll('#filtros input[type="radio"]').forEach(e=>{e.addEventListener("input",a)})}();