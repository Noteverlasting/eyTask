<header>
    <?php if ($_SESSION['usuario']) : ?>
        <div class="nombreUser">
            <div>
        <!-- Añado un boton para alternar la vista de las tareas por dia o estado -->
        <div class="toggleView">
    <button id="toggleEstado">ver por estado</button>
    <button id="toggleDia">ver por día</button>
</div>
            </div>
            <div class="usuario-info">
                <p>Hola <span><?= $_SESSION['usuario'] ?></span>! Qué tal?</p>
                <form action="../logout.php" method="post">
                    <button type="submit" class="btnLogout">
                        <span class="logout-text">Cerrar sesión</span>
                        <i class="fa-solid fa-door-open" style="color: red;"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="header-titulo">
            <h1>
                <span class="h1-ey">ey</span>
                <span class="h1-img">
                    <img src="../08_EJERCICIO_GESTOR/img/home-imgs.png" alt="">
                </span>
                <span class="h1-task">task</span>
            </h1>
        </div>

    <?php else : ?>
        <div class="nombreUser">
            <div>
                    <button type="submit" class="btnAcceder"><a href="index.php?formulario=login">  acceder</a></button>
                    <button type="submit" class="btnAcceder"><a href="index.php?formulario=crear-usuario">  crear cuenta</a></button>
            </div>
        </div>
            <div class="header-titulo">
                <h1>
                    <span class="h1-ey">ey</span>
                    <span class="h1-img">
                        <img src="08_EJERCICIO_GESTOR/img/home-imgs.png" alt="">
                    </span>
                    <span class="h1-task">task</span>
                </h1>
            </div>
        <?php endif ?>
</header>