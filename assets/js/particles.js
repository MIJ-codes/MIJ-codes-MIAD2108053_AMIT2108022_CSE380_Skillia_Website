// Modular Particle Background for Skillia
(function(global){
  function createParticles(containerSelector, options={}) {
    const container = document.querySelector(containerSelector);
    if (!container) return;
    const numParticles = options.count || 40;
    const color = options.color || 'rgba(81,45,168,0.12)';
    const minSize = options.minSize || 2;
    const maxSize = options.maxSize || 7;
    const particles = [];
    for (let i = 0; i < numParticles; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      const size = Math.random() * (maxSize - minSize) + minSize;
      p.style.width = p.style.height = size + 'px';
      p.style.background = color;
      p.style.position = 'absolute';
      p.style.left = (Math.random() * 100) + '%';
      p.style.top = (Math.random() * 100) + '%';
      p.style.opacity = Math.random() * 0.5 + 0.2;
      container.appendChild(p);
      particles.push({el: p, speed: Math.random() * 0.3 + 0.1, dir: Math.random() * Math.PI * 2});
    }
    function animate() {
      particles.forEach(p => {
        let top = parseFloat(p.el.style.top);
        let left = parseFloat(p.el.style.left);
        top += Math.sin(p.dir) * p.speed;
        left += Math.cos(p.dir) * p.speed;
        if (top > 100) top = 0;
        if (top < 0) top = 100;
        if (left > 100) left = 0;
        if (left < 0) left = 100;
        p.el.style.top = top + '%';
        p.el.style.left = left + '%';
      });
      requestAnimationFrame(animate);
    }
    animate();
    return () => { // cleanup
      particles.forEach(p => p.el.remove());
    };
  }
  // Export to global namespace
  global.SkilliaParticles = { createParticles };
})(window); 