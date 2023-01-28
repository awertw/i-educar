(function($){
  $(document).ready(function(){
    let obj_tipo = document.getElementById('tipo');
    setVisibility('tr_qtd_horas', false);
    setVisibility('tr_qtd_min', false);

    obj_tipo.onchange = function()
    {
      if (document.getElementById('tipo').value == 1) {
        setVisibility('tr_qtd_horas', true);
        setVisibility('tr_qtd_min', true);
      }
      else if (document.getElementById( 'tipo' ).value == 2) {
        setVisibility('tr_qtd_horas', false);
        setVisibility('tr_qtd_min', false);
      }
    }

    var obj_justificada = document.getElementById('justificada');
    setVisibility('tr_observacao', false);

    obj_justificada.onchange = function()
    {
      if (obj_justificada.value == 0) {
        setVisibility('tr_observacao', true);
      }
      else if (obj_justificada.value == 1) {
        setVisibility('tr_observacao', false);
      }
    }

    function getAulasQuadroHorario() {
      const turmaId = document.getElementById('ref_cod_turma').value;
      const dataFaltaAtraso = document.getElementById('data_falta_atraso').value;
      const professorId = document.getElementById('ref_cod_professor_componente').value;

      let paramsAulasQuadroHorario = {
        turmaId: turmaId,
        dataFaltaAtraso: dataFaltaAtraso,
        professorId: professorId
      };

      let optionsAulasQuadroHorario = {
        url: getResourceUrlBuilder.buildUrl('/module/Api/CoordenadorFaltaAtraso', 'getAulasQuadroHorario', paramsAulasQuadroHorario),
        dataType: 'json',
        data: {},
        success: function (response) {
          console.log(response)
          carregarAulasQuadroHorario(response);
        },
      };

      getResource(optionsAulasQuadroHorario);
    }

    function carregarAulasQuadroHorario(response) {
      var objAulasQuadroHorario = document.getElementById('aulas');
      let responseRegistros = response.registros;
      let registrosLength = responseRegistros.length;

      let html = '';

      console.log('length registros: ' + registrosLength)
      console.log('registros: ' + responseRegistros)
      console.log('length: ' + response.length)

      for (let i = 0; i < registrosLength; i++) {
        let registro = responseRegistros[i];

        console.log(registro);

        html += '<table cellspacing="0" cellpadding="0" border="0">';
        html += '<tr align="left"><td><p><td class="tableDetalheLinhaSeparador" colspan="3"></td><tr><td><div class="scroll"><table class="tableDetalhe tableDetalheMobile" width="100%"><tr class="tableHeader">';
        html += '  <th><span style="display: block; float: left; width: auto; font-weight: bold">' + "Horário" + '</span></th>';
        html += '  <th><span style="display: block; float: left; width: auto; font-weight: bold">' + "Componente Curricular" + '</span></th>';

        for (let qtd = 1; qtd <= registro.qtdAulas; qtd++) {
          html += '  <th><span style="display: block; float: left; width: auto; font-weight: bold">' + "Aula " + qtd + '</span></th>';
        }

        html += '</tr>';
        html += '<tr><td class="tableDetalheLinhaSeparador" colspan="3"></td></tr>';

        html += ' <td class="sizeFont colorFont"><p>' + registro.horario + '</p></td>';
        html += ' <td class="sizeFont colorFont"><p>' + registro.componenteCurricular + '</p></td>';

        for (let qtd = 1; qtd <= registro.qtdAulas; qtd++) {
          html += ` <td class="sizeFont colorFont" > \
                                <input type="checkbox" onchange="presencaMudou(this)" id="aulas[]" name='aulas[]' data-aulaid="${qtd}" value="1" Checked>
                     </td>`;
        }

        html += ' </tr></p></td></tr>';
        html += ' </table>';

      }

      console.log(html)
      console.log(objAulasQuadroHorario)
      if (html) {
        objAulasQuadroHorario.innerHTML = html;
      }


    }

    $('#data_falta_atraso').change(function() {
      getAulasQuadroHorario()
    });

  });
})(jQuery);
