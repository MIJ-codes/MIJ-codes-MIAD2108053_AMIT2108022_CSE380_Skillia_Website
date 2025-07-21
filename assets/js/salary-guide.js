// assets/js/salary-guide.js

document.addEventListener('DOMContentLoaded', function() {
    // Page-specific JS for Salary Guide goes here
    // Custom dropdown logic (copied from post-job.php)
    (function() {
        let openDropdown = null;
        let originalParent = null;
        let originalNextSibling = null;
        let portalMenu = null;

        function closeDropdown() {
            if (openDropdown && portalMenu) {
                // Move menu back to original parent
                if (originalParent && portalMenu) {
                    originalParent.insertBefore(portalMenu, originalNextSibling);
                    portalMenu.style.position = '';
                    portalMenu.style.left = '';
                    portalMenu.style.top = '';
                    portalMenu.style.width = '';
                    portalMenu.style.zIndex = '';
                    portalMenu.style.display = 'none';
                }
                openDropdown.classList.remove('open');
                openDropdown = null;
                portalMenu = null;
                originalParent = null;
                originalNextSibling = null;
            }
        }

        document.querySelectorAll('.custom-category-dropdown').forEach(function(dropdown) {
            const selected = dropdown.querySelector('.selected-category');
            const menu = dropdown.querySelector('.category-options');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            // Set initial selected label
            const initial = menu.querySelector('li.selected');
            if (initial) selected.textContent = initial.textContent;
            // Open/close dropdown
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                if (openDropdown === dropdown) {
                    closeDropdown();
                    return;
                }
                closeDropdown();
                openDropdown = dropdown;
                portalMenu = menu;
                originalParent = menu.parentNode;
                originalNextSibling = menu.nextSibling;
                // Move menu to body
                document.body.appendChild(menu);
                // Position menu below dropdown
                const rect = dropdown.getBoundingClientRect();
                menu.style.position = 'absolute';
                menu.style.left = rect.left + 'px';
                menu.style.top = (rect.bottom + window.scrollY) + 'px';
                menu.style.width = rect.width + 'px';
                menu.style.zIndex = 9999;
                menu.style.display = 'block';
                dropdown.classList.add('open');
            });
            // Option select
            menu.querySelectorAll('li').forEach(function(option) {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selected.textContent = option.textContent;
                    hiddenInput.value = option.getAttribute('data-value');
                    menu.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
                    option.classList.add('selected');
                    closeDropdown();
                });
            });
        });
        // Close on outside click
        document.addEventListener('click', function() {
            closeDropdown();
        });
        // Close on resize only (not on scroll)
        window.addEventListener('resize', closeDropdown);
    })();
}); 