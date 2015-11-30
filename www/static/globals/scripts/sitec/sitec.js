/*$('html, body').animate({
                scrollTop: 0
        }, 1000);*/

/**
 * 
 * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
 */
Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
}
/**
 * 
 * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
 */
Storage.prototype.getObject = function(key) {
    var value = this.getItem(key);
    return value && JSON.parse(value);
}
/**
 * 
 * Puxa Sierra
 * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
 */
var Sierra = (function () {
    "use strict";
    // VARIAVEIS PRIMARIAS
    var Config_Formulario_Vazios    = [
            "",                   // Vazio Normal
            "__/__/____",         // DATA
            "__/__/____ __:__:__",// DATA HORA
            "__:__",              // Hora
            "____",               // ANO
            "__/____",            // Validade
            "(__) ____-____",     // Telefone
            "__.___-___",         // CEP
            "___.___.___-__",     // CPF
            "__.___.___/____-__", // CNPJ
            "_______-_",          // Inscricao Municipal
            "__.___.___-_",       //RG
            "R$ 0,00"             // REAL
        ],
        DataTable_Selected          = [],
        documento                   = $(document),
        janela                      = $(window);
    /**
    * Funções Usadas Pela Classe
    * METODOS PRIVADOS
    * 
    */  
    /**
     * Calendario
     * @param {type} data
     * @returns {_L1.Calendario.Anonym$0}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
     function Calendario(data) {
        return {
            defaultDate: data,
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: "dd/mm/yy",
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesShort: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa']
        };
    };
    /**
     * Calendario
     * @param {type} tipo
     * @param {type} data1
     * @param {type} data2
     * @param {type} campo1
     * @param {type} campo2
     * @param {type} funcao_onclose
     * @returns {_L1.Calendario_Intervalo1.Anonym$1}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Calendario_Intervalo1 (tipo, data1, data2, campo1, campo2, funcao_onclose) {
        if (tipo === 'data') {
            return { 
                defaultDate: data1,
                minDate: data1, // fixo
                maxDate: data2, // muda quando mudar a outra data
                changeMonth: true,
                numberOfMonths: 2,
                dateFormat: "dd/mm/yy",
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                onClose: function ( selectedDate ) {
                    var html_campo2 = $(document.getElementById(campo2));
                    html_campo2.datepicker( "option", "minDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        $(this).datepicker( "option", "dateFormat", "dd/mm/yy" );
                        html_campo2.datepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose+Control_Data_ContaDias($(document.getElementById(data_inicial)).val(), $(document.getElementById(data_final)).val())+');');
                        $(this).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        html_campo2.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }
            };
        } else {
            return {
                timeFormat: 'HH:mm:ss'
            };
        }
    };
    /**
     * 
     * @param {type} tipo
     * @param {type} data1
     * @param {type} data2
     * @param {type} campo1
     * @param {type} campo2
     * @param {type} funcao_onclose
     * @returns {_L1.Calendario_Intervalo2.Anonym$2}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Calendario_Intervalo2 (tipo, data1, data2, campo1, campo2, funcao_onclose) {
        if (tipo === 'data') {
            return { 
                defaultDate: data2,
                minDate: data1, // muda quando mudar a outra data
                maxDate: data2, // fixo
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 2,
                dateFormat: "dd/mm/yy",
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                onClose: function ( selectedDate ) {
                    var html_campo1 = $(document.getElementById(campo1));
                    html_campo1.datepicker( "option", "maxDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        html_campo1.datepicker( "option", "dateFormat", "dd/mm/yy" );
                        $(this).datepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose+Control_Data_ContaDias($(document.getElementById('data_inicial')).val(), $(document.getElementById('data_final')).val())+');');
                        html_campo1.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        $(this).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }
            };
        } else {
            return { 
                timeFormat: 'HH:mm:ss'
            };
        }
    };
    /**
     * 
     * @param {type} tipo
     * @param {type} data1
     * @param {type} data2
     * @param {type} campo1
     * @param {type} campo2
     * @param {type} funcao_onclose
     * @returns {_L1.Calendario_Intervalo_SemLimite1.Anonym$3}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Calendario_Intervalo_SemLimite1 (tipo, data1, data2, campo1, campo2, funcao_onclose) {
        return { 
            defaultDate: data1,
            maxDate: data2, // muda quando mudar a outra data
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            onClose: function ( selectedDate ) {
                if (tipo === 'data') {
                    var html_campo2 = $(document.getElementById(campo2));
                    html_campo2.datepicker( "option", "minDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        $(this).datepicker( "option", "dateFormat", "dd/mm/yy" );
                        html_campo2.datepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose+Control_Data_ContaDias($(document.getElementById('data_inicial')).val(), $(document.getElementById('data_final')).val())+');');
                        $(this).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        html_campo2.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }else if (tipo === 'hora') {
                    var html_campo2 = $( campo2 );
                    html_campo2.datetimepicker( "option", "minDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        $(this).datetimepicker( "option", "dateFormat", "dd/mm/yy" );
                        html_campo2.datetimepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose);
                        $(this).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        html_campo2.datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }
            }
        };
    };
    /**
     * 
     * @param {type} tipo
     * @param {type} data1
     * @param {type} data2
     * @param {type} campo1
     * @param {type} campo2
     * @param {type} funcao_onclose
     * @returns {_L1.Calendario_Intervalo_SemLimite2.Anonym$4}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Calendario_Intervalo_SemLimite2 (tipo, data1, data2, campo1, campo2, funcao_onclose) {
        return { 
            defaultDate: data2,
            minDate: data1, // muda quando mudar a outra data
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            onClose: function ( selectedDate ) {
                if (tipo === 'data') {
                    var html_campo1 = $(document.getElementById(campo1));
                    html_campo1.datepicker( "option", "maxDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        html_campo1.datepicker( "option", "dateFormat", "dd/mm/yy" );
                        $(this).datepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose+Control_Data_ContaDias($(document.getElementById('data_inicial')).val(), $(document.getElementById('data_final')).val())+');');
                        html_campo1.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        $(this).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }else if (tipo === 'hora') {
                    var html_campo1 = $(campo1);
                    html_campo1.datepicker( "option", "maxDate", selectedDate );
                    if (typeof(funcao_onclose) !== "undefined") {
                        html_campo1.datepicker( "option", "dateFormat", "dd/mm/yy" );
                        $(this).datepicker( "option", "dateFormat", "dd/mm/yy" );
                        eval(funcao_onclose);
                        html_campo1.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                        $(this).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
                    }
                }
            }
        };
    };
    documento.on("click", 'tbody > tr', function () {
        var id = this.id;
        var index = $.inArray(id, DataTable_Selected);
 
        if ( index === -1 ) {
            DataTable_Selected.push( id );
        } else {
            DataTable_Selected.splice( index, 1 );
        }
        $(this).toggleClass('selected');
    } );
    /**
     * POPUP -> Fecha Janela
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    documento.on("click", 'div.modal-header > button.close', function () {
            ElementsPopup.Control_Ajax_Popup_Fechar('popup');
    });
    /**
     * TRANSFORMA LINKS PRA AJAX
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    documento.on("click", 'a[class*="lajax"]', function () {
        console.time('Control_Link_Dinamico');
        var link = $(this), 
            url = link.attr('href');
        if (url.indexOf('javascript::') === 0) {
            //url = url.split("script::");
            var url = url.replace("javascript::",""); 
            eval(url);
            console.timeEnd('Control_Link_Dinamico');
            return false;
        } else {
            // Verifica é necessário Confirmação
            if (link.attr('data-confirma') !== undefined) {
                $.blockUI({ 
                    message: '<div style="padding: 10px;"><h3>'+link.attr('data-confirma')+'</h3> <input class="btn" type="button" id="confirmacao_sim" value="Sim" /> <input class="btn" type="button" id="confirmacao_nao" value="Não" /></div>', 
                    css: { width: '275px' } 
                });
                $(document.getElementById('confirmacao_sim')).click(function () { 
                    Control_Link_Dinamico(link);
                    $.unblockUI(); 
                });
                $(document.getElementById('confirmacao_nao')).click(function () { 
                    $.unblockUI(); 
                    console.timeEnd('Control_Link_Dinamico');
                    return false; 
                }); 
            }else if (url !== '#') {
                Control_Link_Dinamico(link);
            }
        }
        console.timeEnd('Control_Link_Dinamico');
        return false;
    });
    /**
     * TRANSFORMA FORMULARIOS PRA AJAX
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    documento.on("submit", 'form.formajax', function () {
        Control_Form_Tratar(this);
        return false;
    });
    /**
     * Analisa Formularios a cada passagem de campo
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    documento.on("blur", 'input', function () {
        console.time('Control_Form_PassagemDeCampo');
        var elemento        = $(this),
            funcao_valida   = elemento.attr("validar"),
            esta_escondido  = elemento.attr("escondendo"),
            valor           = elemento.val(),
            obrigatorio     = elemento.hasClass('obrigatorio'),
            validar         = true,
            passar          = 1;
        if (obrigatorio === true && $.inArray(valor,Config_Formulario_Vazios)!==-1 && esta_escondido !== 'ativado') {
            elemento.addClass('obrigatoriomarcado').focus();
            passar = 0;
        }else if ($.inArray(valor,Config_Formulario_Vazios)===-1 && funcao_valida !== undefined && funcao_valida !== 'undefined' && esta_escondido !== 'ativado') {
            validar = Control_Layoult_Validar(elemento,funcao_valida,valor);
            if (validar === false) passar = 0;
        }
        if (passar === 1) {
            elemento.removeClass('obrigatoriomarcado');
             console.timeEnd('Control_Form_PassagemDeCampo');
            return true;
        } else {
            console.timeEnd('Control_Form_PassagemDeCampo');
            return false;
        }
    });
    
    /**
     * 
     * @param {type} formulario
     * @returns {Boolean}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Form_Tratar (formulario) {
        var $button = $('button',formulario).attr('disabled',true), //puxa tanto button quanto formulario
            params = $(formulario.elements).serialize(),
            //var self = this,
            id = $(formulario),
            url = formulario.action,
            passar = true;

        // verifica se existe validor
        id.find('input').each(function (i) {
            var elemento        = $(this),
                funcao_valida   = elemento.attr("validar"),
                esta_escondido  = elemento.attr("escondendo"),
                atr_max  = elemento.attr("max"),
                atr_min  = elemento.attr("min"),
                valor           = elemento.val(),
                validar         = true;
            elemento.removeClass('obrigatoriomarcado');
            // Se tiver atr de max verifica
            if (atr_max !== undefined) {
                if(parseInt(valor)>parseInt(atr_max)) {
                    Control_PopMgs_Abrir('erro','Número Inválido',valor+' é maior que '+atr_max);
                    elemento.addClass('obrigatoriomarcado').focus();
                     passar = false;
                }
            }
            // Se tiver atr de min verifica
            if (atr_min !== undefined) {
                if(parseInt(valor)<parseInt(atr_min)) {
                    Control_PopMgs_Abrir('erro','Número Inválido',valor+' é menor que '+atr_min);
                    elemento.addClass('obrigatoriomarcado').focus();
                     passar = false;
                }
            }
            if (funcao_valida !== undefined && $.inArray(valor,Config_Formulario_Vazios)===-1 && funcao_valida !== 'undefined' && esta_escondido !== 'ativado') {
                validar = Control_Layoult_Validar(elemento,funcao_valida,valor);
                
                if (validar === false) { 
                    passar = false;
                    elemento.addClass('obrigatoriomarcado').focus();   
                }
                // verifica se pode passar
            }
        }); 
        id.find('.obrigatorio').each(function (i) {
            var elemento                    = $(this),
                esta_escondido              = elemento.attr("escondendo"),
                valor                       = elemento.val(),
                identificador               = $(document.getElementById(elemento.attr("id")+"_chosen")),
                /*identificador_a             = identificador.children("a"),
                identificador_a_tamanho     = identificador_a.length,*/
                identificador_ch            = identificador.children(".chosen-drop"),
                identificador_ch_tamanho    = identificador_ch.length;
            if ($.inArray(valor, Config_Formulario_Vazios)!==-1  && esta_escondido !== 'ativado') {
                passar = false;
                Control_PopMgs_Abrir('erro','Campo Obrigatório Vazio','Por favor Preencha Todos os Campos');
                // Aplica a cor de fundo
                elemento.addClass('obrigatoriomarcado').focus();

                /*if (identificador_a_tamanho) {
                    identificador_a.addClass('obrigatoriomarcado').focus();
                }*/
                if (identificador_ch_tamanho) {
                    identificador.addClass('obrigatoriomarcado');
                }
            } else {
                // Aplica a cor de fundo
                elemento.removeClass('obrigatoriomarcado');

                /*if (identificador_a_tamanho) {
                    identificador_a.removeClass('obrigatoriomarcado');
                }*/
                if (identificador_ch_tamanho) {
                    identificador.removeClass('obrigatoriomarcado');
                }
            }
        });
        // verifica se pode passar
        if (passar === true) {
            console.log('Control Form Tratar');
            NavigationCall.init(url,params,'POST',true,false,true);
            ElementsPopup.Control_Ajax_Popup_Fechar('popup');
            $button.attr('disabled',false);
            //self.reset();
            return true;
        }
        return false;
    };
    /**
    * Realiza Controle de link
    * @param {type} elemento
    * @param {type} funcao_valida
    * @param {type} valor
    * @returns {Boolean}
    * 
    * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
    */
    function Control_Layoult_Validar (elemento, funcao_valida, valor) {
        var validar = false;
        eval('validar = '+funcao_valida+'(valor)');
        if (validar === false) {
            elemento.addClass('obrigatoriomarcado').focus();
        } else {
            elemento.removeClass('obrigatoriomarcado');
        }
        return validar;
    };
    
    /********************************************
    *
    *         ASSIM QUE TIVER CARREGADO...
    *
    *********************************************/
    /*janela.resize(function () {
            Control_Layoult_Height();
    }).load(function () {
            Control_Layoult_Height();
    });*/	  
    janela.load(function () {
         /*$( "#dialog-confirm" ).dialog({
            autoOpen: true,
            resizable: false,
            height:160,
            buttons: {
                "Deletar": function() {
                    $( this ).dialog( "close" );
                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            }
        });*/
        
        
        Control_Layoult_Recarrega();
        // LIMITA ALTURA DO CONTEUDO						  
        //Control_Layoult_Height();

        //Historico
        // Check Location
        if ( document.location.protocol === 'file:' ) {
            alert('The HTML5 History API (and thus History.js) do not work on files, please upload it to a server.');
        }
        // Establish Variables
        var State = History.getState(),
        $log = $(document.getElementById('log'));
        // Log Initial State
        History.log('initial:', State.data, State.title, State.url);
        // Bind to State Change

        History.Adapter.bind(window,'statechange',function () { // Note: We are using statechange instead of popstate
            // Log the State
            var State = History.getState(),  // Note: We are using History.getState() instead of event.state
                url = State.url/*.slice(ConfigArquivoPadrao.length-1)*/;
            if (NavigationUrl.historyControl !== State.data.id) {
                console.log('Historico Chamar',NavigationUrl.historyControl,State);
                NavigationUrl.historyControl = State.data.id;
                NavigationCall.init(url,'','get',true,true,true);
                /*JsonTratar(
                    State.url,
                    ''State.data.json,
                    'Voltar'
                );*/
            }
        });
    });
    
    /**
     * OUTROS FUNCOES PRIVADAS
     * 
     */
    /**
     * FAZ SEMPRE QUE SE USA AJAX
     * @returns {undefined}
     * @version 0.4.2 // Mudado a fim da reaproveitacao de código, aqui repetia o conteudo de mascaras
    * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Recarrega () {
        // Layoult/Js/Extra.js; Cada Layoult tem o seu
        Control_Layoult_Botoes();
        Control_Atualizacao();
        // Privadas
        Visual_Layoult_DataTable('.datatable');
        Visual_Layoult_DataTable_Massiva('.Listagem_Table');
        Visual_Layoult_Aviso();
        Control_Layoult_Recarrega_Formulario();
        console.timeEnd('Acao_LINK');
    }
    function Control_Layoult_Recarrega_Formulario() {
        Control_Layoult_Mascaras();
        Visual_Layoult_UniForm();
        // Atualiza TabIndex
        var tabindex = 1;
        $('.form-group').find('input,select,textarea,a.chosen-single').each(function() {
            if (this.type != "hidden" && $( this ).attr("escondendo")!=='ativado' && $( this ).css("display")!=='none') {
                var $input = $(this);
                $( this ).attr("tabindex", tabindex);
                tabindex++;
            }
        });
    }
    
    /***************************************************************
    *                                                              *
    *                      MENSAGENS NA TELA                       *
    *                                                              *
    ***************************************************************/
    /**
     * 
     * @param {type} tipo
     * @param {type} mensagem_principal
     * @param {type} mensagem_secundaria
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_PopMgs_Abrir (tipo,mensagem_principal,mensagem_secundaria) {
        if (tipo === 'sucesso') {
            toastr.success(mensagem_secundaria, mensagem_principal);
        }else if (tipo === 'erro') {
            toastr.error(mensagem_secundaria, mensagem_principal);
        }else if (tipo === 'aviso') {
            toastr.warning(mensagem_secundaria, mensagem_principal);
        } else {
            toastr.info(mensagem_secundaria, mensagem_principal);
        }
    };
    /***************************************************************
    *                                                              *
    *                      VISUAL TRATAMENTO                       *
    *                                                              *
    /**
     * Passa Primeira Letra pra Maiusculo
     * @param {type} texto
     * @param {type} sempre (Se verdadeiro, passa sempre pra maiusculo, caso false, so no comeco das frases
     * @returns {undefined}
     * 
     * #update
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Tratamento_Maiusculo_Primeira (texto, sempre) {
        var i = 0,
            str = '';
        texto = texto.toLowerCase();
        str = texto.substring(0,1);
        texto = texto.replace(str, str.toUpperCase());
        return texto;
    };
    
    /***************************************************************
    *                                                              *
    *            CONTROLES DO AJAX, CARREGANDO E HASH              *
    *                                                              *
    ***************************************************************/
    /**
     * 
     * @param {type} link
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Link_Dinamico (link) {
        console.log('Control Link Dinamico');
        // exibe carregando, captura url e executa acao caso exista
        var url = link.attr('href');
        if (link.attr('data-acao') !== '' && link.attr('data-acao') !== 'undefined') {
            eval(link.attr('data-acao')+'(link);');
        }
        // Corta e Chama AJAX
        NavigationCall.init(url,'','get',true,false,true);
    };
    
    
    
    /**
     * Chama DAtatable
     * @type Number|@exp;_L4@pro;i|Number
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Layoult_DataTable (camada) {
        var i = 0;
        // Verifica se existe uma DataTable a ser transformada
        $(camada).each(function () {
            var apagar  = true,
                ordenar,
                atual = $(this);
            if (!atual.hasClass('dataTable')) {
            //if ( !($.fn.dataTable.isDataTable(atual)) ) {
                eval('ordenar = '+atual.attr('ordenar')+';');
                if (atual.hasClass('apagado1')) {
                    apagar = false;
                }
                atual.DataTable({
                    //"bJQueryUI"         : Configuracoes_Template['datatable_bJQueryUI'],
                    //"bAutoWidth"        : Configuracoes_Template['datatable_bAutoWidth'],
                    //"sdom"              : Configuracoes_Template['datatable_sdom'],
                    //"sPaginationType"   : Configuracoes_Template['datatable_sPaginationType'],
                    //"bPaginate"         : true,     
                    "bProcessing"       : true,  // Mensagem de Processando
                    "bDeferRender"      : true,  // Ajudar no Carregamento 
                    "iDisplayLength"    : 10,   // Quantidade por pagina
                    "aoColumnDefs"      : [{ 
                        "bSearchable"       : true, 
                        "bVisible"          : apagar, 
                        "aTargets"          : [0] 
                    }],
                    "aaSorting"         : ordenar,
                    "bLengthChange"     :true,
                    "bFilter"           :true,
                    "bSort"             :true, // Usuario pode Multi-Ordenacao ?
                    "bInfo"             :true 
                });
                i = i+1;
            }
        });
        // se existir, essa datatable é acionada
        /*if (i>0) {
            jQuery('.dataTables_filter').find('input').addClass("input-small"); // modify table search input
            jQuery('.dataTables_length').find('select').addClass("input-mini"); // modify tabl
     * @param {type} camada
     * @returns {undefined}e per page dropdown
        }*/
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Layoult_DataTable_Massiva (camada) {
        var i = 0;
        // Verifica se existe uma DataTable a ser transformada
        $(camada).each(function () {
            var apagar  = true,
                ordenar,
                atual = $(this),
                colunas_imprimir = [],
                cont = 0;
            //var j  = atual.children('thead').children('tr').children('th').length-1;
            if (!atual.hasClass('dataTable')) {
                ordenar = false; //Cookie_Ler('TabelaOrdenar_'+atual.attr('url'));
                if(ordenar===false) {
                    eval('ordenar = '+atual.attr('ordenar')+';');
                }
                if (atual.hasClass('apagado1')) {
                    apagar = false;
                }
                
                /*for(;cont<j;++cont) {
                    colunas_imprimir.push(cont);
                }*/
                atual.DataTable({          
                    "processing": true,
                    "serverSide": true,
                    "ajax": $.fn.dataTable.pipeline( {
                        url: ConfigArquivoPadrao+atual.attr('url'),
                        pages: 5 // number of pages to cache
                    } ),
                    "bProcessing"       : true,  // Mensagem de Processando
                    "iDisplayLength"    : 10,   // Quantidade por pagina
                    "aaSorting"         : ordenar,
                    "bLengthChange"     :true,
                    "bFilter"           :true,
                    "bSort"             :true, // Usuario pode Multi-Ordenacao ?
                    "bInfo"             :true 
                });
                i = i+1;
            }
        });
        // se existir, essa datatable é acionada
        /*if (i>0) {
            jQuery('.dataTables_filter input').addClass("input-small"); // modify table search input
            jQuery('.dataTables_length select').addClass("input-mini"); // modify table per page dropdown
        }*/
    };
    /**
     * Atualiza UNIFORM
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Layoult_UniForm_Selectiona () {
        //Regarrega
        $("select.form-select-padrao").trigger("chosen:updated");
    };
    /**
     * Realiza UNIFORM
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Layoult_UniForm () {
        //$('select').uniform();
        //$('input:checkbox').uniform();
        //$('input:radio').uniform();
        //$('input:file').uniform();
        //$.uniform.update();
        Visual_Layoult_UniForm_Selectiona();

        //chosen select
        $(".form-select-padrao").chosen({
            allow_single_deselect:true,
            width: "90%"
        });

       /* $('.cp1').colorpicker({
            format: 'hex'
        });
        $('.cp2').colorpicker();
        //WYSIWYG Editor
        $('.wysihtmleditor5').wysihtml5();*/
    };
    /**
     * 
     * @returns {undefined}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Layoult_Aviso () {
        
        // Atualiza ToolTip
        $('.explicar-titulo').tooltip({
            position: {
                my: "center bottom-20",
                at: "center top",
                using: function( position, feedback ) {
                    $( this ).css( position );
                    $( "<div>" )
                    .addClass( "arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
                }
            }
        });
    };
    /********************************************
     * 
     *                                                 MASCAAAAAAARAS      
     * 
     */
   
     /*** @returns {undefined} 
     * MASCARAS
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Mascaras ()
    {   
        // Datas
        $(".masc_data") .mask("99/99/9999"                           ); // Mascara para Data
        $(".masc_data_hora") .mask("99/99/9999 99:99:99"             ); // Mascara para DataHora
        $(".masc_hora")      .mask("99:99"                           ); // Mascara para  hora
        // Telefones
        $(".masc_fone")      .mask("(99) 9999-9999"                  ); // Mascara para tel
        $(".masc_cel")       .mask("(99) ?99999-9999"                ); // Mascara para tel
        // Bancario
        $('.masc_agencia')   .mask('9999-9'                          ); // Máscara para AGÊNCIA BANCÁRIA
        $('.masc_conta')     .mask('99.999-9'                        ); // Máscara para CONTA BANCÁRIA
        // Localização
        $(".masc_cep")       .mask("99.999-999"                      ); // Mascara para cep
        // Advogados
        $(".masc_pis")       .mask("999.99999.99/9"                  );
        $(".masc_pro")       .mask("9999999-99.9999.9.99.9999"       ); // Mascara para Procuração
        // Registros
        $(".masc_cpf")       .mask("999.999.999-99"                  ); // Mascara para cpf
        $(".masc_cnpj")      .mask("99.999.999/9999-99"              ); // Mascara para cnpj
        $(".masc_insc")      .mask("9999999-9"                       ); // Mascara para Inscrição Municipal
        
        // Complexo: RG
        $('.masc_rg')        .mask("9999999?999-*"/*, { completed: function () {
            var rg, element;

            element = this;
            rg = this.val();
            element.unmask();
            if(rg.length == 7) {
                element.mask("999.999-*");
            }else if(rg.length == 8) {
                element.mask("9.999.999-*");
            } else if(rg.length == 9) {
                element.mask("99.999.999-*");
            } else {
                element.mask("999.999.999-*");
            };
         } }*/);
        // Carros
        $(".masc_placa")     .mask("aaa9999"                         ); // Mascara para Placa de Carro
        // Faculdade
        $(".masc_periodo")   .mask("9999.9"                          ); // Mascara para Ano Periodo
        $(".masc_letras")    .keypress(Control_Layoult_Valida_Letras);  // Só permite Letras
    };
    /**
     * 
     * @param {object} o
     * @param {string} f
     * @returns {void}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara(o,f) {
        var v_obj   =   o,
            v_fun   =   "Visual_Formulario_Mascara_"+f;
        setTimeout(function() {
            eval('v_obj.value = '+v_fun+'(v_obj.value);');
        },10);
    };
    /**
     * Mascara de Porcentagem
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Porc(v) {
        var tam = v.length;
        
        if(v[tam-2]!='%' && v[tam-2]!=' ' && tam>1) {
            v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
            if(tam>2) {
                v=v.replace(/(\d+)(\d{1})/,"$1");
            } else {
                return '00,00 %';
            }
        } else {
            v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
        }
        
        // Caso numero comece com zero, retira
        if(v[0]==='0') {
            v = parseInt(v);
        }
        
        // se for vazio retorna vazio
        if(v==''|| v===0) {
            return '00,00 %';
        } else {
            v = parseFloat(v)/100;
            v = v.toFixed(2);
        }
        
        if(v>=100) {
            return "100,00 %";
        }else
        if(v<10) {
            return '0'+v.toString().replace(".",",")+' %';
        } else {
            return v.toString().replace(".",",")+' %';
        }
    }
    /**
     * Real
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Real(v) {
        v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
        if(v=='') v = 0;
        // Coloca Virgula, ou coloca zero na frente
        v = parseFloat(v)/100;
        v = v.toFixed(2).toString().replace(".",",");
        v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1.$2"); //Coloca o primeiro ponto
        var qtdLoop = (v.length-3)/3;
        var count = 0;
        while (qtdLoop > count)
        {
            count++;
            v=v.replace(/(\d+)(\d{3}.*)/,"$1.$2"); //Coloca o resto dos pontos
        }
        v=v.replace(/^(0+)(\d)/g,"$2"); //remove "0" Ă  esquerda
        return 'R$ '+v;
    }
    /**
     * 
     * @param {type} v
     * @returns {String}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Data(v) {
        var tam     = v.length,
            data    = '',
            direto  = false,
            dia     = 0,
            mes     = 0,
            ano     = 0,
            num     = 0; //armazena inteiro temporario;
        v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
        
        tam = v.length;
        if(tam>8) tam = 8;
        for(var i = 0;i<tam;++i) {
            num = parseInt(v[i]);
            if(i===0) {
                //nao deixa ter dia acima de 39
                if(num>3) {
                    num = 3;
                }
                dia = num*10;
            }else
            if(i===1) {
                //nao deixa ter dia acima de 31
                if(num>2 && dia===30) {
                    dia = dia+1;
                    data = data+'1';
                    continue;
                } else {
                    dia = dia+num;
                }
            }else
            if(i===2) {
                // Colocar Barra
                data = data+'/';
                //nao deixa ter mes acima de 19
                if(num>1) {
                    mes = 10;
                    data = data+'1';
                    continue;
                } else {
                    mes = num*10;
                }
            }else
            if(i===3) {
                //nao deixa ter mes 0
                if(mes===0 && num===0) {
                    mes = 1;
                    data = data+'1';
                    continue;
                }else
                // Nao deixa ter mes > 13
                if(num>=2 && mes===10) {
                    mes = 12;
                    data = data+'2';
                    continue;
                }else
                // Controla os dias 31, nao deixa ter dia 31 dos meses que nao tem dia 31
                if(dia===31 && ((mes===0 && (num===4 || num===6 || num===9)) || (mes===10 && num===1))) {
                    mes = num+mes;
                    dia = 30;
                    if(mes===11) {
                        data = '30/'+mes.toString();
                    } else {
                        data = '30/0'+mes.toString();
                    }
                    continue;
                }else 
                // Caso Fevereiro com dia acima de 29
                if(mes===0 && num===2 && dia>=29) {
                    dia = 29;
                    mes = 2;
                    data = '29/02';
                    continue;
                } else {
                    mes = num+mes;
                }
            }else
            if(i===4) {
                // Colocar Barra
                data = data+'/';
                // Caso ano direto
                if(v[i]>2 || v[i]==='0') {
                    data = data+'20'+v[i];
                    direto = true;
                    continue;
                }
            } else {
                // Guarda ano
                ano = ano+(num*(8-i));
            }
            // Acrescenta Data
            data = data+v[i];
            // Trata For caso seja ano direto
            if(direto===true) i = 8;
        }
        // Fevereiro com 29 dias e nao é ano bissexto volta a ser 28 dias
        if(tam===8 && mes===2 && dia===29 && !((ano % 4 === 0) && ((ano % 100 !== 0) || (ano % 400 === 0)))) {
            dia = 28;
            data = data.split('/');
            data = '28/'+data[1]+'/'+data[2];
        }
        return data;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Ano(v) {
        var tam     = v.length,
            direto  = false,
            data     = '',
            num     = 0,
            i = 0; //armazena inteiro temporario;
        v= v.replace(/\D/g,""); //Remove tudo o que não é dígito
        if(v==='') return '';
        v= parseInt(v).toString(); //Transforma pra string denovo
        tam = v.length;
        if(tam>4) tam = 4;
        for(i = 0;i<tam;++i) {
            num = parseInt(v[i]);
            if(i===0) {
                // Caso ano direto
                if(num>2 || v[i]==='0') {
                    data = '20'+v[i];
                    direto = true;
                    continue;
                }
            }
            // Acrescenta Data
            data = data+v[i];
            // Aumenta i para caso seja ano direto
            if(direto===true) i = 4;
        }
        return data;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Validade(v) {
        var tam     = v.length,
            data    = '',
            direto  = false,
            mes     = 0,
            ano     = 0,
            num     = 0; //armazena inteiro temporario;
        v=v.replace(/\D/g,""); //Remove tudo o que não é dígito

        // Coloca Virgula, ou coloca zero na frente
        tam = v.length;
        if(tam>6) tam = 6;
        for(var i = 0;i<tam;++i) {
            num = parseInt(v[i]);
            if(i===0) {
                //nao deixa ter mes acima de 19
                if(num>1) {
                    mes = 10;
                    data = data+'1';
                    continue;
                } else {
                    mes = num*10;
                }
            }else
            if(i===1) {
                //nao deixa ter mes 0
                if(mes===0 && num===0) {
                    mes = 1;
                    data = data+'1';
                    continue;
                }else
                    // Nao deixa ter mes > 13
                if(num>=2 && mes===10) {
                    mes = 12;
                    data = data+'2';
                    continue;
                } else {
                    mes = num+mes;
                }
            }else
            if(i===2) {
                // Colocar Barra
                data = data+'/';
                // Caso ano direto
                if(v[i]>2 || v[i]==='0') {
                    data = data+'20'+v[i];
                    direto = true;
                    continue;
                }
            } else {
                // Guarda ano
                ano = ano+(num*(6-i));
            }
            // Acrescenta Data
            data = data+v[i];
            // Trata For caso seja ano direto
            if(direto===true) i = 6;
        }
        return data;
    }
    /**
     * converte o texto para leech script,
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_leech(v) {
        v=v.replace(/o/gi,"0");
        v=v.replace(/i/gi,"1");
        v=v.replace(/z/gi,"2");
        v=v.replace(/e/gi,"3");
        v=v.replace(/a/gi,"4");
        v=v.replace(/s/gi,"5");
        v=v.replace(/t/gi,"7");
        return v;
    }
    /**
     * Só Numeros
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Numero(v) {
        return v.replace(/\D/g,"");
    }
    /**
     * 
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Tel(v) {
        v=v.replace(/\D/g,"").substring(0, 10);                 //Remove tudo o que não é dígito
        v=v.replace(/^(\d\d)(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Cel(v) {
        v=v.replace(/\D/g,"").substring(0, 11);                 //Remove tudo o que não é dígito
        if(v.length===11) {
            v=v.replace(/(\d{7})(\d)/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        } else {
            v=v.replace(/(\d{6})(\d)/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        }
        v=v.replace(/^(\d\d)(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        return v;
    }
    /**
     * 
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Cpf(v) {
        v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
        v=v.replace(/(\d{3})(\d)/,"$1.$2");       //Coloca um ponto entre o terceiro e o quarto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2");       //Coloca um ponto entre o terceiro e o quarto dígitos
                                                 //de novo (para o segundo bloco de números)
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2"); //Coloca um hífen entre o terceiro e o quarto dígitos
        return v;
    }
    /**
     * 
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Cep(v) {
        v=v.replace(/D/g,"");                //Remove tudo o que não é dígito
        v=v.replace(/^(\d{5})(\d)/,"$1-$2"); //Esse é tão fácil que não merece explicações
        return v;
    }
    /**
     * 
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Visual_Formulario_Mascara_Cnpj(v) {
        v=v.replace(/\D/g,"");                           //Remove tudo o que não é dígito
        v=v.replace(/^(\d{2})(\d)/,"$1.$2");             //Coloca ponto entre o segundo e o terceiro dígitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dígitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2");           //Coloca uma barra entre o oitavo e o nono dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2");              //Coloca um hífen depois do bloco de quatro dígitos
        return v;
    }
    /**
     * Numeros Romanos
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     * */
    function Visual_Formulario_Mascara_Rom(v) {
        v=v.toUpperCase();             //Maiúsculas
        v=v.replace(/[^IVXLCDM]/g,""); //Remove tudo o que não for I, V, X, L, C, D ou M
        //Essa é complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
        while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="") {
            v=v.replace(/.$/,"");
        }
        return v;
    };
    /**
     * Sites
     * @param {string} v
     * @returns {string}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     * */
    function Visual_Formulario_Mascara_Site(v) {
        //Esse sem comentarios para que você entenda sozinho ;-)
        v=v.replace(/^http:\/\/?/,"");
        dominio=v;
        caminho="";
        if(v.indexOf("/")>-1) {
            dominio=v.split("/")[0];
        }
        caminho=v.replace(/[^\/]*/,"");
        dominio=dominio.replace(/[^\w\.\+-:@]/g,"");
        caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"");
        caminho=caminho.replace(/([\?&])=/,"$1");
        if(caminho!=="")dominio=dominio.replace(/\.+$/,"");
        v="http://"+dominio+caminho;
        return v;
    };
    /********************************************
    *
    *         FUNCOES AUXILIARES.
    *         
    *         
    *         FUNCOES DE VALIDAÇÂO de CAMPO NOS FORMULARIOS
    *
    *********************************************/
    /**
     * 
     * @param {type} e
     * @returns {Boolean}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_Numeros (e)
    {
        if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57))
        {
            return false;
        }
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_Letras (e)
    {
        if (e.which === 8 || e.which === 0 || (e.which >= 48 && e.which <= 57))
        {
            return false;
        }
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_Data (date) {
        var ardt    =   new Array,
            ExpReg  =   new RegExp("(0[1-9]|[1-2][0-9]|3[0-1])/(0[1-9]|1[0-12])/[1-2][0-9]{3}"),
            ardt    =   date.split("/"),
            erro    =   false;
        if(date==='00/00/0000') return true;
        if ( date.search(ExpReg) === -1) {
            erro = true;
        }
        else if (((ardt[1] === 4)||(ardt[1] === 6)||(ardt[1] === 9)||(ardt[1] === 11))&&(ardt[0]>30))
            erro = true;
        else if ( ardt[1] === 2) {
            if ((ardt[0]>28)&&((ardt[2]%4) !== 0))
                erro = true;
            if ((ardt[0]>29)&&((ardt[2]%4) === 0))
                erro = true;
        }
        if (erro) {
            return false;
        }
        return true;
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_Hora (date) {
        var ardt    =   new Array,
            ExpReg  =   new RegExp("(0[1-9]|1[0-9]|2[0-4])/([0-5][0-9])"),
            ardt    =   date.split(":"),
            erro    =   false;
        if(date==='00:00') return true;
        if ( date.search(ExpReg) === -1) {
            erro = true;
        }
        
        
        if (erro) {
            return false;
        }
        return true;
    };
    /**
     * 00/0000 Mes ano\\\\
    * 
    * @param {type} date
    * @returns {Boolean}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
    */
    function Control_Layoult_Valida_Validade (date) {
        var ardt    =   new Array,
            ExpReg  =   new RegExp("(0[1-9]|1[0-12])/[1-2][0-9]{3}"),
            ardt    =   date.split("/"),
            erro    =   false;
        if ( date.search(ExpReg) === -1) {
            erro = true;
        }
        else if (((ardt[1] === 4)||(ardt[1] === 6)||(ardt[1] === 9)||(ardt[1] === 11))&&(ardt[0]>30)) {
            erro = true;
        }
        // Se tiver Erro retorna false
        if (erro) {
            return false;
        }
        return true;
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_DataHora (datetime) {
        var ardt        =   new Array,
            ExpReg      =   new RegExp("(0[1-9]|1[0-9]|2[0-4]):[0-5][0-9]:[0-5][0-9]"),
            erro        =   false,
            ardt;
        datetime    =   datetime.split(" ");
        if (!Control_Layoult_Valida_Data(datetime[0])) {
            erro = true;
        }
        if (datetime.length<2) {
            erro = true;
        }
        // Se der merda trava
        if (erro) {
            return false;
        }
        // Continua para Hora
        ardt        =   datetime[1].split(":");
        /////////////////
        if ( datetime[1].search(ExpReg) === -1) {
            erro = true;
        }
        if (erro) {
            return false;
        }
        return true;
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_EMAIL (email) {
        /*
        if (Config_Form_Maiusculo === true) {
            email = email.toLowerCase();
        }*/
        //if (/^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-) {0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-) {0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]) {1,3}\.) {3}([0-9]) {1,3}))|(\[((([0-9]) {1,3}\.) {3}([0-9]) {1,3})\])))$/.test(email)) {
        if (/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/.test(email)) {
            return true;
        } else {
            return false;
        }
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_URL (url) {
        if (/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/.test(url)) {
            return true;
        } else {
            return false;
        }
        /*if (!url)
            return false;

        url = url.toLowerCase();
        urlRegExp = /^(((ht|f)tp(s?))\:\/\/)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/;
        return urlRegExp.test(url);*/
    };
    /*
     * 
     * 
     * 
     * function isRG(number) {
            if (!number) return false;
            ssnRegExp = /^[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9]{1}$/;
            return ssnRegExp.test(number);
        }
     function isCPF(number) {
        if (!number) return false;

        ssnRegExp = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        return ssnRegExp.test(number);
    }
    function isDate(date) {
        var ret,one,two,three;

        ret = false;

        if ( /\d{4}[-/\s]{1}\d{2}[-/\s]{1}\d{2}/.test(date) === true ) {

            date = date.replace(/[\D]/gi,"");

            one = date.substr(0, 4);
            two = date.substr(4, 2);
            three = date.substr(6, 2);

            if ( two !== 00 && two <= 12 && three !== 00 && three <= 31 ) ret=true;

        }
        else if ( /\d{2}[-/\s]{1}\d{2}[-/\s]{1}\d{4}/.test(date) === true ) {

            date = date.replace(/[\D]/gi,"");
            one = date.substr(0, 2);
            two = date.substr(2, 2);
            three = date.substr(4, 4);

            if ( one !== 00 && one<=31 && two !== 00 && two<=12 ) ret=true;

        } else if ( /\d{8}/.test(date) === true) {

            one = date.substr(0, 4);
            two = date.substr(4, 2);
            three = date.substr(6, 2);

            if ( one>1800 && two !== 00 && two<=12 && three !== 00 && three<=31) {
                ret=true;
            }
            else{

                one = date.substr(0, 2);
                two = date.substr(2, 2);
                three = date.substr(4, 4);

                if ( one !== 00 && one<=31 && two !== 00 && two<=12 && three>1800 ) ret=true;
            }

        }

        return ret;
    }
     *
     **/
    /**
     *
     * @param {int} cnpj (Inteiro ou Elemento input, retorna true para valido, e
     * false para invalido 
     * @returns {Boolean}
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Control_Layoult_Valida_CNPJ (cnpj) {
        var tamanho = 0, numeros = 0, digitos = 0, soma = 0, pos = 0, resultado = 0, i=0;
        cnpj = cnpj.replace(/[^\d]+/g,'');

        if (cnpj === '') return false;

        if (cnpj.length !== 14) {
            return false;
        }

        // Elimina CNPJs invalidos conhecidos
        if (cnpj === "00000000000000" ||
            cnpj === "11111111111111" ||
            cnpj === "22222222222222" ||
            cnpj === "33333333333333" ||
            cnpj === "44444444444444" ||
            cnpj === "55555555555555" ||
            cnpj === "66666666666666" ||
            cnpj === "77777777777777" ||
            cnpj === "88888888888888" ||
            cnpj === "99999999999999") {
                return false;
        }

        // Valida 1 digito verificador
        tamanho = cnpj.length - 2;
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            return false;
        }

        // Valida 2 digito verificador
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
          soma += numeros.charAt(tamanho - i) * pos--;
          if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            return false;
        }
        return true;
    };
    /**
     * Valida Inscricoes
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_INSC (cnpj) {
        var valido = true;
        cnpj = cnpj.replace(/[^\d]+/g,'');

        if (cnpj === '') return false;

        if (cnpj.length !== 8) {
            valido = false;
        }

        // Elimina CNPJs invalidos conhecidos
        if (cnpj === "00000000" ||
            cnpj === "11111111" ||
            cnpj === "22222222" ||
            cnpj === "33333333" ||
            cnpj === "44444444" ||
            cnpj === "55555555" ||
            cnpj === "66666666" ||
            cnpj === "77777777" ||
            cnpj === "88888888" ||
            cnpj === "99999999") {
                valido = false;
        }
        return valido;
    };
    /**
     * 
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    function Control_Layoult_Valida_Cep (cep) {
        if (!cep) return false;
        return /^\d{2}\.\d{3}-\d{3}$/.test(cep);
    };
    /**
     * Funções a Retornar
     * METODOS PUBLICOS
     * 
     * @param {type} valor
     * @returns {unresolved}
     * @author Ricardo Rebello Sierra <contato@ricardosierra.com.br>
     */
    return {
        // Funções Usadas pelo Objeto que serão publicas
        Control_Form_Tratar                 : Control_Form_Tratar,
        Control_Layoult_Recarrega           : Control_Layoult_Recarrega,
        Control_Layoult_Recarrega_Formulario: Control_Layoult_Recarrega_Formulario,
        Control_Link_Dinamico               : Control_Link_Dinamico,
        
        Visual_Formulario_Mascara           : Visual_Formulario_Mascara,
        Visual_Layoult_UniForm_Selectiona   : Visual_Layoult_UniForm_Selectiona,
        
        Visual_Tratamento_Maiusculo_Primeira: Visual_Tratamento_Maiusculo_Primeira,
        
        Control_PopMgs_Abrir: Control_PopMgs_Abrir,
        
        Converter_Real_Float: function (valor) {
            valor = valor.replace("R$ ","");
            valor = valor.replace(".","");
            valor = valor.replace(",",".");
            valor = parseFloat(valor);
            return valor;
        },
        Converter_Float_Real: function (valor) {
            var inteiro = null, 
                decimal = null, 
                c = null, 
                j = null,
                aux = new Array();
            valor = ""+valor;
            c = valor.indexOf(".",0);
            //encontrou o ponto na string
            if (c > 0) {
               //separa as partes em inteiro e decimal
               inteiro = valor.substring(0,c);
               decimal = valor.substring(c+1,valor.length);
            } else {
               inteiro = valor;
            }

            //pega a parte inteiro de 3 em 3 partes
            for (j = inteiro.length, c = 0; j > 0; j-=3, c++) {
               aux[c]=inteiro.substring(j-3,j);
            }

            //percorre a string acrescentando os pontos
            inteiro = "";
            for (c = aux.length-1; c >= 0; c--) {
               inteiro += aux[c]+'.';
            }
            //retirando o ultimo ponto e finalizando a parte inteiro

            inteiro = inteiro.substring(0,inteiro.length-1);

            decimal = parseInt(decimal);
            if (isNaN(decimal)) {
               decimal = "00";
            } else {
               decimal = ""+decimal;
               if (decimal.length === 1) {
                  decimal = decimal+"0";
               }
            }


            valor = "R$ "+inteiro+","+decimal;


            return valor;
        },
        /*Control_Tema_Clonar: function (clonar,copiar) {


            //$( clonar ).clone().appendTo( copiar );
            //Control_Layoult_Recarrega();
            /*var contador = 1;
            $(clonar).clone(false).find("*[id]").andSelf().each(
                    function () { 
                        contador = contador+1;
                        $(this).attr("id", $(this).attr("id").replace("1","") + contador); 
                    }
            ).appendTo( copiar );;*/
            /*/ Original element with attached data
            var $elem = $( clonar );
            var $clone = $elem.clone( true )
            .data( "arr", $.extend( [], $elem.data( "arr" ) ) );
            // Original element with attached data
            /*eval ('var $elem = $( "'+clonar+'" ).data( "arr": [ 1 ] );');
            var $clone = $elem.clone( true )
            // Deep copy to prevent data sharing
            .data( "arr", $.extend( [], $elem.data( "arr" ) ) );
            $clone.appendTo( copiar );
        },      */
        Control_Data_ContaDias: function (data1, data2) {
            // objetos Data
            data1 = data1.split('/');
            data2 = data2.split('/');
            var dt1 = new Date(data1[2], data1[1], data1[0]),
                dt2 = new Date(data2[2], data2[1], data2[0]),
                // variáveis auxiliares
                minuto = 60000,
                dia = minuto * 60 * 24,
                horarioVerao = 0;

            // ajusta o horario de cada objeto Date
            dt1.setHours(0);
            dt1.setMinutes(0);
            dt1.setSeconds(0);
            dt2.setHours(0);
            dt2.setMinutes(0);
            dt2.setSeconds(0);

            // determina o fuso horário de cada objeto Date
            var fh1 = dt1.getTimezoneOffset(),
                fh2 = dt2.getTimezoneOffset(); 

            // retira a diferença do horário de verão
            if (dt2 > dt1) {
              horarioVerao = (fh2 - fh1) * minuto;
            } 
            else{
              horarioVerao = (fh1 - fh2) * minuto;    
            }

            return Math.ceil((Math.abs(dt2.getTime() - dt1.getTime()) - horarioVerao) / dia);
        },
        /************************************
        *
        *    FUNCOES DE CONTROLE DE LAYOULT
        *
        ***********************************/
        Control_Layoult_Height: function () {
            document.getElementById('content').css({
                height : (janela.height()-220)
            });
        },
        // A partir daqui trata de formularios
        Control_Layoult_Form_Campos_Trocar: function (trocar) {
            var trocar = trocar.split(","),
                i,
                campo,
                campoid1,
                campoid2,
                escondendo;
            for (i in trocar) {
                if(trocar[i].indexOf('.')==0) {
                    campoid1 = $(trocar[i]+'_escondendo');
                    campo   = trocar[i].replace('.', '#');
                    campoid2 = $(campo);
                } else {
                    campoid1 = $(trocar[i]+'_escondendo');
                    campoid2 = $(trocar[i]);
                }
                escondendo = campoid2.attr('escondendo');
                if (escondendo === 'ativado') {
                    campoid1.css('display','block');
                    campoid2.attr('escondendo','desativado');
                }else if (escondendo === 'desativado') {
                    campoid1.css('display','none');
                    campoid2.attr('escondendo','ativado');
                }
            }
            return true;
        },
        Control_Layoult_Pesquisa_Cep: function (cep) {
            cep = $.trim($(cep).val());
            if (cep !== "" && cep.length === 10) {
                if (!Control_Layoult_Valida_Cep(cep)) return false;
                $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+cep, function () {
                    var pais            = unescape("Brasil"),
                        uf              = unescape(resultadoCEP["uf"]),
                        cidade          = unescape(resultadoCEP["cidade"]),
                        bairro          = unescape(resultadoCEP["bairro"]),
                        pais_achado     = 0,
                        uf_achado       = 0,
                        cidade_achado   = 0,
                        bairro_achado   = 0,
                        link            = '',
                        form_pais       = $(document.getElementById('pais')).find('option'),
                        form_estado     = $(document.getElementById('estado')).find('option'),
                        form_cidade     = $(document.getElementById('cidade')).find('option'),
                        form_bairro     = $(document.getElementById('bairro')).find('option');
                    if (resultadoCEP["resultado"] !== 0 && resultadoCEP["resultado"] !== '0') {
                        form_pais.each(function () {
                            if ($(this).text() === pais) {
                                ++pais_achado;
                                form_pais.removeAttr('selected');
                                $(this).attr({ selected : "selected" });
                                return;
                            }
                        });
                        if(pais_achado!==0) {
                            form_estado.each(function () {
                                if ($(this).text() === uf) {
                                    ++uf_achado;
                                    form_estado.removeAttr('selected');
                                    $(this).attr({ selected : "selected" });
                                    return;
                                }
                            });
                            if(uf_achado!==0) {
                                form_cidade.each(function () {
                                    if ($(this).text() === cidade) {
                                        ++cidade_achado;
                                        form_cidade.removeAttr('selected');
                                        $(this).attr({ selected : "selected" });
                                        return;
                                    }
                                });
                                if(cidade_achado!==0) {
                                    form_bairro.each(function () {
                                        if ($(this).text() === bairro) {
                                            ++bairro_achado;
                                            form_bairro.removeAttr('selected');
                                            $(this).attr({ selected : "selected" });
                                            return;
                                        }
                                    });
                                }
                            }
                        }
                        $(document.getElementById('endereco')).val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                        $(document.getElementById('numero')).focus();
                        if (uf_achado !== 0 && cidade_achado !== 0 && bairro_achado !== 0) {
                            Visual_Layoult_UniForm_Selectiona();
                        } else {
                            if (uf_achado === 0) {
                                link += 'estado='+uf+'&';
                            } else {
                                link += 'estado=falso&';
                            }
                            if (cidade_achado === 0) {
                                link += 'cidade='+cidade+'&';
                            } else {
                                link += 'cidade=falso&';
                            }
                            if (bairro_achado === 0) {
                                link += 'bairro='+bairro+'&';
                            } else {
                                link += 'bairro=falso&';
                            }
                            console.log('Puxando Cep');
                            NavigationCall.init('locais/localidades/cep',link,'POST',true,false,false);
                        }
                    } else {
                        Control_PopMgs_Abrir('erro','Cep Inválido','Esse cep não foi reconhecido pelos Corrêios');
                        $(document.getElementById('endereco')).focus();
                    }
                });				
            }
        },
        /*
         *  CALENDARIO NORMAL
         * @param {type} campo
         * @param {type} data
         * @returns {undefined}
         */
        Control_Layoult_Calendario: function (campo, data)
        {
            $(document.getElementById(campo)).datepicker(Calendario(data)).datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
        },
        Control_Layoult_CalendarioHorario: function (campo, data)
        {
            $(campo).datetimepicker(Calendario(data)).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
        },
        //CALENDARIO
        // funcao_onclose = funcao javascript mais parametrosterminando com uma ',' invez do ')'
        Control_Layoult_Calendario_Intervalo: function (campo1, campo2, data1, data2, funcao_onclose)
        {
            var div_campo1 = $(document.getElementById(campo1)),
                div_campo2 = $(document.getElementById(campo2));
            div_campo1.datepicker(Calendario_Intervalo1('data',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                div_campo1.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
            div_campo2.datepicker(Calendario_Intervalo2('data',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                div_campo2.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }

        },
        Control_Layoult_CalendarioHorario_Intervalo: function (campo1, campo2, data1, data2, funcao_onclose)
        {
            $( campo1 ).datetimepicker(Calendario_Intervalo1('hora',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                $( campo1 ).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
            $( campo2 ).datetimepicker(Calendario_Intervalo2('hora',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                $( campo2 ).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
        },
        Control_Layoult_Calendario_Intervalo_SemLimite: function (campo1, campo2, data1, data2, funcao_onclose)
        {
            var div_campo1 = $(document.getElementById(campo1)),
                div_campo2 = $(document.getElementById(campo2));
            div_campo1.datepicker(Calendario_Intervalo_SemLimite1('data',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !=="undefined") {
                div_campo1.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
            div_campo2.datepicker(Calendario_Intervalo_SemLimite2('data',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                div_campo2.datepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
        },
        Control_Layoult_CalendarioHorario_Intervalo_SemLimite: function (campo1, campo2, data1, data2, funcao_onclose)
        {
            $( campo1 ).datetimepicker(Calendario_Intervalo_SemLimite1('hora',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !=="undefined") {
                $( campo1 ).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }
            $( campo2 ).datetimepicker(Calendario_Intervalo_SemLimite2('hora',data1,data2,campo1,campo2,funcao_onclose));
            if (typeof(funcao_onclose) !== "undefined") {
                $( campo2 ).datetimepicker( "option", "dateFormat", "DD, 'Dia' d 'de' MM 'do ano de' yy" );
            }

        },
        /*
         * 
         * 
         *             FUNCOES ESPECIFICAS DE APENAS UM MODULO
         * 
         * 
         * 
         */
        /**
         * Projeto de Alugueis de Motos MOD/VEICULOS
         * 
         * @param {type} valor1
         * @param {type} valor2
         * @param {type} valor3
         * @param {type} diasdecorridos
         * @returns {undefined}
         */
        Control_Agenda_Calpreco: function (valor1, valor2, valor3, diasdecorridos) {
            var valorfinal = 0;
            if (diasdecorridos<=3) {
                valorfinal = valorfinal+(diasdecorridos*valor1);
            }else if (diasdecorridos<10) {
                valorfinal = valorfinal+(diasdecorridos*valor2);
            } else {
                valorfinal = valorfinal+(diasdecorridos*valor3);
            }
            $(document.getElementById('valor')).val('R$ '+Visual_Moeda_Manipulacao(valorfinal,2,',','.'));
        },
        /**
         * 
        // UPLOAD foto
         * @param {type} modulo
         * @param {type} sub
         * @param {type} acao
         * @param {type} camada
         * @param {type} img
         * @param {type} dir
         * @param {type} id
         * @param {type} width
         * @param {type} height
         * @param {type} fileExt
         * @param {type} fileDesc
         * @returns {undefined}
         */
        Modelo_Upload: function (modulo, sub, acao, camada, img, dir, id, width, height, fileExt, fileDesc)
        {
            $(document.getElementById(camada)).uploadify({
                'uploader' 		: ConfigArquivoPadrao+'static/swf/uploadify.swf',
                'script'   		: ConfigArquivoPadrao+modulo+'/'+sub+'/'+acao+'_Upload/'+id,
                'cancelImg'		: ConfigArquivoPadrao+'static/img/upload/cancel.png',
                'folder'   		: dir,
                'fileExt'  		: fileExt,
                'fileDesc' 		: fileDesc,
                'width'    		: width,
                'height'    	: height,
                'buttonImg'		: ConfigArquivoPadrao+dir+''+img,
                'auto'     		: true,
                'wmode'			: 'transparent',
                'onError'   : function (event,ID,fileObj,errorObj) {
                    alert(errorObj.type + ' Error: ' + errorObj.info);
                 },
                'onAllComplete' : function (event,data)
                {
                            console.log('Modelo Upload');
                    NavigationCall.init(modulo+'/'+sub+'/'+acao+'_UploadVer/'+camada+'/'+id+'/','','GET',true,false,false);
                }
            });
        },
        Visual_Layoult_AutoComplete: function (camada, nomes) {
            //var availableUsernames=["John","Mike","Lisa","Emma","Chloe","turboadminer","turbomoder","admin","George"];
            $(document.getElementById(camada)).autocomplete({
                source:nomes
            });
        },
        Visual_Moeda_Manipulacao: function (valor, casas, separdor_decimal, separador_milhar) {
            var valor_total = parseInt(valor * (Math.pow(10,casas))),
                inteiros    =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas))),
                centavos    = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas))),
                retorno     = "",
                milhares = parseInt(inteiros/1000);

            if (centavos%10 === 0 && centavos+"".length<2 ) {
                centavos = centavos+"0";
            }else if (centavos<10) {
                centavos = "0"+centavos;
            }

            inteiros = inteiros % 1000;

            ;

            if (milhares>0) {
                retorno = milhares+""+separador_milhar+""+retorno;
                if (inteiros === 0) {
                    inteiros = "000";
                } else if (inteiros < 10) {
                    inteiros = "00"+inteiros;
                } else if (inteiros < 100) {
                    inteiros = "0"+inteiros;
                }
            }
            retorno += inteiros+""+separdor_decimal+""+centavos;


            return retorno;

        }
    };
}());


// Configuracoes Extrax
toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "3000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}