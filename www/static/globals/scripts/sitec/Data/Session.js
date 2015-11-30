var DataSession  = {
    cache: [],
    /**
    * 
    * @param {type} needle
    * @param {type} haystack
    * @returns {Boolean}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
    */
    read: function(nome) {
        if(this.cache['SierraTec_'+nome]!=undefined) {
            return this.cache['SierraTec_'+nome][1];
        }
        return false;
    },
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    save: function(nome,valor) {
        this.cache['SierraTec_'+nome] = new Array('SierraTec_'+nome,valor);
        return true;
    },
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    del: function(nome) {
        if(nome===false) {
            this.cache = {};
        } else {
            this.cache['SierraTec_'+nome] = undefined;
        }
        return true;
    },
    init: function (id) {
        //this.create(id);
    }
}

