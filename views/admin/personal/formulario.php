<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Del Personal</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            value="<?php echo $personal->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input
            type="text"
            class="formulario__input"
            id="apellido"
            name="apellido"
            placeholder="Apellido"
            value="<?php echo $personal->apellido; ?>">
    </div>

    <div class="formulario__campo">
        <label for="email" class="formulario__label">Email</label>
        <input
            type="email"
            class="formulario__input"
            id="email"
            name="email"
            placeholder="Correo Electrónico"
            value="<?php echo $personal->email; ?>">
    </div>

    <div class="formulario__campo">
        <label for="password" class="formulario__label">Nuevo Password</label>
        <input
            type="password"
            class="formulario__input"
            placeholder="Tu Nuevo Password"
            id="password"
            name="password">

    </div>

    <div class="formulario__campo">
        <label for="rol" class="formulario__label">Rol</label>
        <select class="formulario__input" id="rol" name="rol_id">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol->id; ?>" <?php echo ($personal->rol_id == $rol->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($rol->nombre); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

</fieldset>