<nav class="navbar bg-dark border-bottom border-body navbar-expand-lg bg-body-tertiary">
    <a class="navbar-item nav-link active" href="#" aria-current="page" data-bs-toggle="modal"
        data-bs-target="#modalDiscont">
        <i class="bi bi-search"></i>
        <span>Дисконт</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <!-- <a class="navbar-item nav-link active" href="#catalog" onclick="openCatalog()"> -->
                <a class="navbar-item nav-link active" href="#" aria-current="page" data-bs-toggle="modal"
                    data-bs-target="#exampleModalCatalog" id="show-modal-catalog-btn">
                    <i class="bi bi-search"></i>
                    <span>Каталог</span>
                </a>

            </li>
            <li class="nav-item">
                <!-- Button modal -->
                <a class="navbar-item nav-link active" href="#" aria-current="page" data-bs-toggle="modal"
                    data-bs-target="#modalBarcode">
                    <i class="bi bi-upc-scan"></i>

                    <span>Пошук за штрих-кодом</span>
                </a>
            </li>

        </ul>
    </div>

    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="navbar-item nav-link active" href="#" aria-current="page" data-bs-toggle="modal"
                data-bs-target="#ModalDefferedChecks" onclick="">
                <span>Відкладені чеки</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="navbar-item nav-link active" href="#" aria-current="page" data-bs-toggle="modal"
                data-bs-target="#ModalChecks">
                <span>Список чеків</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="navbar-item nav-link active" href="#" aria-current="page">
                <i class="bi bi-x-lg"></i>
            </a>
        </li> -->
        <li class="nav-item dropdown">
            <a class="nav-link navbar-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span>Режим</span>
            </a>
            <ul class="dropdown-menu dropdown-to-right">
                <li><a class="dropdown-item" href="#">Опція 1</a></li>
                <li><a class="dropdown-item" href="#">Опція 2</a></li>
                <li><a class="dropdown-item" href="#">Опція 3</a></li>
                <li><a class="dropdown-item" href="#">Опція 4</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Звіт</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link navbar-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-right: 0;">
                Ще
            </a>
            <ul class="dropdown-menu dropdown-to-right">
                <li><a class="dropdown-item" href="#">Опція 1</a></li>
                <li><a class="dropdown-item" href="#">Опція 2</a></li>
                <li><a class="dropdown-item" href="#">Опція 3</a></li>
                <li><a class="dropdown-item" href="#">Опція 4</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Звіт</a></li>
            </ul>
        </li>
    </ul>
</nav>