<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_token']) || empty($_SESSION['user_token'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT user_type, full_name FROM users WHERE token ='{$_SESSION['user_token']}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
    
    if ($userinfo['user_type'] != 'admin') {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8">
    <title>Editor de Questionários da UPE</title>
    <link rel="stylesheet" href="css/estiloeditor.css">
    <link rel="stylesheet" href="css/estiloeditor2.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>

<body>

<dialog id="EditDialog" style="width:60%;height:60%;">
  <CENTER><H2>Propriedades da Pergunta</H2></CENTER>
  <div class="props">
  ID da Questão: <input class="propField" name="qid" value="" disabled><p>
  </div>

  <div>
  <center><button onclick="okEdit()">OK</button> <button onclick="cancelEdit()">Cancelar</button></center>
  <div>
</dialog>

<H1>Editor de Questionários: <span id="QName"></span></H1>

<div>
<ul class="menu">
   <li> <a href="#"> Questionários </a>
      <ul>
        <li> <a href="#" onclick="newProject()"> Novo Questionário</a>
        <li> <a href="#" onclick="loadProject()"> Carregar Questionário</a>
        <li> <a href="#" onclick="saveProject()"> Salvar Cópia do Questionário</a>
      </ul>
      <li> <a class="btn btn-primary" href="user_dashboard.php">Voltar para a Dashboard</a>
</ul>

</div>

<div id="content"></div>
<div class="container">
</div>
<center>
    <button onclick="nova({type:'Section', questionVar:'secao', label: '', formulario:''})">Nova Seção</button>
    <button onclick="nova({type:'Texto', label: 'Conteúdo da Pergunta', questionVar: 'QDiscursiva' })">Nova Questão de Texto</button>
    <button onclick="nova({type:'MEscolha', label: 'Conteúdo da Pergunta', questionVar: 'QMultiplaEscolha', opcoes: [] })">Nova Questão de Múltipla Escolha</button>
    <button onclick="nova({type:'Escolha2', label: 'Conteúdo da Pergunta', questionVar: 'QEscolhaUnica', opcoes: [] })">Nova Questão de Escolha Única</button>
    <button onclick="nova({type:'Escolha1', label: 'Conteúdo da Pergunta', questionVar: 'QEscolhaUnicaCombobox', opcoes: [] })">Nova Questão de Escolha Única com Combobox</button>
    <button onclick="nova({type:'Grade', label: 'Conteúdo da Pergunta', questionVar: 'QGrade', questoes:[], opcoes: [] })">Nova Questão de Grade</button>
</center>

<script src="https://cdn.jsdelivr.net/npm/vue@3.3.4/dist/vue.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-draggable-next@2.2.1/dist/vue-draggable-next.global.min.js"></script>
<script src="js/utilsEditor.js"></script> 
<script src="js/script.js"></script>
</body>
</html>
