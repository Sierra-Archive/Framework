<li<?php if($params['ativo']===false) { echo ' class="active"'; } ?>>
    <?php if($params['ativo']!==false) { ?><a class="lajax" href="<?php echo URL_PATH.$params['endereco']; ?>" data-acao=""><?php } ?>
        <?php echo $params['nome']; ?>
    <?php if($params['ativo']!==false) { ?></a><?php } ?>
</li>