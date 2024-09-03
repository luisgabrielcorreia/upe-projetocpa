document.addEventListener('DOMContentLoaded', function() {
    loadForm();
});

function loadForm() {
    const urlParams = new URLSearchParams(window.location.search);
    const fileName = urlParams.get('formulario');

    if (fileName) {
        fetch(`../user_js/${fileName}`)
            .then(response => response.json())
            .then(data => {
                const formularioContainer = document.getElementById('formularioContainer');
                formularioContainer.innerHTML = ''; 

                data.forEach(elem => {
                    const dialogHtml = createDialog(elem); 
                    formularioContainer.innerHTML += dialogHtml;
                });
            })
            .catch(error => {
                console.error('Erro ao carregar o formulário:', error);
            });
    } else {
        console.error('Nome do arquivo do formulário não fornecido na URL.');
    }
}
