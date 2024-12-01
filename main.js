// Create an odometer and animate the value dynamically
const createOdometer = (el, value) => {
    const odometer = new Odometer({
        el: el,
        value: 0, // Start at zero
    });

    let hasRun = false; // To ensure the animation runs only once

    const options = {
        threshold: [0, 0.9], // Trigger when the element is about 90% visible
    };

    const callback = (entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !hasRun) {
                odometer.update(value); // Animate to the new value
                hasRun = true; // Prevent re-animation
                observer.unobserve(el); // Stop observing once animated
            }
        });
    };

    const observer = new IntersectionObserver(callback, options);
    observer.observe(el);
};

// Initialize odometers with dynamic values from HTML attributes
document.addEventListener("DOMContentLoaded", () => {
    const subscribersOdometer = document.querySelector(".subscribers-odometer");
    createOdometer(
        subscribersOdometer, <?php echo $student_count; ?>);

    const videosOdometer = document.querySelector(".videos-odometer");
    createOdometer(
        videosOdometer,
        Number(videosOdometer.getAttribute("data-value"))
    );

    const projectsOdometer = document.querySelector(".projects-odometer");
    createOdometer(
        projectsOdometer,
        Number(projectsOdometer.getAttribute("data-value"))
    );
});
