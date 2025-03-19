// notification.js
document.addEventListener('DOMContentLoaded', function() {
    const showNotificationButton = document.getElementById('showNotification');
    const notificationContainer = document.getElementById('notificationContainer');
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    const closeNotificationButton = document.getElementById('closeNotification');

    showNotificationButton.addEventListener('click', function() {
        showNotification('This is a sample notification message.');
    });

    closeNotificationButton.addEventListener('click', function() {
        hideNotification();
    });

    function showNotification(message) {
        notificationMessage.textContent = message;
        notification.classList.remove('hidden');
    }

    function hideNotification() {
        notification.classList.add('hidden');
    }
});