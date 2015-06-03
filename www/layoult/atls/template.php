<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></title>
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
    <div class="mainContainer sixteen container">
        <!--Header Block-->
        <div class="header-wrapper">
            <header class="container">
                <div class="head-right">
                    <?php if(isset($params['widgets']['Superior'])){ 
                        $total=count($params['widgets']['Superior']); 
                        for($cont=0;$cont<$total; ++$cont) {  
                            echo $params['widgets']['Superior'][$cont];
                        } ?>
                        <!-- END SUPPORT -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <?php echo $params['template']['usuario']; 
                     }?>
                    <section class="header-bottom" style="clear:both;">
                        <div class="search-block" style="float:left;">
                            <input type="text" value="" placeholder="Procurar" />
                            <input type="submit" value="" title="Search" />
                        </div>
                    </section>
                </div>
                <h1 class="logo">
                    <a href="index.php" title="Logo">
                        <img title="Logo" alt="Logo" src="<?php echo ARQ_URL; ?>_Sistema/logo.png" />
                    </a>
                </h1>
                <?php echo $params['template']['menu']; ?>

            </header>
        </div>

        <h1 class="page-title">
            <span id="Framework_Titulo"><?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></span>
        </h1>
        <?php 
        /*if(isset($params['widgets']) && isset($params['widgets']['Navegacao_Endereco'])){
            echo '<span class="breadcrumb">'.
                 $params['widgets']['Navegacao_Endereco'].
                 '</span>'; 
        }*/
        ?>

        <!--Banner Block-->
        <section class="banner-wrapper" id="blocounico"<?php if( $params['template']['Bloco_Unico']==''){ ?> style="display: none;"<?php } ?>>
            <?php echo $params['template']['Bloco_Unico']; ?>
        </section>
        <!--Content Block-->

        <section class="content-wrapper">
            <div class="content-container container">
                <div class="col-main-left" id="blocomaior"<?php if( $params['template']['Bloco_Maior']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Maior']; ?>
                </div>
                <aside class="right-sidebar" id="blocomenor"<?php if( $params['template']['Bloco_Menor']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Menor']; ?>
                </aside>
            </div>
        </section>
    </div>      
    <!--Footer Block-->
    <section class="footer-wrapper">
        <footer class="container">
            <div class="link-block"><!--
                <ul>
                  <li class="link-title"><a href="about_us.html" title="ABOUT US">INFORMAÇÕES</a></li>
                  <li><a href="#" title="Ajuda">Ajuda</a></li>

                </ul>

                <ul>
                  <li class="link-title"><a href="#" title="FALE CONOSCO">FALE CONOSCO</a></li>

                  <li><a href="contato.php" title="Contato">Contato</a></li>
                </ul>

                <ul>
                  <li class="link-title"><a href="#" title="TERMS & CONDITIONS">TERMOS E CONDIÇÕES</a></li>

                  <li><a href="#" title="Termos e Conditições">Termos e Conditições</a></li><br/><br/><br/><br/><br/>
                  <div class="payment-block"><img src="<?php echo $params['url_img']; ?>payment.png" alt="payment"></div>
                </ul>
                <ul>

                  <li class="link-title"><a href="#" title="ABOUTUS">SOBRE NÓS</a></li>
                  <li class="aboutus-block">Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit. Vivamus sit
                    amet ligula lectus, a mollis diam. Nulla
                    porttitor pulvinar elit... <a href="sobre.php" title="read more">leia mais</a> </li>
                </ul>

                <!--<ul class="stay-connected-blcok">

                       <ul class="social-links" style="margin-top: -67px;">
                          <li><a data-tooltip="Like us on facebook" href="#"><img alt="facebook" src="<?php echo $params['url_img']; ?>facebook.png"></a></li>
                          <li><a data-tooltip="Subscribe to RSS feed" href="#"><img alt="RSS" src="<?php echo $params['url_img']; ?>rss.png"></a></li>
                          <li><a data-tooltip="Follow us on twitter" href="#"><img alt="twitter" src="<?php echo $params['url_img']; ?>twitter.png"></a></li>
                          <li><a data-tooltip="Follow us on Dribbble" href="#"><img alt="dribbble" src="<?php echo $params['url_img']; ?>dribbble.png"></a></li>
                          <li><a data-tooltip="Follow us on Youtube" href="#"><img alt="youtube" src="<?php echo $params['url_img']; ?>youtube.png"></a></li>
                          <li><a data-tooltip="Follow us on skype" href="#"><img alt="skype" src="<?php echo $params['url_img']; ?>skype.png"></a></li>
                       </ul>
                  </li>
                </ul>-->
            </div>
            <div class="footer-bottom-block">
                <!--<ul class="bottom-links">
                  <li><a href="index.php" title="Home">HOME</a></li>
                  <li><a href="sobre.php" title="Empresa">EMPRESA</a></li>
                  <li><a href="faq.php" title="Faq">FAQ</a></li>
                  <li><a href="contato.php" title="Contato">CONTATO</a></li>
                </ul>-->
                <p class="copyright-block">© 2015 <?php echo SISTEMA_NOME; ?> - Direitos <?php echo SOBRE_DIREITOS; ?>.</p>
            </div>
        </footer>
    </section>


   
   
   
    <script type="text/javascript">console.time('Sistema');</script>   
    <?php echo $params['sistema']['extras']; ?>
    <script src="<?php echo $params['url_js']; ?>extra.js"></script>
    
    
    
    
    <!--Ver detalhes Block-->
    <script type="text/javascript">
    jQuery (function(){
        var tabContainers=jQuery('div.tabs > div');
        tabContainers.hide().filter(':first').show();
        jQuery('div.tabs ul.tabNavigation a').click(function(){
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
    <script src="<?php echo $params['url_js']; ?>ddsmoothmenu.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.flexslider.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.elastislide.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.jcarousel.min.js"></script>
    <script src="<?php echo $params['url_js']; ?>jquery.accordion.js"></script>
    <script src="<?php echo $params['url_js']; ?>light_box.js"></script>
    <script type="text/javascript">$(document).ready(function(){$(".inline").colorbox({inline:true, width:"50%"});});</script>
    <!--end js-->
    
    
    <script type="text/javascript">console.timeEnd('Sistema');</script>
</body>
</html>