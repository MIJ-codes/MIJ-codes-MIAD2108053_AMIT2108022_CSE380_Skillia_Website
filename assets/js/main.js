// Skillia Main JS

document.addEventListener('DOMContentLoaded', function() {
    // Dropdown menu logic
    document.querySelectorAll('.dropdown').forEach(function(dropdown) {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        if (trigger) {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('active');
            });
        }
    });
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown.active').forEach(function(dropdown) {
            dropdown.classList.remove('active');
        });
    });
    // Add more animation or interactivity scripts here
});
// Ensure this file is loaded on all pages for header/footer interactivity 