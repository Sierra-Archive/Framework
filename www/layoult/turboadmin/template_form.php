<?php if( $params['Tipo']==='Entrada'){
    if($params['Opcao']['class']!=''){
        $class= $params['Opcao']['class'];
    }else{
        $class='';
    }

    if($params['Opcao']['end']!=''){ ?>
        <form id="<?php echo $params['Opcao']['id']; ?>"<?php echo $c['a']['s']; ?> action="<?php echo $params['Opcao']['url']; ?><?php echo $params['Opcao']['end']; ?>" method="post" enctype="multipart/form-data">
    <?php }else{ ?>
        <form id="<?php echo $params['Opcao']['id']; ?>"<?php echo $c['a']['s']; ?> action="<?php echo $params['Opcao']['url']; ?>" method="post" enctype="multipart/form-data">
    <?php } ?>
    <?php if($params['Opcao']['layoult']==='full'){ ?><ul class="align-list"><?php } ?>


<?php }else if($params['Tipo']==='SelectMultiplo'){ ?>
    <div class="control-group"<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>>
    <label class="control-label" for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?>
    <?php if($params['Opcao']['js']!=''){ ?> <a href="#" onClick="<?php echo $params['Opcao']['js']; ?>" style="" class="lajax btn btn-primary">+</a><?php } ?>
    </label>
    <div class="controls">
    <!--Comeca Select--><SELECT tabindex="<?php echo $params['TabIndex']; ?>" name="<?php echo $params['Opcao']['nome']; ?>"<?php if($params['Opcao']['id']!=''){ ?> id="<?php echo $params['Opcao']['id']; ?>"<?php } ?><?php if($params['Opcao']['change']!=''){ ?> onchange="<?php echo $params['Opcao']['change']; ?>"<?php } ?> class="span<?php if($params['Opcao']['js']!='' || $params['Opcao']['end']!=''){ ?>8<?php }else{ ?>12<?php } ?><?php if($params['Opcao']['form_dependencia']===false){ ?> form-select-padrao <?php echo $params['Opcao']['class']; ?>" data-placeholder="<?php echo $params['Opcao']['infonulo']; } ?>"<?php if($params['Opcao']['escondido']==='apagar'){ ?> escondendo="desativado"<?php }else if($params['Opcao']['escondido']==='apagado'){ ?> escondendo="ativado"<?php } ?> multiple="multiple">

    <?php foreach($params['Opcao']['Option'] as $v){ ?>
        <OPTION VALUE="<?php echo $v['valor']; ?>"<?php if($v['selected']===1){ ?> selected<?php } ?>><?php echo $v['titulo']; ?></OPTION>
    <?php } ?>
    </SELECT>
    <?php if($params['Opcao']['end']!='' && $params['Opcao']['form_dependencia']===false){ ?><span class="help-inline"><a href="<?php echo $params['Opcao']['url']; ?><?php echo $params['Opcao']['end']; ?>?formselect=<?php echo $params['Opcao']['id']; ?>&condicao=<?php echo $params['Opcao']['condicao']; ?>" style="" class="lajax btn btn-primary" acao="">+</a></span><?php } ?></div></div>
    
<?php }else if($params['Tipo']==='Input'){ ?>
        <?php if($params['Opcao']['layoult']==='full'){ ?><li<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>><?php } ?>
        <?php if(isset($params['Opcao']['Tipo']) && $params['Opcao']['Tipo']==='hidden'){ ?>
                <input tabindex="<?php echo $params['TabIndex']; ?>" type="hidden"<?php if($params['Opcao']['max_caracteres']!==false && is_int($params['Opcao']['max_caracteres'])){ echo ' MAXLENGTH="'.$params['Opcao']['max_caracteres'].'"'; } ?> value="<?php echo $params['Opcao']['valor']; ?>" id="<?php echo $params['Opcao']['id']; ?>" name="<?php echo $params['Opcao']['nome']; ?>"<?php if($params['Opcao']['class']!=''){ ?><?php if($params['Opcao']['somenteleitura']===false){ ?>class = "<?php echo $params['Opcao']['class']; ?>"<?php }else{ ?> class = "inactive <?php echo $params['Opcao']['class']; ?>"<?php } ?><?php }else if($params['Opcao']['somenteleitura']===true){ ?> class = "inactive"' <?php } ?><?php if($params['Opcao']['somenteleitura']===true){ ?> readonly=""<?php } ?>/>
        <?php }else{ ?>
                <label for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?>:</label><input type="<?php echo $params['Opcao']['tipo']; ?>"<?php if($params['Opcao']['max_caracteres']!==false && is_int($params['Opcao']['max_caracteres'])){ echo ' MAXLENGTH="'.$params['Opcao']['max_caracteres'].'"'; } ?> value="<?php echo $params['Opcao']['valor']; ?>" id="<?php echo $params['Opcao']['nome']; ?>" name="<?php echo $params['Opcao']['nome']; ?>"<?php if($params['Opcao']['class']!=''){ ?><?php if($params['Opcao']['somenteleitura']===false){ ?>class = "<?php echo $params['Opcao']['class']; ?>"<?php }else{ ?> class = "inactive <?php echo $params['Opcao']['class']; ?>"<?php } ?><?php }else if($params['Opcao']['somenteleitura']===true){ ?> class = "inactive"' <?php } ?><?php if($params['Opcao']['somenteleitura']===true){ ?> readonly=""<?php } ?><?php if($params['Opcao']['Mascara']!==false){ ?> onkeydown="Sierra.Visual_Formulario_Mascara(this,'<?php echo $params['Opcao']['Mascara']; ?>');"<?php } ?><?php if($params['Opcao']['change']!=''){ ?> onBlur="<?php echo $params['Opcao']['change']; ?>"<?php } ?><?php if($params['Opcao']['valida']!=''){ ?> validar="<?php echo $params['Opcao']['valida']; ?>"<?php } ?><?php if($params['Opcao']['escondido']==='apagar'){ ?> escondendo="desativado"<?php }else if($params['Opcao']['escondido']==='apagado'){ ?> escondendo="ativado"<?php } ?> x-webkit-speech /> 
        <?php } ?>
        <?php if(isset($params['Opcao']['Info']) && $params['Opcao']['Info']!=''){ ?><span class="msg-form-info"><?php echo $params['Opcao']['info']; ?></span><?php } ?>
        <?php if($params['Opcao']['layoult']==='full'){ ?></li><?php } ?>

<?php }else if($params['Tipo']==='TextArea'){ ?>
    <?php if($params['Opcao']['layoult']==='full'){ ?><li<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>><?php } ?>
        <label for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?></label><textarea tabindex="<?php echo $params['TabIndex']; ?>"<?php if($params['Opcao']['max_caracteres']!==false && is_int($params['Opcao']['max_caracteres'])){ echo ' MAXLENGTH="'.$params['Opcao']['max_caracteres'].'"'; } ?> class="<?php echo $params['Opcao']['class']; ?> span12<?php if($params['Opcao']['tipo'] === 'editor'){ ?> wysihtmleditor5<?php } ?>" name="<?php echo $params['Opcao']['nome']; ?>" id="<?php echo $params['Opcao']['id']; ?>"<?php if($params['Opcao']['escondido']==='apagar'){ ?> escondendo="desativado"<?php }else if($params['Opcao']['escondido']==='apagado'){ ?> escondendo="ativado"<?php } ?>><?php echo $params['Opcao']['valor']; ?></textarea>
        <!--<?php if($params['Opcao']['tipo'] === 'editor'){ ?><script>CKEDITOR.replace('<?php echo $params['Opcao']['id']; ?>');</script><?php } ?>-->
    <?php if($params['Opcao']['layoult']==='full'){ ?></li><?php } ?>

<?php }else if($params['Tipo']==='Select_Inicio'){ ?>
    <?php if($params['Opcao']['layoult']==='full'){ ?><li<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>><?php } ?>
    <label for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?></label>
    <?php if($params['Opcao']['end']!=''){ ?> <a class="lajax-admin" href="<?php echo $params['Opcao']['url']; ?><?php echo $params['Opcao']['end']; ?>?formselect=<?php echo $params['Opcao']['id']; ?>&condicao=<?php echo $params['Opcao']['condicao']; ?>" acao="">+</a><?php } ?>
    <?php if($params['Opcao']['js']!=''){ ?> <a href="#" onClick="<?php echo $params['Opcao']['js']; ?>">+</a><?php } ?>
    <!--Comeca Select--><SELECT tabindex="<?php echo $params['TabIndex']; ?>" name="<?php echo $params['Opcao']['nome']; ?>"<?php if($params['Opcao']['id']!=''){ ?> id="<?php echo $params['Opcao']['id']; ?>"<?php } ?><?php if($params['Opcao']['change']!=''){ ?> onchange="<?php echo $params['Opcao']['change']; ?>"<?php } ?> width="278" class="span<?php if($params['Opcao']['js']!='' || $params['Opcao']['end']!=''){ ?>8<?php }else{ ?>12<?php } ?><?php if($params['Opcao']['form_dependencia']===false){ ?> form-select-padrao <?php echo $params['Opcao']['class']; ?>" data-placeholder="<?php echo $params['Opcao']['infonulo']; } ?>"<?php if($params['Opcao']['escondido']==='apagar'){ ?> escondendo="desativado"<?php }else if($params['Opcao']['escondido']==='apagado'){ ?> escondendo="ativado"<?php } ?><?php if($params['Opcao']['multiplo']===true){ ?>  multiple="multiple"<?php } ?>>

<?php }else if($params['Tipo']==='Select_Opcao'){ ?>
    <OPTION VALUE="<?php echo $params['Opcao']['valor']; ?>"<?php if($params['Opcao']['selected'] ===1){ ?> selected<?php } ?>><?php echo $params['Opcao']['titulo']; ?></OPTION>

<?php }else if($params['Tipo']==='Select_Fim'){ ?>   
    </SELECT><?php if($params['Opcao']['layoult']==='full'){ ?></li><?php } ?>  

<?php }else if($params['Tipo']==='Radio_Inicio'){ ?> 
    <div class="control-group"<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>>
    <label class="control-label" for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?>
    <?php if($params['Opcao']['js']!=''){ ?> <a href="#" onClick="<?php echo $params['Opcao']['js']; ?>" style="" class="lajax btn btn-primary">+</a><?php } ?>
    </label>
    <div class="controls">
    
<?php }else if($params['Tipo']==='Radio_Opcao'){ ?>
    <label class="<?php echo $params['Opcao']['classextra']; ?>">
        <input tabindex="<?php echo $params['TabIndex']; ?>" type="radio" name="<?php echo $params['Opcao']['id']; ?>" value="<?php echo $params['Opcao']['valor']; ?>" />
        <?php echo $params['Opcao']['titulo']; ?>
    </label>
        
<?php }else if($params['Tipo']==='Radio_Fim'){ ?>
    <?php if($params['Opcao']['end']!='' && $params['Opcao']['form_dependencia']===false){ ?><span class="help-inline"><a href="<?php echo $params['Opcao']['url']; ?><?php echo $params['Opcao']['end']; ?>?formselect=<?php echo $params['Opcao']['id']; ?>&condicao=<?php echo $params['Opcao']['condicao']; ?>" style="" class="lajax btn btn-primary" acao="">+</a></span><?php } ?></div></div>
    
<?php }else if($params['Tipo']==='CheckBox_Inicio'){ ?> 
    <div class="control-group"<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>>
    <label class="control-label" for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?>
    <?php if($params['Opcao']['js']!=''){ ?> <a href="#" onClick="<?php echo $params['Opcao']['js']; ?>" style="" class="lajax btn btn-primary">+</a><?php } ?>
    </label>
    <div class="controls">
    
<?php }else if($params['Tipo']==='Checkbox_Opcao'){ ?>
    <label class="checkbox line">
        <div class="checker" id="uniform-undefined"><span class=""><input tabindex="<?php echo $params['TabIndex']; ?>" type="checkbox" name="<?php echo $params['Opcao']['id']; ?>" value="<?php echo $params['Opcao']['valor']; ?>" style="opacity: 0;"></span></div> <?php echo $params['Opcao']['titulo']; ?>
    </label>
    
<?php }else if($params['Tipo']==='CheckBox_Fim'){ ?> 
    <?php if($params['Opcao']['end']!='' && $params['Opcao']['form_dependencia']===false){ ?><span class="help-inline"><a href="<?php echo $params['Opcao']['url']; ?><?php echo $params['Opcao']['end']; ?>?formselect=<?php echo $params['Opcao']['id']; ?>&condicao=<?php echo $params['Opcao']['condicao']; ?>" style="" class="lajax btn btn-primary" acao="">+</a></span><?php } ?></div></div>    

<?php }else if($params['Tipo']==='Final'){ ?>        
    <?php if($params['Opcao']['botao']!=''){ ?>
        <?php if($params['Opcao']['layoult']==='full'){ ?><li><label></label><?php } ?>
        <input tabindex="<?php echo $params['TabIndex']; ?>" type="submit" class="green" value="<?php echo $params['Opcao']['botao']; ?>" />
        <?php if($params['Opcao']['layoult']==='full'){ ?></li><?php } ?>
    <?php } ?>
    <?php if($params['Opcao']['layoult']==='full'){ ?>
        </ul>
    <?php } ?>
    </form>
<?php }else if($params['Tipo']==='Conteudo'){ ?>
    <li<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>><label for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?></label><?php echo $params['Opcao']['html']; ?></li>

<?php }else if($params['Tipo']==='Upload'){ ?>
    <div class="control-group"<?php if($params['Opcao']['escondido']!==false){ ?> id="<?php echo $params['Opcao']['id']; ?>_escondendo"<?php } ?><?php if($params['Opcao']['escondido']==='apagado'){ ?> style="display: none;"<?php } ?>>
        <label class="control-label" for="<?php echo $params['Opcao']['id']; ?>"><?php echo $params['Opcao']['titulo']; ?></label>
        <div class="controls">
            <div data-provides="fileupload" class="fileupload fileupload-new">
                <?php if($params['Opcao']['tipo']==='Imagem'){ ?>
                    <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail">
                        <img alt="" src="<?php if($params['Opcao']['valor']!=='' && $params['Opcao']['valor']!==false){ ?><?php echo $params['Opcao']['valor']; ?><?php }else{ ?>http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Sem+Imagem<?php } ?>">
                    </div>
                    <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                    <div>
                <?php }else{ ?>
                    <div class="input-append">
                        <div class="uneditable-input">
                            <i class="icon-file fileupload-exists"></i>
                            <span class="fileupload-preview"></span>
                        </div>
                <?php } ?>
                    <span class="btn btn-file">
                        <span class="fileupload-new">Selecione a Imagem</span>
                        <span class="fileupload-exists">Trocar</span>
                        <input tabindex="<?php echo $params['TabIndex']; ?>" type="file" name="<?php echo $params['Opcao']['nome']; ?>" id="<?php echo $params['Opcao']['id']; ?>" class="default <?php echo $params['Opcao']['class']; ?>"<?php if($params['Opcao']['escondido']==='apagar'){ ?> escondendo="desativado"<?php }else if($params['Opcao']['escondido']==='apagado'){ ?> escondendo="ativado"<?php } ?>>
                    </span>
                    <a data-dismiss="fileupload" class="btn fileupload-exists" href="#">Remover</a>
                </div>
            </div>
            <?php if(isset($params['Opcao']['Info']) && $params['Opcao']['Info']!=''){ ?>
                <?php if($params['Opcao']['info_titulo']!=''){ ?><span class="label label-important"><?php echo $params['Opcao']['info_titulo']; ?></span><?php } ?>
                <span><?php echo $params['Opcao']['info']; ?></span>
            <?php } ?>
        </div>
    </div>
            
<?php } ?>