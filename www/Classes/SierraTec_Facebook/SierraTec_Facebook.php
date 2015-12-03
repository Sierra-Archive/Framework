<?php
namespace Framework\Classes;

//requisita a biblioteca
require_once  LIBS_PATH.'facebook.php';

class SierraTec_Facebook {
    
    /**
     * Armazena a Classe Registro (Classe singleton, ela garante a existencia de apenas uma instancia de cada classe)
     * @var Object 
     */
    protected $_Registro = false;
    protected $db = false;
    
    public $facebook;
    public $login = array(
            'scope' => 'read_stream, friends_likes, read_mailbox',
            'redirect_uri' => 'https://localhost/autocontrole/sistema.php'
           );
    private $user_id;
    private $user_profile;
    private $model;
    private $Visual;
    /*
    * 
    * @Params {autorizacao (0->face nao logado, 1-> facenaoconfere com cadastro original, 2->Autorizado)}
    */
    public function __construct($faceid = '1425023667768754', $autorizacao = '3fc791cc908fb3baa644e2f2d0e62957') {
        $this->_Registro = &\Framework\App\Registro::getInstacia();
        $this->db = &$this->_Registro->_Conexao;
        
        //criamos a instancia da nossa aplicacao
        $this->facebook = new \Facebook(array(
            'appId'  => $faceid,
            'secret' => $autorizacao
        ));
        $this->user_id = $this->facebook->getUser();

        if ($this->user_id /*&& $faceid==$this->user_id*/) {

            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.
            try {
              // Carrega permissoes e verifica se a possui
              $permissions = $this->facebook->api("/me/permissions");
              // se nao contem permissao, pede ela
               if (!array_key_exists('read_mailbox', $permissions['data'][0])) {
                       /* solicita permissão */
                       header( "Location: " . $this->facebook->getLoginUrl(array("scope" => "read_mailbox")) );
                       exit;
               }
               $autorizacao = 2;


            } catch(FacebookApiException $e) {
              if ($autorizacao!=2) {
                  // If the user is logged out, you can have a 
                  // user ID even though the access token is invalid.
                  // In this case, we'll get an exception, so we'll
                  // just ask the user to login again here.
                  error_log($e->getType());
                  error_log($e->getMessage());
                  $autorizacao = 0;
              }
            }
        } else if ($faceid!=$this->user_id && $this->user_id) {
          $autorizacao = 1;
        } else {
          $autorizacao = 0;

        }
    } 
    public function Armazena() {
        // captura informacoes de profile
        $this->user_profile = $this->facebook->api('/me', 'GET');

        // Captura e Armazena mensagnes
        //$inbox = $this->facebook->api($this->user_id.'?fields=inbox');
        //$this->Armazena_Conversas($inbox['inbox']['data']);
        $inbox = $this->facebook->api($this->user_id.'/inbox?limit=0');
        $this->Armazena_Conversas($inbox['data']);
        // armazena outras paginas
        for($i=0;$i<2; ++$i) {
             $inbox['paging']['next'] = explode($this->user_id.'/', $inbox['paging']['next']);
             $inbox['paging']['next'] = $inbox['paging']['next'][1];
             $inbox = $this->facebook->api($this->user_id.'/'.$inbox['paging']['next']);
             $this->Armazena_Conversas($inbox['data']);
        }
    }
    /*
     * Captura Mensagens Trazidas do face e faz backup local
     * @Params $conversas($facebook['imbox']['data'])
     */
    private function Armazena_Conversas($conversas) {
        // percorre todas as conversas
        if (is_array($conversas)) {
            foreach ($conversas as $i => $valor) {
                // foreach com as conversas
                if (is_array($conversas[$i]['comments']['data'])) {
                    foreach ($conversas[$i]['comments']['data'] as $j => $valor2) {
                        $mensagemid = explode('_', $conversas[$i]['comments']['data'][$j]['id']);
                        $mensagemid = $mensagemid[1];
                        $this->Armazena_Conversas_Inserir($conversas[$i]['id'], $conversas[$i]['to']['data'][0]['id'], $conversas[$i]['to']['data'][1]['id'], $conversas[$i]['updated_time'], $conversas[$i]['unread'], $mensagemid, $conversas[$i]['comments']['data'][$j]['from']['name'], $conversas[$i]['comments']['data'][$j]['from']['id'], $conversas[$i]['comments']['data'][$j]['message'], $conversas[$i]['comments']['data'][$j]['created_time']);
                    }
                }
            }
        }

    }
    private function Armazena_Conversas_Inserir($conversaid, $meuid, $idamigo, $dataleitura, $lida, $mensagemid, $mensagemusername, $mensagemuserid, $mensagem, $datamensagem) {
        if ($meuid=='')     $meuid = 0;
        if ($idamigo=='') $idamigo = 0;
        // VERIFICA SE CONVERSA JA ESTA REGISTRADA SE NAO TIVER CADASTRA ELA NO DBA
        $contador = 0;
        $sql = $this->db->query('SELECT id FROM '.MYSQL_SOCIAL_HIST_FACE.' WHERE deletado!=1 AND id='.$conversaid.' AND faceid1='.$meuid.' AND faceid2='.$idamigo.'');
        while ($campo = $sql->fetch_object()) {
            ++$contador;
        }
        if ($contador==0) {
            $this->db->query('INSERT INTO '.MYSQL_SOCIAL_HIST_FACE.' (id, faceid1, faceid2, updated_time, unread) VALUES (\''.$conversaid.'\',\''.$meuid.'\',\''.$idamigo.'\',\''.$dataleitura.'\',\''.$lida.'\')');
        }

        // VERIFICA SE A MENSAGEM DA CONVERSA  JA ESTA REGISTRADA SE NAO TIVER CADASTRA ELA NO DBA
        $contador = 0;
        $sql = $this->db->query('SELECT id FROM '.MYSQL_SOCIAL_HIST_FACE_MGS.' WHERE deletado!=1 AND id='.$mensagemid.' AND conversaid='.$conversaid.' AND criacao=\''.$datamensagem.'\'');
        while ($campo = $sql->fetch_object()) {
            ++$contador;
        }
        if ($contador==0) {
            $this->db->query('INSERT INTO '.MYSQL_SOCIAL_HIST_FACE_MGS.' (id, fromname, fromid, message, criacao, conversaid) VALUES (\''.$mensagemid.'\',\''.$mensagemusername.'\',\''.$mensagemuserid.'\',\''.$mensagem.'\',\''.$datamensagem.'\',\''.$conversaid.'\')');
        }
        return 1;
    } 
    /*
     * Captura Amigos Trazidos do face e faz backup local
     * @Params $conversas($facebook['imbox']['data'])
     */
    private function Armazena_Amigos($conversas) {

    }
}