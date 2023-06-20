function showNotification(message, type) {
    var errmsg = " ";
    if(typeof(message) === "object") {
        Object.values(message.error).forEach((err) => {
            errmsg += err[0] + "<br>";
        });
    } else {
        errmsg = message;
    }


    const notificationContainer = document.getElementById('notification-container');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = document.createElement('div');
    notification.classList.add('alert', alertClass, 'notification', 'slide-in', 'mx-auto', 'w-50', 'mt-4', 'text-center');
    notification.textContent = errmsg;
    notificationContainer.appendChild(notification);

    setTimeout(function() {
        notification.classList.remove('slide-in');
        notification.classList.add('slide-out');

        setTimeout(function() {
            notificationContainer.removeChild(notification);
        }, 500);
    }, 5000);
}
