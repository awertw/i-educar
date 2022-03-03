var idAtual = -1;

(function($){
    $(document).ready(function(){
        document.getElementById('alunos').onchange = function () {
            var ocorrenciaElementos = document.getElementsByClassName("oc");
            var ocorrenciaActionBars = [];
            var ocorrenciaLinksToCreate = [];

            for (let index = 0; index < ocorrenciaElementos.length; index++) {
                const ocorrenciaElemento = ocorrenciaElementos[index];
                const id = getID(ocorrenciaElemento.getAttribute('id'));

                if (document.getElementById(`cadastrar-ocorrencia-link-${id}`) == null) {
                    var tempOcorrenciaActionBar = $j('<span>')
                        .html('')
                        .appendTo(ocorrenciaElemento);

                    var tempOcorrenciaLinkToCreate = $j('<a>')
                        .attr('id', `cadastrar-ocorrencia-link-${id}`)
                        .html(`[${id}]`)
                        .appendTo(tempOcorrenciaActionBar);

                    $j(`#cadastrar-ocorrencia-link-${id}`).click(function () {
                        openModalParent(`${id}`);
                    });
                        
                    ocorrenciaActionBars.push(tempOcorrenciaActionBar);
                    ocorrenciaLinksToCreate.push(tempOcorrenciaLinkToCreate);
                }
            }
        };
    });
})(jQuery);

function openModalParent(id) {
    idAtual = id;

    $j("#dialog-form-pessoa-parent").dialog("open");

    $j('#dialog-form-pessoa-parent form h2:first-child').html('Ocorrência disciplinar de ' + id).css('margin-left', '0.75em');
}

$j('body').append('<div id="dialog-form-pessoa-parent"><form><h2></h2><table><tr><td valign="top"><fieldset><label for="horas-parent"> Horas </label> <input onkeypress="formataHora(this, event, false);" type="text" name="horas-parent" id="horas-parent" value="00:00" size="6" maxlength="5">   <label for="observacao-parent">Observação</label><textarea type="text " name="observacao-parent" id="observacao-parent" maxlength="2048" class="text" cols="60" rows="10"/>   <div id="visivel-pais-modal"> <label>Visível aos pais?</label><input type="checkbox" name="visivel-pais-parent" id="visivel-pais-parent" style="display:inline;"> </div></fieldset></form></div>');

$j('#dialog-form-pessoa-parent').find(':input').css('display', 'block');

var horasParent = $j("#horas-parent"),
    observacaoParent = $j("#observacao-parent"),
    visivelPaisParent = $j("#visivel-pais-parent"),
    allFields = $j([]).add(horasParent).add(observacaoParent).add(visivelPaisParent);

$j("#dialog-form-pessoa-parent").dialog({
    autoOpen: false,
    height: 'auto',
    width: 'auto',
    modal: true,
    resizable: false,
    draggable: false,
    buttons: {
        "Gravar": function () {
            console.log("Gravando...");

            var bValid = true;
            allFields.removeClass("ui-state-error");

            bValid = bValid && checkLength(observacaoParent, "observação", 3, 2048);

            if ($j("#horas-parent").val() != '') {
                bValid = bValid && checkRegexp(horasParent, /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/, "O campo de horas está incorreto. [00:00-23-59]");
            }

            if (bValid) {
                postOcorrencia(
                    ano.value,
                    idAtual,
                    "1",
                    data.value,
                    horasParent.val(),
                    observacaoParent.val(),
                    visivelPaisParent.is(':checked')
                );
            }
        },
        "Cancelar": function () {
            $j(this).dialog("close");
        }
    },
    create: function () {
        $j(this)
            .closest(".ui-dialog")
            .find(".ui-button-text:first")
            .addClass("btn-green");
    },
    close: function () {
        allFields.val("").removeClass("error");
    },
    hide: {
        effect: "clip",
        duration: 500
    },
    show: {
        effect: "clip",
        duration: 500
    }
});

function getID (id) {
    id = id.substring(id.indexOf('[') + 1, id.indexOf(']'));
    return id;
}

function checkLength(o, n, min, max) {
    if (o.val().length > max || o.val().length < min) {
        o.addClass("error");

        messageUtils.error("Tamanho da " + n + " deve ter entre " +  min + " e " + max + " caracteres.");
        return false;
    } else {
        return true;
    }
}

function checkRegexp(o, regexp, n) {
    if (!( regexp.test(o.val()) )) {
        o.addClass("error");
        messageUtils.error(n);
        return false;
    } else {
        return true;
    }
}

function postOcorrencia(
    ano,
    matricula,
    tipo,
    data,
    horas,
    observacao,
    visivelPais
) {
    let url = postResourceUrlBuilder.buildUrl(
        '/module/Api/ocorrenciaDisciplinar',
        'post-ocorrencia-disciplinar',
            {
                ano: ano,
                matricula: matricula,
                tipo: tipo,
                data: data,
                horas: horas,
                observacao: observacao,
                visivelPais: visivelPais
            }
        );

    var options = {
        url: url,
        dataType: 'json',
        success: function (dataResponse) {
            if (dataResponse['any_error_msg']) {
                dataResponse['msgs'].forEach(msgObject => {
                    messageUtils.error(msgObject['msg']);
                });
            } else {
                $j("#dialog-form-pessoa-parent").dialog('close');
            }
        }
    };

    postResource(options);
}
