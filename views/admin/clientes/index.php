<h2><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor">
    <?php if (!empty($clientes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre y Apellidos</th>
                    <th scope="col" class="table__th">Correo</th>
                    <th scope="col" class="table__th">DNI</th>
                    <th scope="col" class="table__th">Celular</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($clientes as $cliente) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $cliente->nombre . " " . $cliente->apellido; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->email; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->dni; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->celular; ?>
                        </td>
                        <td class="table__td--acciones">
                            <!--editar-->
                            <a class="table__accion table__accion--editar" href="/admin/cliente/editar?id=<?php echo $cliente->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <!--eliminar-->
                            <form method="POST" action="/admin/cliente/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $cliente->id; ?>">
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
        <p class="text-center">No hay ningún cliente registrado.</p>
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
            text: 'El cliente ha sido eliminado correctamente.',
            icon: 'success',
            timer: 3000,
            confirmButtonText: 'OK'
        });
    </script>
<?php
    unset($_SESSION['eliminado']);
endif;
?>
