<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/admin/contribuyentes" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">

            <div class="formulario__campo">
                <label for="criterio" class="formulario__label">Buscar por:</label>
                <select
                    id="criterio"
                    name="criterio"
                    class="formulario__input">
                    <option disabled selected>Selecciona una opcion</option>
                    <option value="nombres">Nombre</option>
                    <option value="apellidos">Apellido</option>
                    <option value="documento_identidad">DNI</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Ingrese el valor de búsqueda:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Nombre, Apellido o DNI del Contribuyente">
            </div>

        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar Contribuyente"
                class="dashboard__boton__buscardor">
            <a href="/admin/contribuyentes" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>




<div class="dashboard__contenedor">
    <?php if (!empty($contribuyentes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombres</th>
                    <th scope="col" class="table__th">Apellidos</th>
                    <th scope="col" class="table__th">Documento</th>
                    <th scope="col" class="table__th">Tipo Usuario</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($contribuyentes as $contribuyente) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $contribuyente->nombres; ?></td>
                        <td class="table__td"><?php echo $contribuyente->apellidos; ?></td>
                        <td class="table__td"><?php echo $contribuyente->documento_identidad; ?></td>
                        <td class="table__td"><?php echo $contribuyente->tipo_usuario; ?></td>

                        <td class="table__td--acciones">
                            <!-- Editar -->
                            <a class="table__accion table__accion--editar" href="/admin/contribuyentes/editar?id=<?php echo $contribuyente->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!-- Eliminar -->
                            <form method="POST" action="/admin/contribuyentes/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $contribuyente->id; ?>">
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
        <p class="text-center">No hay contribuyentes registrados aún.</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>

<?php
session_start();
if (isset($_SESSION['eliminado'])) :
?>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El Contribuyente ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000, // La alerta se cierra en 3 segundos
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']); // Limpiar la sesión para que no se repita
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