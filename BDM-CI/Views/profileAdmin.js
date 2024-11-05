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
                loadInitialCategories();
            }
        });
    });

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