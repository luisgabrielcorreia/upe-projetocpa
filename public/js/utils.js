function mapJoin(arr,f) {
    return arr.map(f).join('');
 }
 
 
 function createDialog(elem) {
   let comentario = elem.explicacao && elem.explicacao.length > 0 ? `<br>${elem.explicacao}<br>` : "";
   switch (elem.type) {
       case "Section":
           return `<h2>${elem.label}</h2>`;
       case "Texto":
           return `
               <div class="Frame FormItem Texto">
                   <div class="Titulo Texto">${elem.label}</div>
                   ${comentario}
                   <input class="inputData Texto" id="${elem.qid}">
               </div>
           `;
       case "MEscolha":
           return `
               <div class="Frame FormItem MEscolha">
                   <div class="Titulo MEscolha">${elem.label}</div>
                   ${comentario}
                   <div class="inputData iMEscolha">
                       ${mapJoin(elem.opcoes, (op, pos) => `
                           <input type="checkbox" id="${elem.qid}_${pos}" name="${elem.qid}[]" value="${op}">
                           <label for="${elem.qid}_${pos}">${op}</label><br>
                       `)}
                   </div>
               </div>
           `;
       case "Escolha1":
           return `
               <div class="Frame FormItem Escolha1">
                   <div class="Titulo Escolha1">${elem.label}</div>
                   ${comentario}
                   <select class="inputData Escolha1" id="${elem.qid}">
                       ${mapJoin(elem.opcoes, op => `<option value="${op}">${op}</option>`)}
                   </select>
               </div>
           `;
       case "Escolha2":
           return `
               <div class="Frame FormItem Escolha2">
                   <div class="Titulo Escolha2">${elem.label}</div>
                   ${comentario}
                   <div class="inputData iEscolha2">
                       ${mapJoin(elem.opcoes, (op, pos) => `
                           <input type="radio" id="${elem.qid}_${pos}" name="${elem.qid}" value="${op}">
                           <label for="${elem.qid}_${pos}">${op}</label><br>
                       `)}
                   </div>
               </div>
           `;
       case "Grade":
           return `
               <div class="Frame FormItem Grade">
                   <div class="Titulo Grade">${elem.label}</div>
                   ${comentario}
                   <table class="inputData iGrade">
                       <thead>
                           <tr><th></th>${mapJoin(elem.opcoes, op => `<th>${op}</th>`)}</tr>
                       </thead>
                       <tbody>
                           ${mapJoin(elem.questoes, (q, pos_q) => `
                               <tr>
                                   <th>${q}</th>
                                   ${mapJoin(elem.opcoes, (op, pos_op) => `
                                       <td>
                                           <input type="radio" id="${elem.qid}_${pos_q}_${pos_op}" name="${elem.qid}_${pos_q}" value="${op}">
                                       </td>
                                   `)}
                               </tr>
                           `)}
                       </tbody>
                   </table>
               </div>
           `;
   }
}
  
 function createBox(dataElem) {
   var div = document.createElement('div');
   div.elemento = dataElem
   div.className = "ListItem deletavel";
   div.innerHTML = `
      <span class="glyphicon glyphicon-move" aria-hidden="true">
      <img src="system-menu.png" width="16">
      </span> 
      <span class="label">${dataElem.qid}</span> <!-- Adiciona o qid como label -->
      <span style="position:relative;float:right;"><button onclick="edit(this)">Edit</button><button onclick="destroy(this)"><img src="close.png" width="16"></button></span>
      <div class="contents glyphicon-move">
      </div>
   `;
   return div;
}
 
 