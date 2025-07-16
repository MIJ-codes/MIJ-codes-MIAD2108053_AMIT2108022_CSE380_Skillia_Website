// Job Board Page Interactivity

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.job-board-search-input');
    const jobCards = document.querySelectorAll('.job-card');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            jobCards.forEach(card => {
                const title = card.querySelector('.job-title').textContent.toLowerCase();
                const company = card.querySelector('.job-company-name').textContent.toLowerCase();
                const desc = card.querySelector('.job-desc').textContent.toLowerCase();
                if (
                    title.includes(searchTerm) ||
                    company.includes(searchTerm) ||
                    desc.includes(searchTerm)
                ) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter buttons
    const filterBtns = document.querySelectorAll('.job-board-filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.textContent.trim();
            jobCards.forEach(card => {
                if (filter === 'All Jobs') {
                    card.style.display = '';
                } else if (filter === 'Most Recent') {
                    card.style.display = parseInt(card.getAttribute('data-job-id')) > 1 ? '' : 'none';
                } else if (filter === 'Remote') {
                    card.style.display = card.getAttribute('data-location') === 'remote' ? '' : 'none';
                } else if (filter === 'Full-time') {
                    card.style.display = card.getAttribute('data-type') === 'full-time' ? '' : 'none';
                } else if (filter === 'Freelance') {
                    card.style.display = card.getAttribute('data-type') === 'freelance' ? '' : 'none';
                }
            });
        });
    });

    // Sort select
    const sortSelect = document.querySelector('.job-board-sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const value = this.value;
            const grid = document.querySelector('.job-board-list');
            const cards = Array.from(grid.children);
            let sorted;
            if (value === 'az') {
                sorted = cards.sort((a, b) => a.querySelector('.job-title').textContent.localeCompare(b.querySelector('.job-title').textContent));
            } else if (value === 'salary') {
                sorted = cards.sort((a, b) => {
                    const aSalary = parseInt(a.querySelector('.job-meta').textContent.replace(/[^0-9]/g, ''));
                    const bSalary = parseInt(b.querySelector('.job-meta').textContent.replace(/[^0-9]/g, ''));
                    return bSalary - aSalary;
                });
            } else if (value === 'company') {
                sorted = cards.sort((a, b) => a.querySelector('.job-company-name').textContent.localeCompare(b.querySelector('.job-company-name').textContent));
            } else if (value === 'newest') {
                sorted = cards.sort((a, b) => parseInt(b.getAttribute('data-job-id')) - parseInt(a.getAttribute('data-job-id')));
            }
            sorted.forEach(card => grid.appendChild(card));
        });
    }

    // Dropdown filters (future backend integration)
    const dropdownFilters = document.querySelectorAll('.job-board-filter');
    dropdownFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            // Placeholder: In future, filter jobs based on backend data
        });
    });

    // Load More button (future backend integration)
    const loadMoreBtn = document.querySelector('.job-board-load-more');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.textContent = 'Loading...';
            this.disabled = true;
            setTimeout(() => {
                this.textContent = 'Load More Jobs';
                this.disabled = false;
                // Placeholder: In future, load more jobs from backend
            }, 1500);
        });
    }
});

// Custom Dropdowns for Job Board Filters

document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.custom-dropdown');
    let openDropdown = null;

    // Store selected filter values
    const filterState = {
        location: '',
        category: '',
        type: '',
        experience: '',
        sort: 'newest'
    };

    const jobCards = document.querySelectorAll('.job-card');
    const searchInput = document.querySelector('.job-board-search-input');

    function filterJobs() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        jobCards.forEach(card => {
            let show = true;
            // Location
            if (filterState.location && card.getAttribute('data-location') !== filterState.location) {
                show = false;
            }
            // Category
            if (filterState.category && card.getAttribute('data-category') !== filterState.category) {
                show = false;
            }
            // Type
            if (filterState.type && card.getAttribute('data-type') !== filterState.type) {
                show = false;
            }
            // Experience
            if (filterState.experience && card.getAttribute('data-experience') !== filterState.experience) {
                show = false;
            }
            // Search
            if (searchTerm) {
                const title = card.querySelector('.job-title').textContent.toLowerCase();
                const company = card.querySelector('.job-company-name').textContent.toLowerCase();
                const desc = card.querySelector('.job-desc').textContent.toLowerCase();
                if (!(
                    title.includes(searchTerm) ||
                    company.includes(searchTerm) ||
                    desc.includes(searchTerm)
                )) {
                    show = false;
                }
            }
            card.style.display = show ? '' : 'none';
        });
    }

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.custom-dropdown-toggle');
        const menu = dropdown.querySelector('.custom-dropdown-menu');
        const items = menu.querySelectorAll('li');
        const type = dropdown.getAttribute('data-type');

        // Open/close dropdown
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            // Close any other open dropdown
            if (openDropdown && openDropdown !== dropdown) {
                openDropdown.classList.remove('open');
            }
            dropdown.classList.toggle('open');
            openDropdown = dropdown.classList.contains('open') ? dropdown : null;
        });

        // Select item
        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                // Set button text
                toggle.textContent = item.textContent;
                // Mark selected
                items.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
                // Update filter state
                if (type) {
                    filterState[type] = item.getAttribute('data-value');
                    filterJobs();
                }
                // Close dropdown
                dropdown.classList.remove('open');
                openDropdown = null;
            });
        });
    });

    // Filter on search input
    if (searchInput) {
        searchInput.addEventListener('input', filterJobs);
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        if (openDropdown) {
            openDropdown.classList.remove('open');
            openDropdown = null;
        }
    });
});

// Custom dropdown logic for all .custom-category-dropdown (from categories.js)
document.querySelectorAll('.custom-category-dropdown').forEach(function(dropdown) {
    const selected = dropdown.querySelector('.selected-category');
    const options = dropdown.querySelector('.category-options');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    // Set initial selected label
    const initial = options.querySelector('li.selected');
    if (initial) selected.textContent = initial.textContent;
    // Open/close dropdown
    dropdown.addEventListener('click', function(e) {
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
        dropdown.classList.toggle('open');
    });
    // Option select
    options.addEventListener('click', function(e) {
        if (e.target.tagName.toLowerCase() === 'li') {
            options.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
            e.target.classList.add('selected');
            selected.textContent = e.target.textContent;
            hiddenInput.value = e.target.getAttribute('data-value');
            options.style.display = 'none';
            dropdown.classList.remove('open');
            // Submit the form on selection
            document.getElementById('categoryFilterForm').submit();
        }
    });
    // Close on outside click
    document.addEventListener('mousedown', function(e) {
        if (!dropdown.contains(e.target)) {
            options.style.display = 'none';
            dropdown.classList.remove('open');
        }
    });
    // Keyboard navigation
    dropdown.addEventListener('keydown', function(e) {
        const items = Array.from(options.querySelectorAll('li'));
        let idx = items.findIndex(li => li.classList.contains('selected'));
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            options.style.display = 'block';
            dropdown.classList.add('open');
            idx = (idx + 1) % items.length;
            items.forEach(li => li.classList.remove('selected'));
            items[idx].classList.add('selected');
            items[idx].scrollIntoView({block:'nearest'});
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            options.style.display = 'block';
            dropdown.classList.add('open');
            idx = (idx - 1 + items.length) % items.length;
            items.forEach(li => li.classList.remove('selected'));
            items[idx].classList.add('selected');
            items[idx].scrollIntoView({block:'nearest'});
        } else if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (options.style.display === 'block') {
                const sel = options.querySelector('li.selected');
                if (sel) sel.click();
            } else {
                options.style.display = 'block';
                dropdown.classList.add('open');
            }
        } else if (e.key === 'Escape') {
            options.style.display = 'none';
            dropdown.classList.remove('open');
        }
    });
}); 