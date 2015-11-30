var NavigationUrl  = {
    SiteHash: '', 
    historyControl: '0', 

    /**
    * Atualiza Hash e Historico
    * 
    * @param {type} url
    * @param {type} data
    * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
    */
    update: function (url/*, data*/) {
        if (url !== this.SiteHash) {
            this.SiteHash = url;
            //Historico
            var aleatorio = Math.random();
            this.historyControl = aleatorio;
            History.pushState({/*json: data,*/id: aleatorio}, document.title, url);
            //window.location.hash = url;
        }
    },

    init: function (id) {
        //this.create(id);
    }
}

