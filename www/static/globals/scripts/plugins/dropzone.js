/* 
 * Dropzone -> Necessario para
 */
var dropToUpload = {

    create: function (id) {
        Dropzone.autoDiscover = false;
        Dropzone.options.myAwesomeDropzone = {
            dictDefaultMessage:   Linguagem['Dropzone']['Mensagem'],
            dictFallbackMessage:  Linguagem['Dropzone']['MensagemErro'],
            dictFallbackText:     Linguagem['Dropzone']['TextoErro']
        };
        var url = $(id).attr('action');

        $(id).dropzone({
            url: url,
            success: function(file,response) {
                Sierra.Modelo_Ajax_JsonTratar(url,response,false);
                if (file.previewElement) {
                    return file.previewElement.classList.add("dz-success");
                }
            }
        });
    },

    init: function (id) {
        this.create(id);
    }
}

