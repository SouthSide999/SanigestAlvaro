<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/admin/zonas/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nueva Zona
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/zonas" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">

            <div class="formulario__campo">
                <label for="nombre_zona" class="formulario__label">Buscar Zona:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="nombre_zona"
                    name="nombre_zona"
                    placeholder="Ingrese el nombre de la zona">
            </div>

        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Zona"
                class="dashboard__boton__buscardor">
            <a href="/admin/zonas" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>


<div class="dashboard__contenedor">
    <?php if (!empty($zonas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Nombre de Zona</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($zonas as $zona) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $zona->codigo_zona; ?></td>
                        <td class="table__td"><?php echo $zona->nombre_zona; ?></td>

                        <td class="table__td--acciones">
                            <!-- Editar -->
                            <a class="table__accion table__accion--editar" href="/admin/zonas/editar?id=<?php echo $zona->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </a>

                            <!-- Eliminar -->
                            <form method="POST" action="/admin/zonas/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $zona->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay zonas registradas aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>

<?php
session_start();

if (isset($_SESSION['exito'])) :
?>
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: '<?php echo $_SESSION['exito']; ?>',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['exito']);
endif;

if (isset($_SESSION['error'])) :
?>
    <script>
        Swal.fire({
            title: '¡Error!',
            text: '<?php echo $_SESSION['error']; ?>',
            icon: 'error',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['error']);
endif;
?>

