<header class="d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <a href="/BDM-CI/" class="btn">
                <img src="Logo.png" alt="Logo" width="40" height="40"></img> 
            </a>  
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bars"></i> Categorías
                </button>
                <?php 
                require_once 'Model/Category.php';
                    $config = require 'config.php';
                    $category = new Category($config['database']);
                    $categories = $category->getCategories();
                    ?>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php
                foreach($categories as $category){
                        echo '<li><a class="dropdown-item" href="/BDM-CI/search?category='.$category['ID_Categoria'].'">'.$category['Nombre'].'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        
        <div class="input-group w-75">
        <form action="/BDM-CI/search" method="get" class="form-control">
            <div style="display: flex; align-items: center;">
            <input type="text" id="searchInput" name="title" class="form-control" placeholder="Busca tu curso deseado">
            <button type="submit" class="btn" id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
        </form>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="fas fa-filter"></i> Filtro Avanzado
            </button>
        </div>
        <div class="d-flex align-items-center">          
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= $fotoSrc ?>" alt="Perfil" class="rounded-circle" width="40" height="40">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="/BDM-CI/profileAdmin">Perfil</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/reporteUsuarios">Reporte</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/BDM-CI/logOut">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    <!-- Ventana Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Buscar Cursos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="/BDM-CI/search" method="GET" id="searchForm">
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoría</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['ID_Categoria'] ?>"><?= $category['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Título del Curso</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Ingrese el título">
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Autor</label>
                        <input type="text" id="author" name="author" class="form-control" placeholder="Ingrese el nombre del autor">
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Fecha Inicial</label>
                        <input type="date" id="startDate" name="startDate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">Fecha Final</label>
                        <input type="date" id="endDate" name="endDate" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    </header>

    <script src="Views/navbar.js"></script>