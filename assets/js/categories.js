// Categories Page Interactivity
// All filtering and sorting is backend-driven; no JS needed for search, sort, or filter buttons.

// Custom dropdown for sort by (restores previous interactive style)
document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('sortDropdown');
    var options = document.getElementById('sortOptions');
    var selected = document.getElementById('selectedSort');
    var input = document.getElementById('sortInput');
    var form = document.getElementById('sortForm');
    if (dropdown && options && selected && input && form) {
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            options.style.display = (options.style.display === 'block') ? 'none' : 'block';
            dropdown.classList.toggle('open');
        });
        options.querySelectorAll('li').forEach(function(option) {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                selected.textContent = option.textContent;
                input.value = option.getAttribute('data-value');
                options.style.display = 'none';
                dropdown.classList.remove('open');
                form.submit();
            });
        });
        document.addEventListener('click', function() {
            options.style.display = 'none';
            dropdown.classList.remove('open');
        });
        dropdown.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                options.style.display = (options.style.display === 'block') ? 'none' : 'block';
                dropdown.classList.toggle('open');
            }
        });
    }
}); 