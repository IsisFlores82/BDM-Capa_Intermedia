document.addEventListener('DOMContentLoaded', function () {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const profileContent = document.getElementById('profileContent');
    const coursesContent = document.getElementById('coursesContent');
    const links = document.querySelectorAll('.sidebar a');

    // Toggle sections based on clicked link
    links.forEach(link => {
        link.addEventListener('click', function (event) {
            if (this.classList.contains('external-link')) {
                // Allow normal navigation for external links
                return;
            }
            event.preventDefault(); // Prevent default anchor behavior

            const section = this.getAttribute('data-section');
            
            // Remove 'active' class from all links
            links.forEach(link => link.classList.remove('active'));

            // Add 'active' class to the clicked link
            this.classList.add('active');
            
            if (section === 'profile') {
                profileContent.classList.remove('d-none');
                coursesContent.classList.add('d-none');
            } else if (section === 'courses') {
                profileContent.classList.add('d-none');
                coursesContent.classList.remove('d-none');
            }
        });
    });
});