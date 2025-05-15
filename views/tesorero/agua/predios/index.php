<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/tesorero/agua">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
    <a class="dashboard__boton" href="/tesorero/predios/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Nuevo Predio
    </a>
</div>

<div class="dashboard__contenedor-buscador">
    <form class="dashboard__formulario__buscardor" action="/tesorero/predios" enctype="multipart/form-data" method="POST">
        <fieldset class="formulario__fieldset">
            <div class="formulario__campo">
                <label for="buscar_por" class="formulario__label">Buscar por:</label>
                <select class="formulario__input" id="criterio" name="criterio">
                    <option disabled selected>Selecciona un opcion</option>
                    <option value="codigo_predio">Código</option>
                    <option value="direccion">Dirección</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="dato" class="formulario__label">Valor a buscar:</label>
                <input
                    type="text"
                    class="formulario__input"
                    id="dato"
                    name="dato"
                    placeholder="Ingrese el valor a buscar">
            </div>
        </fieldset>

        <div class="dashboard__contenedor__boton">
            <input
                type="submit"
                value="Buscar"
                class="dashboard__boton__buscardor">
            <a href="/tesorero/predios" class="dashboard__boton__buscardor">
                Lista Completa
            </a>
        </div>
    </form>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($predios)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Código</th>
                    <th scope="col" class="table__th">Contribuyente</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Zona</th>
                    <th scope="col" class="table__th">Sector</th>
                    <th scope="col" class="table__th">Estado Servicio</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($predios as $predio) { ?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $predio->codigo_predio; ?></td>
                        <td class="table__td"><?php echo $predio->contribuyente->nombres . ' ' . $predio->contribuyente->apellidos; ?></td>
                        <td class="table__td"><?php echo $predio->direccion; ?></td>
                        <td class="table__td"><?php echo $predio->zona->codigo_zona . ' - ' . $predio->zona->nombre_zona; ?></td>
                        <td class="table__td"><?php echo $predio->sector->codigo_sector . ' - ' . $predio->sector->nombre_sector; ?></td>
                        <td class="table__td"><?php echo $predio->estado_servicio->nombre ?? 'N/D'; ?></td>


                        <td class="table__td--acciones">
                            <!-- Editar -->
                            <a class="table__accion table__accion--editar" href="/tesorero/predios/editar?id=<?php echo $predio->id; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </a>

                            <!-- Eliminar -->
                            <form method="POST" action="/tesorero/predios/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $predio->id; ?>">
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
        <p class="text-center">No hay predios registrados aún.</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>

<?php
session_start();
if (isset($_SESSION['eliminado'])) :
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El Predio se ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000, // La alerta se cierra en 3 segundos
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']); // Limpiar la sesión para que no se repita
endif;
?>

<?php
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