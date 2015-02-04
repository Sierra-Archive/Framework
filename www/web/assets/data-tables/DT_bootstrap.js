/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
	"sDom": "<'row'<'col-6'l><'col-6'f>r>t<'row'<'col-6'i><'col-6'p>>",
	"sPaginationType": "bootstrap",
	"oLanguage": {
            "sEmptyTable":     "Nenhum registro encontrado na tabela",
            "sInfo": "Mostrar _START_ até _END_ do _TOTAL_ registros",
            "sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
            "sInfoFiltered": "(Filtrar de _MAX_ total registros)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu": "Mostrar _MENU_ registros por pagina",
            "sLoadingRecords": "Carregando...",
            "sProcessing":     "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Proximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast":"Ultimo"
            },
            "oAria": {
                "sSortAscending":  ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
} );


/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
} );


/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
};


/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}

				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
} );


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */
if ( $.fn.DataTable.TableTools ) {
	// Set the classes that TableTools uses to something suitable for Bootstrap
	$.extend( true, $.fn.DataTable.TableTools.classes, {
		"container": "DTTT btn-group",
		"buttons": {
			"normal": "btn",
			"disabled": "disabled"
		},
		"collection": {
			"container": "DTTT_dropdown dropdown-menu",
			"buttons": {
				"normal": "",
				"disabled": "disabled"
			}
		},
		"print": {
			"info": "DTTT_print_info modal"
		},
		"select": {
			"row": "active"
		}
	} );

	// Have the collection use a bootstrap compatible dropdown
	$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
		"collection": {
			"container": "ul",
			"button": "li",
			"liner": "a"
		}
	} );
}


















/*********************************************
 * 
 */
// IDENTIFICA TIPOS DO DATATABLE
/* Note 'unshift' does not work in IE6. A simply array concatenation would. This is used
 * to give the custom type top priority
 * 
 * @param {type} param
 */
jQuery.fn.dataTableExt.aTypes.unshift(
    function ( sData )
    {
        var passar = true,
            iStart=0,
            i = 0,
            ajuda = 0;
        
        
        // Caso seja imagem com alt
        if (sData.match(/alt=".*?"/gi))
        {
            return 'image-level';
        }
        
        // Apaga HTML e Espacos de frente e tras
        sData = sData.replace(/<.*?>/g, '').replace(/^\s+|\s+$/g,"");
        
        if(sData==='' && sData !== null && sData !== false){
            console.log('nulloprimeiro',sData);
            return null;
        }
        
        // Data 00/00/0000
        if (sData.match(/^(\d{2})\/(\d{2})\/(\d{4})$/))
        {
            console.log('date-uk',sData);
            return 'date-uk';
        }
        
        // Data Hora 00/00/0000 00:00:00
        if (sData.match(/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})$/))
        {
            console.log('date-euro',sData);
            return 'date-euro';
        }
        
        // Dinheiro R$ 10.000,00
        if ( typeof sData === 'string' && sData.match(/^(R[$]|£|€|c|$)[ 0-9\.]{1,20}[,\.\-][0-9]{2}$/)) {
            console.log('currency',sData);
            return 'currency';
        }


        // Tamanho de Arquivo MB, GB, BYTE
        // Check the numeric part
        if(sData.substring(sData.length - 2, sData.length) === " B"){
            ajuda = 2;
        }else{
            ajuda = 3;
        }
        for (i=0 ; i<(sData.length - ajuda) ; i++ )
        {
            if ("0123456789".indexOf(sData.charAt(i)) === -1)
            {
                passar = false;
            }
        }
        // Check for size unit KB, MB or GB
        if (passar===true && ( sData.substring(sData.length - 2, sData.length) === "KB"
            || sData.substring(sData.length - 2, sData.length) === "MB"
            || sData.substring(sData.length - 2, sData.length) === "GB" 
            || sData.substring(sData.length - 1, sData.length) === "B" ))
        {
            console.log('file-size',sData);
            return 'file-size';
        }
        passar = true;


        // Numero Decimal
        //Negative sign is valid -  the number check start point
        if ( sData.charAt(0) === '-' ) {
            iStart = 1;
        }
        //Check the numeric part
        for (i=iStart ; i<sData.length ; i++)
        {
            if ("0123456789,.".indexOf(sData.charAt(i)) === -1)
            {
                passar = false;
            }
        }
        if(passar===true){
            return 'numeric-comma';
        }
        passar = true;


        // Numero com Formato Diferente
        var deformatted = sData.replace(/[^\d\-\.\/a-zA-Z]/g,'');
        if ( $.isNumeric( deformatted ) || deformatted === "-" ) {
            console.log('formatted-num',sData);
            return 'formatted-num';
        }


        // Confere pra ver se é um Ip
        if (/^\d{1,3}[\.]\d{1,3}[\.]\d{1,3}[\.]\d{1,3}$/.test(sData)) {
            console.log('ip-address',sData);
            return 'ip-address';
        }

            console.log('nullo',sData);
        return null;
    }
);


// Numero Decimal
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    
    // NUmero separado por virgula
    "numeric-comma-pre": function ( a ) {
        var x = (a === "-" || a === "") ? 0 : a.replace( /,/, "." );
        return parseFloat( x );
    },
    "numeric-comma-asc": function ( x, y ) {
        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
    },
    "numeric-comma-desc": function ( x, y ) {
        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
    },

    // Numero Negativo
    "signed-num-pre": function ( a ) {
        if(a === "-" || a === ""){
            a = 0;
        }else if(typeof a === 'string'){
            a = parseFloat(a.replace(/\+/,''));
        }
        return a;
    },
    "signed-num-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "signed-num-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },

    // Imagem
    "image-level-pre": function ( img ) {
        var alt = img.match(/alt=".*?"/gi);
        alt = alt[0];
        alt = alt.replace('alt=','').replace(/\"/g,'').replace(/\'/g,'');
        return alt.toLowerCase();
    },
    "image-level-asc": function ( x, y ) {
        return ( ( x < y ) ? -1 : ( ( x > y ) ?  1 : 0 ) );
    },
    "image-level-desc": function ( x, y ) {
        return ( ( x < y ) ?  1 : ( ( x > y ) ? -1 : 0 ) );
    },

    // Data
    "date-uk-pre": function ( a ) {
        // Apaga HTml e espaco de frente e tras
        a = a.replace(/<.*?>/g, '').replace(/^\s+|\s+$/g,"");
        var ukDatea = a.split('/');
        console.log(ukDatea);
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
 
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
    
    // Data Hora
    "date-euro-pre": function ( a ) {
        // Apaga HTml e espaco de frente e tras
        a = a.replace(/<.*?>/g, '').replace(/^\s+|\s+$/g,"");
        if ($.trim(a) !== '') {
            var frDatea = $.trim(a).split(' ');
            var frTimea = frDatea[1].split(':');
            var frDatea2 = frDatea[0].split('/');
            var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;
        } else {
            var x = 10000000000000; // = l'an 1000 ...
        }

        return x;
    },
    "date-euro-asc": function ( a, b ) {
        return a - b;
    },
    "date-euro-desc": function ( a, b ) {
        return b - a;
    },

    // Dinheiro
    "currency-pre": function ( a ) {
        // Apaga HTml e espaco de frente e tras
        a = a.replace(/<.*?>/g, '').replace(/^\s+|\s+$/g,"");
        // Retira Pontos
        a = a.replace( /\./, "" );
        // Retira Espacos
        a = a.replace( /,/, "." );
        a = (a ==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
        return parseFloat( a );
    },
    "currency-asc": function ( a, b ) {
        return a - b;
    },
    "currency-desc": function ( a, b ) {
        return b - a;
    },

    // Tamanho
    "file-size-pre": function ( a ) {
        var x = parseFloat(a),
            x_unit = (a.substring(a.length - 2, a.length));
        if(x_unit === "TB"){
            x_unit = 1099511627776;
        } else if (x_unit === "GB"){
            x_unit = 1073741824;
        } else if (x_unit === "MB"){
            x_unit = 1048576;
        } else if (x_unit === "KB"){
            x_unit = 1024;
        } else {
            x_unit = 1;
        }
        return x * x_unit;
    },
    "file-size-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "file-size-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },

    // Numerois
    "formatted-num-pre": function ( a ) {
        a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
        return parseFloat( a );
    },
    "formatted-num-asc": function ( a, b ) {
        return a - b;
    },
    "formatted-num-desc": function ( a, b ) {
        return b - a;
    },

    // Endereco IP
    "ip-address-pre": function ( a ) {
        var m = a.split("."), x = "", i;

        for (i = 0; i < m.length; i++) {
            var item = m[i];
            if (item.length === 1) {
                x += "00" + item;
            } else if (item.length === 2) {
                x += "0" + item;
            } else {
                x += item;
            }
        }

        return x;
    },
    "ip-address-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "ip-address-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});
