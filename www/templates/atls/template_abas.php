<?php if ( $params['Tipo']==='Topo') { ?>
    <li<?php if ( $params['i']==0) { ?> class="active"<?php } ?>><a href="#<?php echo $params['id']; ?>" data-toggle="tab"><?php echo $params['titulo']; ?></a></li>
<?php } else if ($params['Tipo']==='Final') { ?>
    <div class="tab-pane<?php if ( $params['i']==0) { ?> active<?php } ?>" id="<?php echo $params['id']; ?>"><?php echo $params['bloco']; ?></div>
<?php } else if ($params['Tipo']==='Montagem') { ?>
    <div class="tabbable widget-tabs"><ul class="nav nav-tabs"><?php echo $params['html1']; ?></ul><div class="tab-content"><?php echo $params['html2']; ?></div></div>
<?php } ?>