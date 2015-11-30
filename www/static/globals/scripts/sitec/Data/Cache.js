var DataCache  = {

    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    read: function(nome) {
        if (Modernizr.localstorage===true) {
            if (window.localStorage.getItem('SierraTec_'+nome)) {
                return window.localStorage.getObject('SierraTec_'+nome);
            }
            return false;
        } else {
            return DataSession.read(nome);
        }
    },
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    save: function(nome,valor) {
        if (Modernizr.localstorage) {
            try { 
                window.localStorage.setObject('SierraTec_'+nome, valor);
            } catch(e) {
                console.log(e);
                return false;
            }
            return true;
        } else {
            return DataSession.save(nome,valor);
        }
    },
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    del: function(nome) {
        if (Modernizr.localstorage) {
            if(nome===false) {
                window.localStorage.clear();
            } else {
                window.localStorage.removeItem('SierraTec_'+nome);
            }
            return true;
        } else {
            return DataSession.del(nome);
        }
    },
    init: function (id) {
        //this.create(id);
    }
}

