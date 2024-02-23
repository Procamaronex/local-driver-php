document.addEventListener("DOMContentLoaded", function () {
    const circle = document.getElementById("circle");
    const container = document.querySelector(".container");

    container.addEventListener("mousemove", function (e) {
        const mouseX = e.clientX;
        const mouseY = e.clientY;

        const containerRect = container.getBoundingClientRect();
        const containerX = containerRect.left;
        const containerY = containerRect.top;

        const circleWidth = circle.offsetWidth;
        const circleHeight = circle.offsetHeight;

        const newX = (mouseX - containerX - circleWidth) * 2;
        const newY = mouseY - containerY - circleHeight / 2;

        circle.style.transform = `translate(${newX}px, ${newY}px)`;
    });
});