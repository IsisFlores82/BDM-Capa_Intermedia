<?php
    if (!empty($_SESSION['user']['Foto'])) {
        // Inicializar fileinfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        
        // Detectar el tipo MIME del contenido BLOB
        $mimeType = $finfo->buffer($_SESSION['user']['Foto']);

        // Convertir el BLOB a base64
        $fotoBase64 = base64_encode($_SESSION['user']['Foto']);
        
        // Usar el MIME detectado en la etiqueta <img>
        $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
    } else {
        $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg"; // Ruta a la imagen predeterminada
    }
?>

<header class="d-flex justify-content-between align-items-center py-3 <?php if(urlIs('/BDM-CI/mensajeria')){echo 'bg-light';} ?>">
        <div class="d-flex align-items-center">
            <a href="/BDM-CI/" class="btn"> 
                <img src="Resources/logoPlacerHolder.png" alt="Logo" width="40" height="40"></img> 
            </a>  
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bars"></i> Categorías
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="/BDM-CI/search">Desarrollo</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/search">Bases de Datos</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/search">Marketing</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/search">Diseño</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/search">Unreal</a></li>
                </ul>
            </div>
        </div>
        
        <div class="input-group w-75">
            <input type="text" id="searchInput" class="form-control" placeholder="Busca tu curso deseado">
            <a href="#" class="btn" id="searchBtn"><i class="fas fa-search"></i></a>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="fas fa-filter"></i> Filtro Avanzado
            </button>
        </div>
        <?php if (isset($_SESSION['user'])) { ?>
        <div class="d-flex align-items-center">
            <a href="/BDM-CI/carrito" class="btn">
                <i class="fas fa-shopping-cart me-3"></i> 
            </a>            
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= $fotoSrc ?>" alt="Perfil" class="rounded-circle" width="40" height="40">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="/BDM-CI/profile">Perfil</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/kardex">Kardex</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/mensajeria">Mensajes</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/BDM-CI/logOut">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
        <?php } else { ?>
        <div class="d-flex align-items-center">         
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> 
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="/BDM-CI/signUp">Iniciar Sesión</a></li>
                    <li><a class="dropdown-item" href="/BDM-CI/logIn">Registrarse</a></li>
                </ul>
            </div>
        </div>
        <?php } ?>
        <!-- Ventana Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Cursos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="searchForm">
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoría</label>
                                <select id="category" class="form-select">
                                    <option value="">Selecciona una categoría</option>
                                    <option value="desarrollo">Desarrollo</option>
                                    <option value="base-datos">Bases de Datos</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="diseno">Diseño</option>
                                    <option value="unreal">Unreal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Título del Curso</label>
                                <input type="text" id="title" class="form-control" placeholder="Ingrese el título">
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Autor</label>
                                <input type="text" id="author" class="form-control" placeholder="Ingrese el nombre del autor">
                            </div>
                            <div class="mb-3">
                                <label for="dateRange" class="form-label">Rango de Fechas</label>
                                <input type="date" id="startDate" class="form-control">
                                <input type="date" id="endDate" class="form-control mt-2">
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script src="Views/navbar.js"></script>