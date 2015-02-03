<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo $params['upload_foto']; ?>" width="30" height="30"/>
        <span class="username"><?php echo $params['user_name']; ?></span>
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu extended logout">
        <li><a href="<?php echo URL_PATH; ?>usuario/Admin/Usuarios_Edit/"><i class="icon-user"></i> Editar Perfil</a></li>
        <li><a href="<?php echo URL_PATH; ?>?logout=sair"><i class="icon-key"></i> Sair do Sistema</a></li>
    </ul>
</li>