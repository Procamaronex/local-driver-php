document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('scaly-container');
    const scales = [];

    // Crea las escamas y las agrega al contenedor
    for (let i = 0; i < 1500; i++) {
        const scale = document.createElement('div');
        scale.classList.add('scale');
        container.appendChild(scale);
        randomizeScale(scale);
        scales.push(scale);
    }

    // Añade evento al mover el ratón
    container.addEventListener('mousemove', function(event) {
        const mouseX = event.clientX;
        const mouseY = event.clientY;

        scales.forEach(function(scale) {
            const rect = scale.getBoundingClientRect();
            const scaleX = rect.left + rect.width / 2;
            const scaleY = rect.top + rect.height / 2;

            const deltaX = mouseX - scaleX;
            const deltaY = mouseY - scaleY;

            const angle = Math.atan2(deltaY, deltaX);
            const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);

            const moveDistance = Math.min(10000 / distance, 10);

            const moveX = moveDistance * Math.cos(angle);
            const moveY = moveDistance * Math.sin(angle);

            scale.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });
    });

    // Añade eventos para cada escama
    scales.forEach(function(scale) {
        scale.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });
        scale.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });
});

// Función para randomizar la posición de una escama
function randomizeScale(scale) {
    const containerWidth = document.getElementById('scaly-container').offsetWidth;
    const containerHeight = document.getElementById('scaly-container').offsetHeight;
    const scaleSize = Math.random() * 10 + 5; // Tamaño aleatorio entre 5px y 15px
    const x = Math.random() * containerWidth;
    const y = Math.random() * containerHeight;

    scale.style.width = scale.style.height = `${scaleSize}px`;
    scale.style.left = `${x}px`;
    scale.style.top = `${y}px`;
}
