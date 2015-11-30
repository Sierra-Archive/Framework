var DataCookie  = {
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    save: function(name,value) {    //função universal para criar cookie

        var expires,
            exdays = 70,
            date;
        date = new Date(); //  criando o COOKIE com a data atual
        date.setTime(date.getTime()+(exdays*24*60*60*1000));
        expires = date.toUTCString();
        document.cookie = name+"="+value+"; expires="+expires+"; path=/";
    },
    
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    read: function(strCookie)
    {
        var strNomeIgual = strCookie + "=";
        var arrCookies = document.cookie.split(';');

        for(var i = 0; i < arrCookies.length; i++)
        {
            var strValorCookie = arrCookies[i];
            while(strValorCookie.charAt(0) == ' ')
            {
                strValorCookie = strValorCookie.substring(1, strValorCookie.length);
            }
            if(strValorCookie.indexOf(strNomeIgual) == 0)
            {
                return strValorCookie.substring(strNomeIgual.length, strValorCookie.length);
            }
        }
        return false;
    },
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     * @param {type} name
     * @returns {undefined}
     */
    del: function (name)
    {
        setCookie(name,-1); // deletando o cookie encontrado a partir do mostraCookie
    },

    init: function (id) {
        //this.create(id);
    }
}

