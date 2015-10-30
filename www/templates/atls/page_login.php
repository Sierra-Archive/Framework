<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if ($params['site_titulo']=='') { echo __('Sem Titulo'); } else { echo $params['site_titulo']; } ?></title>
    <meta charset="<?php echo CONFIG_PADRAO_TECLADO; ?>">
    <link rel="icon" type="image/png" href="<?php echo ARQ_URL; ?>favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ricardo R. Sierra <contato@ricardosierra.com.br>">
    
    
   
    
    <?php echo $params['sistema']['css']; ?>

    <!-- Mobile Specific Metas ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS ================================================== -->

    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>style.css">
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>colors.css">
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>skeleton.css">
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>layout.css">
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>ddsmoothmenu.css"/>
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>elastislide.css"/>
    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>home_flexslider.css"/>

    <link rel="stylesheet" href="<?php echo $params['url_css']; ?>light_box.css"/>
    <link href="../../../html5shiv.googlecode.com/svn/trunk/html5.js">
    <link rel="stylesheet" type="text/css" href="calendar_v6.css"><!--calendário-->
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>     
<body>
 <body class="lock" style="background: url(<?php echo ARQ_URL; ?>_Sistema/fundo.jpg)no-repeat fixed;">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <a class="center" id="logo" href="<?php echo URL_PATH; ?>">
            <img class="center" alt="logo" src="<?php echo ARQ_URL; ?>_Sistema/logo_login.<?php echo TEMA_LOGO; ?>">
        </a>
        <!-- END LOGO -->
    </div>
    <?php if (isset( $params['mensagem'] ) ) { echo $params['mensagem']; } ?>
    <form action="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>" method="POST">
        <div class="login-wrap" style=" margin: auto; max-width:480px;">
            <div class="metro single-size <?php echo CFG_LP_LOGINCOR1; ?>">
                <div class="locked">
                    <i class="fa fa-lock"></i>
                    <span>Identificação</span>
                </div>
            </div>
            <div class="metro double-size <?php echo CFG_LP_LOGINCOR2; ?>">
                <div class="input-append lock-input">
                    <input type="text" class="" id="sistema_login" name="sistema_login" placeholder="Usuário" autofocus >
                </div>
            </div>
            <div class="metro double-size <?php echo CFG_LP_LOGINCOR3; ?>">
                <div class="input-append lock-input">
                    <input type="password" class="" id="sistema_senha" name="sistema_senha" placeholder="Senha">
                </div>
            </div>
            <div class="metro single-size <?php echo CFG_LP_LOGINCOR4; ?> login">
                <button type="submit" class="btn login-btn">
                    Entrar
                    <i class="fa fa-long-arrow-right"></i>
                </button>
            </div><!--
            <div class="metro double-size navy-blue ">
                <a href="index.html" class="social-link">
                    <i class="fa fa-facebook-sign"></i>
                    <span>Facebook Login</span>
                </a>
            </div>
            <div class="metro single-size deep-red">
                <a href="index.html" class="social-link">
                    <i class="fa fa-google-plus-sign"></i>
                    <span>Google Login</span>
                </a>
            </div>
            <div class="metro double-size blue">
                <a href="index.html" class="social-link">
                    <i class="fa fa-twitter-sign"></i>
                    <span>Twitter Login</span>
                </a>
            </div>
            <div class="metro single-size purple">
                <a href="index.html" class="social-link">
                    <i class="fa fa-skype"></i>
                    <span>Skype Login</span>
                </a>
            </div>-->
            <div class="login-footer">
                <div class="remember-hint pull-left">
                    <input type="checkbox" id=""> Lembrar Login
                </div>
                <div class="forgot-hint pull-right">
                    <a id="forget-password" class="" href="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>?sistema_esquecisenha=true">Esqueceu sua senha?</a>
                </div>
            </div>
        </div>
    </form>
   
   
    <script type="text/javascript">console.time('Sistema');</script>   
    <?php echo $params['sistema']['extras']; ?>
    <script src="<?php echo $params['url_js']; ?>extra.js"></script>
    
    
    
    
    <!--Ver detalhes Block-->
    <script type="text/javascript">
    jQuery (function() {
        var tabContainers=jQuery('div.tabs > div');
        tabContainers.hide().filter(':first').show();
        jQuery('div.tabs ul.tabNavigation a').click(function() {
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            jQuery('div.tabs ul.tabNavigation a').removeClass('selected');
            jQuery(this).addClass('selected');
            return false;
        }).filter(':first').click();
    });
    </script>
    
    

    <!--js
    <script src="<?php echo $params['url_js']; ?>jquery-1.8.2.min.js"></script>-->
    <script src="<?php echo $params['url_js']; ?>common.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.easing.1.3.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.flexslider.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.elastislide.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.jcarousel.min.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.accordion.js"></script>
    <script src="<?php echo $params['url_js']; ?>light_box.js"></script>
    <script type="text/javascript">$(document).ready(function() {$(".inline").colorbox({inline:true, width:"50%"});});</script>
    <!--end js-->
    
    
    <script type="text/javascript">console.timeEnd('Sistema');</script>
</body>
</html>