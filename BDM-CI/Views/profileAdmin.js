document.addEventListener('DOMContentLoaded', function () {
    const profileContent = document.getElementById('profileContent');
    const accountsContent = document.getElementById('accountsContent');
    const categoriesContent = document.getElementById('categoriesContent');
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
                accountsContent.classList.add('d-none');
                categoriesContent.classList.add('d-none');
            } else if (section === 'accounts') {
                profileContent.classList.add('d-none');
                accountsContent.classList.remove('d-none');
                categoriesContent.classList.add('d-none');
            }else if(section === 'categories'){
                profileContent.classList.add('d-none');
                accountsContent.classList.add('d-none');
                categoriesContent.classList.remove('d-none');
            }
        });
    });
});