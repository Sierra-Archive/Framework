var NavigationCall  = {
    openConnectionUrl: new Array(), 
    contConnection: 0, 
    siteLoading: false, 

    /**
    * Atualiza Hash e Historico
    * 
    * @param {type} url
    * @param {type} data
    * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
    */
    checkDuplicationClick: function (url) {
        if ($.inArray(url,this.openConnectionUrl)===-1) {
            return false;
        }
        return true;
    },
    openConnection: function (url,loading) {
        // Se contador for Nulo Abre Carregando
        if(this.contConnection===0){
            this.loadingOpen(loading);
        }
        
        this.contConnection = this.openConnectionUrl.push(url);
        return true;
    },
    closeConnection: function (url,loading) {
        this.openConnectionUrl.splice($.inArray(url,this.openConnectionUrl), 1);
        this.contConnection = this.contConnection-1;
        // Se contador for Nulo Abre Carregando
        if(this.contConnection===0){
            this.loadingClose(loading);
        }
        return true;
    },
    
    
    /**
     * 
     * @param {type} tipo
     * @returns {undefined}
     */
    loadingOpen: function (loading) {
        if(loading===true) {
            NProgress.start();
            this.siteLoading = true;
        }
    },
    loadingClose: function (loading) {
        if(loading===true) {
            this.siteLoading = false;
            NProgress.done();
        }
    },
    /**
     * 
     * @param {type} url
     * @param {type} params
     * @param {type} tip
     * @param {type} resposta
     * @param {type} historico 
     * @param {bool} carregando caso true aparece mensagem carregando
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    init: function (url, params, tip, resposta, historico, carregando) {
        console.log(this.contConnection,this.openConnectionUrl);
        console.time('Acao_LINK');
        
        // Impede Duplo Clique para Preservar a integridade do sistema
        if (this.checkDuplicationClick(url)) {
            return false;
        } else {
            this.openConnection(url, carregando);
        }
        
        
        var retorno = false;
        //retorno = DataCache.read(url);
        if(retorno!==false) {
            Json(url,retorno,historico);
        } else {
            /* 
            * XMLHttpRequest2 (html5) -> Opera Mini ainda nao suporta, nao usar por enquanto
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
              //done
            }
            xhr.open("GET", "http://jsperf.com");
            xhr.send(null);
             */
            // Verifica se Contem http ou www se nao tiver acrescenta url do sistema
            if(url.indexOf('http://') === -1 && url.indexOf('www.') === -1) {
                url = ConfigArquivoPadrao+url;
            }
            
            $.ajax(
                { 
                    type: tip,
                    url: url,
                    async: true,
                    dataType: 'json',
                    data: params
                }
            ).done(
                function (data) {
                    if (resposta === true) {
                        //DataCache.save(url,data);
                        JsonTratar(url,data,historico);
                    }
                }
            ).fail(
                function(req) {
                    // Trata o Erro
                    if(req.status === 200 && resposta===true) {
                        console.log('NavigationCall.init -> Chamando Erro');
                        // Caso Pagina Exista, mas JSON Esteja incorreto
                        NavigationCall.init('_Sistema/erro/Javascript','html='+req.responseText,'POST',false,false,false);
                    } else {
                        // Página não existe
                    }
                }
            ).always(function() {
                NavigationCall.closeConnection(url, carregando);
            });
        }
    }
}

