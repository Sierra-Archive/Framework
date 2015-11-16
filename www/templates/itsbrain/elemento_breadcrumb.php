<li<?php if ($params['ativo'] === FALSE) { echo ' class="active"'; } ?>>
    <?php if ($params['ativo'] !== FALSE) { ?><a class="lajax" href="<?php echo URL_PATH.$params['endereco']; ?>" data-acao=""><?php } ?>
        <?php echo $params['nome']; ?>
    <?php if ($params['ativo'] !== FALSE) { ?></a><?php } ?>
</li>