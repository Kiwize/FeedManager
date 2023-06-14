function showNotification(message, type) {
    const notificationContainer = document.getElementById('notification-container');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = document.createElement('div');
    notification.classList.add('alert', alertClass, 'notification', 'slide-in', 'mx-auto', 'w-50', 'mt-4', 'text-center');
    notification.textContent = message;
    notificationContainer.appendChild(notification);

    setTimeout(function() {
        notification.classList.remove('slide-in');
        notification.classList.add('slide-out');

        setTimeout(function() {
            notificationContainer.removeChild(notification);
        }, 500);
    }, 5000);
}

function showSuccessNotification(message) {
    showNotification(message, 'success');
}

function showErrorNotification(message) {
    var errors = Object.values(message.error);

    showNotification(errors, 'error');
}