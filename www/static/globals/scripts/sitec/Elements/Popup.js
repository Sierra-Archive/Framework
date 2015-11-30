var ElementsPopup  = {

    /**
     * FUNCOES DE RETORNO
     * 
     * @param {type} id
     * @returns {undefined}@author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    Control_Ajax_Popup_Fechar: function (id) {
        var identificador = $(document.getElementById(id)).removeClass('in');
        window.setTimeout(function () {
            identificador.css('display','none');
        }, 500);
    },

    init: function (id) {
        //this.create(id);
    }
}

