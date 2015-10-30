<?php

class _Sistema_ImgControle extends _Sistema_Controle
{
    public function __construct() {
        parent::__construct();
    }
    public function Main($codigo) {
    }
    public function Redimensionar($img = false,$width = 50,$height = 50) {
        // Carrega a imagem de um arquivo
	$img = WideImage::loadFromFile('imagens/minha_foto.jpg');
        // Redimensiona a imagem para preencher um quadrado de 350x200px
	$img = $img->resize($width, $height, 'outside');
        // Corta um quadrado de 100x80px no meio da imagem
	$img = $img->crop('50% - '.(round($width/2)), '50% - '.(round($height/2)), $width, $height);

        /*// Salva a imagem em um novo arquivo com 80% de qualidade
        $img->saveToFile('/imagens/minha_foto_menor.jpg', null, 80);*/

        // Define o tipo de cabeçalho para exibir a imagem corretamente
	header("Content-type: image/jpeg");
	// Envia a imagem para o navegador com 80% de qualidade
	$img->asString('jpg', 80);
    }
}
?>