function openPopup(idResiduo) {
    const popup = document.getElementById('popup-delete');
    popup.style.display = 'flex';

    const confirmDelete = document.getElementById('confirm-delete');
    confirmDelete.href = `deletarResiduo.php?idResiduo=${idResiduo}`;
}

function closePopup() {
    const popup = document.getElementById('popup-delete');
    popup.style.display = 'none';
}

function exibirPopupErro(mensagem) {
    // Exibe o pop-up
    const popup = document.getElementById('error-popup');
    const messageElement = document.getElementById('error-message');

    // Preenche a mensagem do erro no pop-up
    messageElement.textContent = mensagem;

    // Exibe o pop-up
    popup.style.display = 'flex';
}

// Função para fechar o pop-up
function fecharPopup() {
    const popup = document.getElementById('error-popup');
    popup.style.display = 'none';
}