// Admin Dashboard Tab Switching & Animations

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.admin-tab');
    const contents = document.querySelectorAll('.tab-content');
    const dashboard = document.querySelector('.dashboard-container');

    // Tab switching with animation
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            contents.forEach(c => {
                c.classList.remove('active');
                c.style.display = 'none';
            });
            const content = document.getElementById('tab-' + tab.dataset.tab);
            if (content) {
                content.style.display = 'block';
                setTimeout(() => content.classList.add('active'), 10); // trigger fade/slide
            }
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });
    // Show first tab by default
    if (tabs.length) {
        tabs[0].click();
    }

    // Floating/parallax effect for dashboard card
    if (dashboard) {
        dashboard.addEventListener('mousemove', function(e) {
            const rect = dashboard.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            dashboard.style.transform = `translateY(-4px) rotateX(${y*6}deg) rotateY(${-x*6}deg)`;
        });
        dashboard.addEventListener('mouseleave', function() {
            dashboard.style.transform = '';
        });
    }

    // Animated bubble/particle background
    function createBubble() {
        const bubble = document.createElement('div');
        bubble.className = 'dashboard-bubble';
        bubble.style.left = Math.random() * 100 + 'vw';
        bubble.style.animationDuration = (3 + Math.random() * 4) + 's';
        bubble.style.opacity = 0.15 + Math.random() * 0.25;
        bubble.style.width = bubble.style.height = (18 + Math.random() * 32) + 'px';
        document.body.appendChild(bubble);
        setTimeout(() => bubble.remove(), 7000);
    }
    setInterval(createBubble, 700);
});

// Bubble styles (inject into head for convenience)
(function(){
    const style = document.createElement('style');
    style.innerHTML = `
    .dashboard-bubble {
        position: fixed;
        bottom: -60px;
        z-index: 0;
        background: radial-gradient(circle at 30% 30%, #ffb6e6 60%, #ff4f8b 100%);
        border-radius: 50%;
        pointer-events: none;
        animation: dashboard-bubble-float linear forwards;
    }
    @keyframes dashboard-bubble-float {
        from { transform: translateY(0) scale(1); }
        to { transform: translateY(-110vh) scale(1.2); opacity: 0; }
    }
    `;
    document.head.appendChild(style);
})(); 