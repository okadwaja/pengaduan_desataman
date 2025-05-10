document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggleTop');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            this.blur(); // Hilangkan fokus setelah klik
        });
    }
});
