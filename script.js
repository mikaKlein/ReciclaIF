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