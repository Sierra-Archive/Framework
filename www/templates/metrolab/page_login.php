<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CONFIG_PADRAO_TECLADO; ?>"/> 
    <link rel="icon" type="image/png" href="<?php echo ARQ_URL; ?>favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ricardo Rebello Sierra <contato@ricardosierra.com.br>">
    <?php echo $params['sistema']['css']; ?>
    <link href="<?php echo $params['url_css']; ?>style.css" rel="stylesheet" />
    <link href="<?php echo $params['url_css']; ?>style-responsive.css" rel="stylesheet" />
    <link href="<?php echo $params['url_css']; ?>style-default.css" rel="stylesheet" id="style_color"  />
</head>     
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="lock" style="background: url(<?php echo ARQ_URL; ?>_Sistema/fundo.jpg)no-repeat fixed;">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <a class="center" id="logo" href="<?php echo URL_PATH; ?>">
            <img class="center" alt="<?php echo SISTEMA_NOME; ?>" src="<?php echo ARQ_URL; ?>_Sistema/logo_login.<?php echo TEMA_LOGO; ?>">
        </a>
        <!-- END LOGO -->
    </div>
    <?php if(isset( $params['mensagem'] ) ){ echo $params['mensagem']; } ?>
            <form action="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>" method="POST">
        <div class="login-wrap" style="max-width:480px;">
            <div class="metro single-size <?php echo CFG_LP_LOGINCOR1; ?>">
                <div class="locked">
                    <i class="fa fa-lock"></i>
                    <span><?php _e('Identificação'); ?></span>
                </div>
            </div>
            <div class="metro double-size <?php echo CFG_LP_LOGINCOR2; ?>">
                <div class="input-append lock-input">
                    <input type="text" class="" id="sistema_login" name="sistema_login" placeholder="<?php _e('Digite seu Usuário'); ?>" autofocus >
                </div>
            </div>
            <div class="metro double-size <?php echo CFG_LP_LOGINCOR3; ?>">
                <div class="input-append lock-input">
                    <input type="password" class="" id="sistema_senha" name="sistema_senha" placeholder="<?php _e('Digite sua Senha'); ?>">
                </div>
            </div>
            <div class="metro single-size <?php echo CFG_LP_LOGINCOR4; ?> login">
                <button type="submit" class="btn login-btn">
                    Entrar
                    <i class="fa fa-long-arrow-right"></i>
                </button>
            </div>
            <div class="login-footer">
                <div class="remember-hint pull-left">
                    <input type="checkbox" id=""> <?php _e('Lembrar Login');?>
                </div>
                <div class="forgot-hint pull-right">
                    <a id="forget-password" class="" href="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>?sistema_esquecisenha=true"><?php _e('Esqueceu sua senha?');?></a>
                </div>
            </div>
        </div>
    </form>
   <!-- END FOOTER -->  
</body>
<!-- END BODY -->
</html>