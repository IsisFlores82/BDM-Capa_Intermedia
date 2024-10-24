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
                loadAccounts();
            }else if(section === 'categories'){
                profileContent.classList.add('d-none');
                accountsContent.classList.add('d-none');
                categoriesContent.classList.remove('d-none');
                loadInitialCategories();
            }
        });
    });

    // Function to load courses
    function loadAccounts() {
        const courses = [
            { img:'https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg',user: 'Carlos Daniel Pinkus Martinez'},
            { img:'https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png',user: 'Villatrue'}
         ];

        const coursesRow = document.querySelector('#accountsContent .row');
        coursesRow.innerHTML = '';

        courses.forEach(course => {
            const card = document.createElement('div');
            card.className = 'col-md-4 mb-3';
            card.innerHTML = `
<div class="card text-center">
    <div class="card-body">
        <!-- Imagen de Perfil centrada y forzada a ser un círculo -->
        <div class="profile-img-container mb-3">
            <img src="${course.img}" alt="Perfil" class="profile-img-acc rounded-circle">
        </div>

        <!-- Nombre del Usuario centrado -->
        <h5 class="card-title">${course.user}</h5>

        <!-- Botón centrado -->
        <button class="btn btn-primary mt-3" onclick="confirmRehabilitate()">Rehabilitar Cuenta</button>
    </div>
</div>
            `;
            coursesRow.appendChild(card);
        });
    }
// Carga inicial de categorías predeterminadas
function loadInitialCategories() {
    const initialCategories = [
        { name: 'Desarrollo', description: 'Cursos sobre desarrollo de software y programación' },
        { name: 'Bases de Datos', description: 'Cursos para aprender sobre bases de datos' },
        { name: 'Marketing', description: 'Cursos sobre marketing y ventas' },
        { name: 'Diseño', description: 'Cursos sobre diseño gráfico y creativo' },
        { name: 'Unreal', description: 'Cursos especializados en el motor de Unreal Engine' }
    ];

    const categoryList = document.getElementById('categoryList');
    categoryList.innerHTML='';
    initialCategories.forEach((category, index) => {
        addCategoryToDOM(category.name, category.description, index);
    });
}

// Función para agregar una categoría al DOM
function addCategoryToDOM(name, description, index) {
    const categoryList = document.getElementById('categoryList');
    const categoryItem = document.createElement('div');
    categoryItem.classList.add('row', 'mb-3');
    categoryItem.setAttribute('data-index', index);

    categoryItem.innerHTML = `
        <div class="col-md-5">
            <label class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" name="categoryName" value="${name}" required>
        </div>
        <div class="col-md-5">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="categoryDescription" value="${description}" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger" onclick="removeCategory(this)">Eliminar</button>
        </div>
    `;

    categoryList.appendChild(categoryItem);
}
});