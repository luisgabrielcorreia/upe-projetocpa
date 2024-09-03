var qidCounter = 1;

function nova(dado) {
    dado.qid = "qid_" + qidCounter++;
    dado.condicao = "sempre";
    var novo = createBox(dado);
    edit(novo);
}

var previous = [];
var next = [];

function step() {
    var atual = save();
    previous.push(atual);
}

function undo() {
    if (previous.length == 0) return;
    var atual = save();
    next.push(atual);
    atual = previous.pop();
    load(atual);
}

function redo() {
    if (next.length == 0) return;
    var atual = save();
    previous.push(atual);
    atual = next.pop();
    load(atual);
}

var editingTable = `
    <table border>
    <tr><th>Valor<th>Texto</tr>
    <tr class="deletavel"><td><input class="varname"><td><input><td><button onclick="destroy(this)"> Destroy </button></tr>
    <tr><td><button onclick="insertTable(this, '<tr></tr>')">Insert</button></tr>
    </table>
`;

var container = document.getElementsByClassName("container")[0];

function updateListItens() {
    var elems = document.getElementsByClassName("ListItem");
    for (var pos = 0; pos < elems.length; pos++) {
        var elem = elems[pos];
        var data = elem.elemento;
        elem.getElementsByClassName('label')[0].innerHTML = data.var;
        elem.getElementsByClassName('contents')[0].innerHTML = createDialog(data);
    }
}

function save() {
    var data = [];
    var nodes = container.childNodes;
    nodes.forEach(node => data.push(node.elemento));
    return JSON.stringify(data, null, 4);
}

function load(src) {
    var data = JSON.parse(src);
    container.innerHTML = "";
    data.forEach(item => container.appendChild(createBox(item)));
    updateListItens();
}

function destroy(elem) {
    while (!elem.classList.contains("deletavel")) {
        elem = elem.parentElement;
        if (elem == null) return;
    }
    step();
    elem.remove();
}

var editingElement;
var editingData;

function edit(elem) {
    while (!elem.classList.contains("ListItem")) {
        elem = elem.parentElement;
        if (elem == null) return;
    }
    editingElement = elem;
    editingData = elem.elemento;
    var propsForms = "";
    propsForms += `ID da Questão: <input class="propField" name="qid" value="${editingData.qid}" disabled><p>`;
    if (editingData.type != "Section")
        propsForms += `Nome da Questão: <input class="propField"  name="var" value="${editingData.var}"><p>`;
    else
        propsForms += `Incluir Formulário Externo: <input class="propField"  name="externo" value="${editingData.externo}"><p>`;
    propsForms += `Condição de Exibição: <input  class="propField"  name="condicao" value="${editingData.condicao ?? ""}"><p>`;
    propsForms += `Texto da Questão: <input  class="propField"  name="label" value="${editingData.label}"><p>`;
    propsForms += `Texto Explicativo: <input  class="propField"  name="explicacao" value="${editingData.explicacao ?? ""}"><p>`;

    switch (editingData.type) {
        case "MEscolha":
        case "Escolha1":
        case "Escolha2":
            propsForms += `Tipo da Escolha: <select class="propField" name="tipo" value="${editingData.type}">
        <option value="Escolha2" >Uma Escolha com Lista</option>
        <option value="Escolha1" >Uma Escolha com Lista com Combobox</option>
        <option value="MEscolha" >Lista Multipla escolha</option>
        </select><p>
        `;
            propsForms += `Opções:<p><textArea class="propField" name="opcoes" cols="80" rows="10">${editingData.opcoes.join("\n")}</textarea>`;
            break;
        case "Grade":
            propsForms += `Opções:<p><textArea class="propField"  name="opcoes"  cols="60" rows="8">${editingData.opcoes.join("\n")}</textarea><p>`;
            propsForms += `Questoes:<p><textArea  class="propField"  name="questoes"  cols="60" rows="8">${editingData.questoes.join("\n")}</textarea>`;
            break;
    }
    dialog = document.getElementById("EditDialog");
    dialog.getElementsByClassName('props')[0].innerHTML = propsForms;
    dialog.showModal();
}

function okEdit() {
    step();
    dialog = document.getElementById("EditDialog");
    fields = dialog.getElementsByClassName("propField");
    for (var c = 0; c < fields.length; c++) {
        switch (fields[c].name) {
            case "opcoes":
                editingData.opcoes = fields[c].value.split("\n").filter(x => x.length > 0);
                break;
            case "questoes":
                editingData.questoes = fields[c].value.split("\n").filter(x => x.length > 0);
                break;
            case "var":
                editingData.var = fields[c].value;
                break;
            case "label":
                editingData.label = fields[c].value;
                break;
            case "externo":
                editingData.externo = fields[c].value;
                break;
            case "condicao":
                editingData.condicao = fields[c].value;
                break;
            case "explicacao":
                editingData.explicacao = fields[c].value;
                break;
            case "tipo":
                editingData.type = fields[c].value;
                break;
        }
    }
    if (editingElement.parentNode == null)
        container.appendChild(editingElement);
    editingData = null;
    editingElement = null;
    dialog.close();
    updateListItens();
}

function cancelEdit() {
    dialog = document.getElementById("EditDialog");
    dialog.close();
    editingData = null;
    editingElement = null;
}

document.addEventListener('DOMContentLoaded', (event) => {
    var el = document.getElementsByClassName('container')[0];
    new Sortable(el, {
        handle: '.glyphicon-move',
        animation: 150,
        onEnd: function (evt) {
            updateListItens();
        }
    });

    // Adicionar listener para condições
    var inputs = document.querySelectorAll('.inputData');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            checkConditions();
        });
    });

    checkConditions(); // Inicializa com as condições verificadas
});

function $(id) {
    return document.getElementById(id);
}

var QName = "";
function setName(n) {
    QName = n;
    $("QName").innerText = QName;
}

function newProject() {
    nome = window.prompt("Qual o nome do projeto?");
    if (nome == "" || nome == null) return;
    setName(nome + ".js");
    load("[]");
}

function loadProject() {
    var element = document.createElement('input');
    element.setAttribute('type', 'file');
    element.style.display = 'none';

    element.onchange = async (ev) => {
        console.log("Arquivo selecionado", ev.target.files[0]);
        setName(ev.target.files[0].name);
        var text = await ev.target.files[0].text();
        load(text);
        document.body.removeChild(element);
    }
    document.body.appendChild(element);
    element.click();
}

function saveProject() {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(save()));
    element.setAttribute('download', QName);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}
