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
                loadCourses();
            }
            else if (section === 'courses') {
                profileContent.classList.add('d-none');
                coursesContent.classList.remove('d-none');
                loadCourses();
            }
        });
    });

    // Function to load courses
    function loadCourses() {
        const courses = [
            { img:'https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg',title: 'Como ser cantante profesional', link: 'CourseDetail.html' },
            { img:'https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png',title: 'Como hacer una base de datos mamastrosa',  link: 'CourseDetail.html' },
           ];

        const coursesRow = document.querySelector('#coursesContent .row');
        coursesRow.innerHTML = '';

        courses.forEach(course => {
            const card = document.createElement('div');
            card.className = 'col-md-4 mb-3';
            card.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="confirmDelete()">Eliminar</button>
                        <img src="${course.img}" alt="Curso" class="img-fluid course-image">
                        <h5 class="card-title">${course.title}</h5>
                        <a href="${course.link}" class="btn btn-primary">Ver Curso</a>
                    </div>
                </div>
            `;
            coursesRow.appendChild(card);
        });
    }

    function validatePassword() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        
        // Regular expressions for validation
        const hasUpperCase = /[A-Z]/;
        const hasNumber = /\d/;
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;
        const minLength = 8;


        if (password.length==0&&confirmPassword.length==0){
            return true;
        }
        if (password.length < minLength) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return false;
        }
        if (!hasUpperCase.test(password)) {
            alert('La contraseña debe incluir al menos una mayúscula.');
            return false;
        }
        if (!hasNumber.test(password)) {
            alert('La contraseña debe incluir al menos un número.');
            return false;
        }
        if (!hasSpecialChar.test(password)) {
            alert('La contraseña debe incluir al menos un carácter especial.');
            return false;
        }
        if (password !== confirmPassword) {
            alert('Las contraseñas no coinciden.');
            return false;
        }

        return true;
    }

    document.getElementById('profileForm').addEventListener('submit', function (event) {
        if (!validatePassword()) {
            event.preventDefault();
        }
    });
});