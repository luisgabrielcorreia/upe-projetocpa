function mapJoin(arr, f) {
    return arr.map(f).join('');
}

function createDialog(elem) {
    let comentario = elem.explicacao ? `<div class="Explicacao"><i>${elem.explicacao}</i></div>` : "";
    let condicao = elem.condicao ? `data-condicao="${elem.condicao}"` : 'data-condicao="sempre"';
    switch (elem.type) {
        case "Section":
            return `<div class="Secao_${elem.qid}" ${condicao}>
                        <h2>${elem.label}</h2>
                        ${comentario}
                    </div>`;
        case "Texto":
            return `<div class="Frame FormItem Texto" ${condicao}>
                        <div class="Titulo Texto">${elem.label}</div>
                        ${comentario}
                        <input class="inputData Texto" fid="${elem.var}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}">
                    </div>`;
        case "MEscolha":
            return `<div class="Frame FormItem MEscolha" ${condicao}>
                <div class="Titulo MEscolha">${elem.label}</div>
                ${comentario}
                <div class="inputData iMEscolha" fid="${elem.var}" data-var="${elem.qid}_${elem.questionVar}">
                    ${elem.opcoes.map((op, pos) => 
                        `<input type="checkbox" id="${elem.qid}_${pos}" value="${op}" name="${elem.qid}_${elem.questionVar}[]" data-var="${elem.qid}_${elem.questionVar}">
                        <label for="${elem.qid}_${pos}">${op}</label><br>`).join('')}
                </div>
            </div>`;
        case "Escolha1":
            return `<div class="Frame FormItem Escolha1" ${condicao}>
                <div class="Titulo Escolha1">${elem.label}</div>
                ${comentario}
                <select class="inputData Escolha1" fid="${elem.var}" name="${elem.qid}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}">
                    ${elem.opcoes.map(op => `<option value="${op}">${op}</option>`).join('')}
                </select>
            </div>`;
        case "Escolha2":
            return `<div class="Frame FormItem MEscolha" ${condicao}>
                <div class="Titulo MEscolha">${elem.label}</div>
                ${comentario}
                <div class="inputData iMEscolha" fid="${elem.var}" data-var="${elem.qid}_${elem.questionVar}">
                    ${elem.opcoes.map((op, pos) => 
                        `<input type="radio" id="${elem.qid}_${pos}" name="${elem.qid}_${elem.questionVar}" value="${op}" data-var="${elem.qid}_${elem.questionVar}">
                        <label for="${elem.qid}_${pos}">${op}</label><br>`).join('')}
                </div>
            </div>`;
        case 'Grade':
            return `<div class="Frame FormItem Grade" ${condicao}>
                <div class="Titulo Grade">${elem.label}</div>
                <table border="" class="inputData iGrade" fid="${elem.var}" id="${elem.qid}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}">
                    <tbody>
                        <tr><td></td>${elem.opcoes.map(opcao => `<th>${opcao}</th>`).join('')}</tr>
                        ${elem.questoes.map((questao, indexQ) => 
                            `<tr><th>${questao}</th>
                                <td><input type="radio" id="${elem.qid}_${indexQ}" name="${elem.qid}_${indexQ}_${elem.questionVar}" data-var="${elem.qid}_${elem.questionVar}"></td>
                                ${elem.opcoes.slice(1).map(opcao => 
                                    `<td>
                                        <input type="radio" id="${elem.qid}_${indexQ}_${opcao}" name="${elem.qid}_${indexQ}_${elem.questionVar}" value="${opcao}" data-var="${elem.qid}_${elem.questionVar}">
                                        <label for="${elem.qid}_${indexQ}_${opcao}">${opcao}</label>
                                    </td>`).join('')}
                            </tr>`).join('')}
                    </tbody>
                </table>
            </div>`;
        default:
            return `<p>Tipo de pergunta não suportado: ${elem.type}</p>`;
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
        <spam class="label"></spam>
        <span style="position:relative;float:right;"><button onclick="edit(this)">Edit</button><button onclick="destroy(this)"><img src="close.png" width="16"></button></span>
        <div class="contents glyphicon-move">
    </div>
    `;
    return div;
}
