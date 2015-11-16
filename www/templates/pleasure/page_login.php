<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if ($params['site_titulo']=='') { echo __('Sem Titulo'); } else { echo $params['site_titulo']; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CONFIG_PADRAO_TECLADO; ?>"/> 
    <link rel="icon" type="image/png" href="<?php echo ARQ_URL; ?>favicon.ico"/>
    <meta name="description" content="">
    <meta name="author" content="Ricardo Rebello Sierra <contato@ricardosierra.com.br>">
    <?php echo $params['sistema']['css']; ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- BEGIN CORE CSS -->
    <link rel="stylesheet" href="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/admin1/css/admin1.css">
    <link rel="stylesheet" href="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/css/elements.css">
    <!-- END CORE CSS -->

    <!-- BEGIN PLUGINS CSS -->
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>globals/components/bootstrap-social/bootstrap-social.css">
    <!-- END PLUGINS CSS -->

    <!-- FIX PLUGINS -->
    <link rel="stylesheet" href="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/css/plugins.css">
    <!-- END FIX PLUGINS -->

    <!-- BEGIN SHORTCUT AND TOUCH ICONS -->
    <link rel="shortcut icon" href="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/img/icons/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/img/icons/apple-touch-icon.png">
    <!-- END SHORTCUT AND TOUCH ICONS -->
</head>     
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="bg-login printable" style="background: url(<?php echo ARQ_URL; ?>_Sistema/fundo.jpg)no-repeat fixed;">
    <?php if (isset( $params['mensagem'] ) ) { echo $params['mensagem']; } ?>
    <form action="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>" method="POST">


	<div class="login-screen">
		<div class="panel-login blur-content">
			<div class="panel-heading"><a class="center" id="logo" href="<?php echo URL_PATH; ?>"><img class="center" alt="<?php echo SISTEMA_NOME; ?>" src="<?php echo ARQ_URL; ?>_Sistema/logo_login.<?php echo TEMA_LOGO; ?>" height="100"></a></div><!--.panel-heading-->

			<div id="pane-login" class="panel-body active">
				<h2><?php _e('Identificação'); ?></h2>
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="text" name="sistema_login" class="form-control" placeholder="<?php _e('Digite seu Usuário'); ?>" autofocus>
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="password" name="sistema_senha" class="form-control" placeholder="<?php _e('Digite sua Senha'); ?>">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-buttons clearfix">
					<label class="pull-left"><input type="checkbox" name="remember" value="1"> <?php _e('Lembrar Login'); ?></label>
					<button type="submit" class="btn btn-success pull-right">Login</button>
				</div><!--.form-buttons-->

				<?php /*<div class="social-accounts">
					<div class="btn-group btn-merged btn-group-justified">
						<div class="btn-group">
							<a class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
						</div>
						<div class="btn-group">
							<a class="btn btn-social btn-github"><i class="fa fa-github"></i> Github</a>
						</div>
					</div>
				</div><!--.social-accounts--> */?>

				<ul class="extra-links">
					<li><a class="show-pane-forgot-password" href="#"><?php _e('Esqueceu sua senha?');?></a></li>
					<?php /*<li><a href="#" class="show-pane-create-account">Create a new account</a></li>*/ ?>
				</ul>
			</div><!--#login.panel-body-->

			<div id="pane-forgot-password" class="panel-body">
                            <h2><?php _e('Esqueci minha Senha'); ?></h2>
                            <form id="FormEsqueciSenha" action="<?php echo URL_PATH.SISTEMA_DIR_INT; ?>?sistema_esquecisenha= TRUE" method="post" enctype="multipart/form-data" autocomplete="on">
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="email" class="form-control" placeholder="<?php _e('Digite seu Email'); ?>">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-buttons clearfix">
					<button type="submit" class="btn btn-white pull-left show-pane-login"><?php _e('Cancelar'); ?></button>
					<button type="submit" class="btn btn-success pull-right"><?php _e('Enviar'); ?></button>
				</div><!--.form-buttons-->
                            </form>
			</div><!--#pane-forgot-password.panel-body-->

			<?php /*<div id="pane-create-account" class="panel-body">
				<h2>Create a New Account</h2>
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="text" class="form-control" placeholder="Enter your full name">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="email" class="form-control" placeholder="Enter your email address">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="password" class="form-control" placeholder="Enter your password">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-group">
					<div class="inputer">
						<div class="input-wrapper">
							<input type="password" class="form-control" placeholder="Enter your password again">
						</div>
					</div>
				</div><!--.form-group-->
				<div class="form-group">
					<label><input type="checkbox" name="remember" value="1"> I have read and agree to the term of use.</label>
				</div>
				<div class="form-buttons clearfix">
					<button type="submit" class="btn btn-white pull-left show-pane-login">Cancel</button>
					<button type="submit" class="btn btn-success pull-right">Sign Up</button>
				</div><!--.form-buttons-->
			</div><!--#login.panel-body-->*/ ?>

		</div><!--.blur-content-->
	</div><!--.login-screen-->
    </form>
    <div class="bg-blur dark">
            <div class="overlay"></div><!--.overlay-->
    </div><!--.bg-blur-->

    <svg version="1.1" xmlns='http://www.w3.org/2000/svg'>
            <filter id='blur'>
                    <feGaussianBlur stdDeviation='7' />
            </filter>
    </svg>

    <!-- BEGIN GLOBAL AND THEME VENDORS -->
    <script src="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/js/global-vendors.js"></script>
    <!-- END GLOBAL AND THEME VENDORS -->

    <!-- BEGIN PLUGINS AREA -->
    <!-- END PLUGINS AREA -->

    <!-- PLUGINS INITIALIZATION AND SETTINGS -->
    <script src="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/scripts/user-pages.js"></script>
    <!-- END PLUGINS INITIALIZATION AND SETTINGS -->

    <!-- PLEASURE Initializer -->
    <script src="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/globals/js/pleasure.js"></script>
    <!-- ADMIN 1 Layout Functions -->
    <script src="<?php echo \Framework\App\Visual::get_template_url(); ?>assets/admin1/js/layout.js"></script>

    <!-- BEGIN INITIALIZATION-->
    <script>
    $(document).ready(function () {
            Pleasure.init();
            Layout.init();
            UserPages.login();
    });
    </script>
    <!-- END INITIALIZATION-->
    <?php echo $params['sistema']['extras']; ?>
</body>
<!-- END BODY -->
</html>