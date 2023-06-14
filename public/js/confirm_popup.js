function confirmPopup(_message = "Êtes-vous sûr de vouloir continuer ?", _action = function() { hideLoadingScreen();}) {
    $('#confirm_entitle').html(_message);
    showConfirmationPopup();

    $('#validate').on("click", _action);
}

function showConfirmationPopup() {
    $("#confirmation-popup").css("display", "flex")
}

function closeConfirmationPopup() {
    $("#confirmation-popup").css("display", "none");
}