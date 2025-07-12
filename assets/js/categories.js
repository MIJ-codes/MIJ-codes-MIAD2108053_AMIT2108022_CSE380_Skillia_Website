// Categories Page Interactivity

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.categories-search-input');
    const categoryCards = document.querySelectorAll('.category-card');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            categoryCards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const desc = card.querySelector('.category-desc').textContent.toLowerCase();
                const roles = card.querySelector('.category-roles').textContent.toLowerCase();
                if (
                    name.includes(searchTerm) ||
                    desc.includes(searchTerm) ||
                    roles.includes(searchTerm)
                ) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter buttons
    const filterBtns = document.querySelectorAll('.categories-filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.textContent.trim();
            categoryCards.forEach(card => {
                if (filter === 'All Categories') {
                    card.style.display = '';
                } else if (filter === 'Most Popular') {
                    card.style.display = parseInt(card.getAttribute('data-job-count')) > 1000 ? '' : 'none';
                } else if (filter === 'Remote Available') {
                    card.style.display = card.getAttribute('data-remote') === 'true' ? '' : 'none';
                } else if (filter === 'Freelance') {
                    card.style.display = card.querySelector('.category-roles').textContent.toLowerCase().includes('freelance') ? '' : 'none';
                } else if (filter === 'Full-time') {
                    card.style.display = card.querySelector('.category-roles').textContent.toLowerCase().includes('full') ? '' : 'none';
                }
            });
        });
    });

    // Sort select
    const sortSelect = document.querySelector('.categories-sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const value = this.value;
            const grid = document.querySelector('.categories-grid');
            const cards = Array.from(grid.children);
            let sorted;
            if (value === 'az') {
                sorted = cards.sort((a, b) => a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent));
            } else if (value === 'job-count') {
                sorted = cards.sort((a, b) => parseInt(b.getAttribute('data-job-count')) - parseInt(a.getAttribute('data-job-count')));
            } else if (value === 'salary') {
                sorted = cards.sort((a, b) => {
                    const aSalary = parseInt(a.querySelector('.category-salary').textContent.replace(/[^0-9]/g, ''));
                    const bSalary = parseInt(b.querySelector('.category-salary').textContent.replace(/[^0-9]/g, ''));
                    return bSalary - aSalary;
                });
            }
            sorted.forEach(card => grid.appendChild(card));
        });
    }

    // Location and experience filters (future backend integration)
    const locationFilter = document.querySelector('.categories-filter[data-type="location"]');
    const experienceFilter = document.querySelector('.categories-filter[data-type="experience"]');
    [locationFilter, experienceFilter].forEach(filter => {
        if (filter) {
            filter.addEventListener('change', function() {
                // Placeholder: In future, filter categories based on backend data
            });
        }
    });
}); 