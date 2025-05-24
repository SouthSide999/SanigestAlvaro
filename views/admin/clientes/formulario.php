<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Cliente</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            value="<?php echo $cliente->nombre ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input
            type="text"
            class="formulario__input"
            id="apellido"
            name="apellido"
            placeholder="Apellido"
            value="<?php echo $cliente->apellido ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="dni" class="formulario__label">DNI</label>
        <input
            type="text"
            class="formulario__input"
            id="dni"
            name="dni"
            placeholder="DNI"
            maxlength="8"
            value="<?php echo $cliente->dni ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="celular" class="formulario__label">Celular</label>
        <input
            type="text"
            class="formulario__input"
            id="celular"
            name="celular"
            placeholder="Celular"
            maxlength="9"
            value="<?php echo $cliente->celular ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="email" class="formulario__label">Email</label>
        <input
            type="email"
            class="formulario__input"
            id="email"
            name="email"
            placeholder="Correo Electrónico"
            value="<?php echo $cliente->email ?? ''; ?>">
    </div>

    <div class="formulario__campo">
        <label for="password" class="formulario__label">Nuevo Password</label>
        <input
            type="password"
            class="formulario__input"
            id="password"
            name="password"
            placeholder="Tu Nuevo Password">
    </div>

    <div class="formulario__campo">
        <label for="codigo_predio" class="formulario__label">Predio Asociado</label>
        <select class="formulario__input" id="codigo_predio" name="codigo_predio">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($predios as $predio): ?>
                <option value="<?php echo $predio->id; ?>" <?php echo ($cliente->codigo_predio == $predio->id) ? 'selected' : ''; ?>>
                    <?php echo $predio->codigo_predio.'-'.$predio->direccion; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</fieldset>
