<h2><?php echo $titulo; ?></h2>

<div class="dashboardUser__contenedor-boton">
    <a class="dashboardUser__boton" href="/user/dashboard">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboardUser__gridCreate">
    <div>
        <h2>Tus Reclamos: </h2>
        <div class="dashboardUser__contenedor">
            <?php if (!empty($reclamosUsuario)) { ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Tipo de Reclamo: </th>
                            <th scope="col" class="table__th">Estado: </th>

                            <th scope="col" class="table__th">Descripcion</th>
                            <th scope="col" class="table__th">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="table__tbody">
                        <?php foreach ($reclamosUsuario as $reclamoUsuario) { ?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo  $reclamoUsuario->tipo->nombre ?>
                                </td>
                                <td class="table__td">
                                    <?php if ($reclamoUsuario->estado_id === '1') { ?>
                                        <button class="table__pendiente" type="submit">
                                            Pendiente
                                        </button>
                                    <?php } elseif ($reclamoUsuario->estado_id === '5') { ?>
                                        <button class="table__completa">
                                            Completa
                                        </button>
                                    <?php   } ?>

                                </td>
                                <td class="table__td">
                                    <h4 class="noticia__introduccion"><?php echo $reclamoUsuario->descripcion ?></h4>
                                </td>

                                <td class="table__td--acciones">

                                    <!--editar-->
                                    <a class="table__accion table__accion--editar" href="/user/reclamos/ver?id=<?php echo $reclamoUsuario->id; ?>">
                                        <i class="fa-solid fa-file"></i>
                                        Ver Tu Reclamo
                                    </a>

                                    <!--eliminar-->
                                    <form method="POST" action="/user/reclamos/eliminar" class="table__formulario">
                                        <input type="hidden" name="id" value="<?php echo $reclamoUsuario->id; ?>">
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
                <p class="text-center">No Hay Reclamos Aún</p>
            <?php } ?>
        </div>
    </div>

    <div class="dashboardUser__formulario">
        <?php
        include_once __DIR__ . '../../../templates/alertas.php';
        ?>
        <form class="formulario" action="/user/reclamos" enctype="multipart/form-data" method="POST">
            <?php
            include_once __DIR__ . '/formulario.php';
            ?>
            <input
                type="submit"
                value="Registrar Reclamo"
                class="formulario__submit formulario__submit--registrarU">
        </form>
    </div>

</div>

<?php
session_start();
if (isset($_SESSION['exito']) || isset($_SESSION['eliminado'])) :
    $mensaje = isset($_SESSION['exito']) ? 'El reclamo se ha registrado correctamente.' : 'El reclamo ha sido eliminado correctamente.';
    $titulo = isset($_SESSION['exito']) ? '¡Éxito!' : '¡Eliminado!';
    $icono = 'success';
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '<?php echo $titulo; ?>',
            text: '<?php echo $mensaje; ?>',
            icon: '<?php echo $icono; ?>',
            timer: 3000,
            confirmButtonText: 'OK'
        }).then(() => {
            <?php if (isset($_SESSION['exito'])) : ?>
                window.location.href = '/admin/reclamos'; // Redirigir solo en caso de éxito
            <?php endif; ?>
        });
    </script>
<?php
    unset($_SESSION['exito']);
    unset($_SESSION['eliminado']);
endif;
?>
