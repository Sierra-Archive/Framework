var Json = function (Link, Json, History) {
    
    /**
     * FUNCOES DE RETORNO
     * 
     * @param {type} id
     * @returns {undefined}@author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Popup_Fechar (id) {
        var identificador = $(document.getElementById(id)).removeClass('in');
        window.setTimeout(function () {
            identificador.css('display','none');
        }, 500);
    };
    /**
     * ['Popup']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Popup (json) {
        var head        = '',
            body        = '',
            footer      = '',
            popup       = $(document.getElementById(json['id'])),
            popup2      = popup.children(".modal-dialog").children(".modal-content"),
            i           = 0,
            tam = Object.keys(json['botoes']).length;
        // Percorre Botoes e os fazem
        for(; i<tam; ++i){
            if (json['botoes'][i]['clique'] === '$( this ).dialog( "close" );') {
                footer += '<button class="btn" data-dismiss="modal" aria-hidden="true" onCLick="Sierra.Control_Ajax_Popup_Fechar(\''+json["id"]+'\');">'+json['botoes'][i]['text']+'</button>';
            } else {
                footer += '<button class="btn btn-primary" onClick="'+json['botoes'][i]['clique']+'">'+json['botoes'][i]['text']+'</button>';
            }
        }
        popup2.children(".modal-header").children("#popuptitulo").html(json['title']);
        popup2.children(".modal-body").html('<div class="row">'+json['html']+'</div>');
        popup2.children(".modal-footer").html(footer);
        popup.css('display','block').addClass('in');
    };
    /**
     * ['Conteudo']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Conteudo (json) {
        var cod         = '',
            script      = '';
    
        for (var i in json){
            if(json[i] !== undefined){
                $(json[i]['location']).html(json[i]['html']);
                script += json[i]['js'];
            }
        }
        if (script !== '') {
            $('body').append('<script type="text/javascript">'+script+'</script>');
        }
    };
    /**
     * ['Redirect']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Redirect (json) {
        var cod         = '',
            script      = '',
            url         = [];
    
        for (var i in json){
            if(json[i] !== undefined){
                url = json[i]['Url'];
                
                Sierra.Modelo_Ajax_Chamar(url,'','get',true,true,true);
            }
        }
    };
    /**
     * ['Select']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Select (json) {
        var i           = 0,
            tam         = Object.keys(json).length,
            i2          = 0,
            tam2,
            identificador;
        for (var i in json){
            identificador = $(document.getElementById(json[i]['id']));
            tam2 = Object.keys(json[i]['valores']).length;
            identificador.find('option').remove();
            for(; i2<tam2; ++i2){
                identificador.append(
                    new Option(
                        json[i]['valores']['nome'], 
                        json[i]['valores']['valor'], 
                        true, 
                        true
                    )
                );
            }
        }
    };
    /**
     * ['JavascriptInterno']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Css (json) {
        var script      = '',
            cache = Cache_Ler('Dependencias_Css');
    
        if(cache===false){
            cache = new Array();
        } else {
            cache = cache.split('|');
        }
        for (var i in json){
            // VErifica se ja esta carregado
            if(!inArray(json[i],cache)){
                // Adiciona ao Cache
                cache.push(json[i]);
                
                if (script !== ''){
                    script += ',';
                }
                script += json[i]+'.css';
            }
        }
        if (script !== '') {
            // Salva Cache
            Cache_Gravar('Dependencias_Css',cache.join('|'));
            
            $('head').append('<link href="'+ConfigArquivoPadrao+'static/min/?f='+script+'" rel="stylesheet" />');
        }
    };
    /**
     * ['JavascriptInterno']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_JavascriptInterno (json) {
        var script      = '';
        for (var i in json){
            script += json[i];
        }
        if (script !== '') {
            $('body').append('<script type="text/javascript">'+script+'</script>');
        }
    };
    /**
     * ['Javascript']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Javascript (json) {
        var script = '',
            cache = Sierra.Cache_Ler('Dependencias_Js');
    
        if(cache===false){
            cache = new Array();
        } else {
            cache = cache.split('|');
        }
        
        for (var i in json){
            // VErifica se ja esta carregado
            if(!inArray(json[i],cache)){
                // Adiciona ao Cache
                cache.push(json[i]);
                
                if (script !== ''){
                    script += ',';
                }
                // ADiciona ao codigo
                script += json[i]+'.js';
            }
        }
        
        if(script!==''){
            // Salva Cache
            Sierra.Cache_Gravar('Dependencias_Js',cache.join('|'));

            $('head').append('<script type="text/javascript" src="'+ConfigArquivoPadrao+'static/min/?f='+script+'"></script>');
        }
        //eval(cod);
    };
    /**
     * ['Mensagens']
     * @param {type} json
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Ajax_Mensagens (json) {
        var cod = '';
        for (var i in json){
            Sierra.Control_PopMgs_Abrir(json[i]['tipo'],json[i]['mgs_principal'],json[i]['mgs_secundaria']);
        }
        return true;
    };
    function Modelo_Ajax_JsonTratar(url, data, navegador){
        var cod = '',
            i   = 0,
            tam;
        if (data !== null && typeof(data) === "object") {
            // Verifica se foi chamado pelo historico do navegador
            if (typeof(navegador) === "undefined") {
                navegador = false; //False
            }
            // Verifica Titulo
            if (data['Info']['Titulo'] !== '') {
                document.title = data['Info']['Titulo'];
                document.getElementById('Framework_Titulo').innerHTML = data['Info']['Titulo'];
            }
            // Atualiza Link se tiver historico e nao for via navegador
            if (navegador === false && data['Info']['Historico'] === true) {
                Control_Link_Atualizar(url/*, data*/);
            }
            // Chama os Tipos de Json
            tam = Object.keys(data['Info']['Tipo']).length;
            for(;i<tam;++i){
                cod += 'Control_Ajax_'+data['Info']['Tipo'][i]+'(data[\''+data['Info']['Tipo'][i]+'\']);';
            }
            eval(cod);
            Control_Layoult_Recarrega();
        }else if(typeof(data) === "string"){
            Modelo_Ajax_JsonTratar(url, JSON.parse(data), navegador);
        } else {
            console.log('Erro',data);
            return false;
        }
    }
    
    return Modelo_Ajax_JsonTratar(Link, Json, History);
};