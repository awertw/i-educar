(function($){
  $(document).ready(function(){
    let verificaAcaoEditar = document.getElementById('ref_cod_turma').value != '';
    document.getElementById('data_falta_atraso').disabled = verificaAcaoEditar;
    document.getElementById('justificada').disabled = verificaAcaoEditar;

    let obj_tipo = document.getElementById('tipo');
    obj_tipo.onchange = displayQtdHorasMin;

    if (obj_tipo.value != '2') {
      hideAulas();
    }

    function hideAulas() {
      $('#tr_aulas_lista_').hide();
    }

    var obj_justificada = document.getElementById('justificada');
    obj_justificada.onchange = displayJustificada;

    displayQtdHorasMin();
    displayJustificada();

    function displayQtdHorasMin() {
      setVisibility('tr_qtd_horas', false);
      setVisibility('tr_qtd_min', false);

      if (document.getElementById('tipo').value == 1) {
        setVisibility('tr_qtd_horas', true);
        setVisibility('tr_qtd_min', true);
      }
    }

    function displayJustificada() {
      setVisibility('tr_observacao', false);

      if (obj_justificada.value === '0') {
        setVisibility('tr_observacao', true);
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

      for (let i = 0; i < registrosLength; i++) {
        let registro = responseRegistros[i];

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
                                <input type="checkbox" name="aulas[${registro.ref_cod_quadro_horario_horarios}][]" value="${qtd}">
                     </td>`;
        }

        html += ' </tr></p></td></tr>';
        html += ' </table>';

      }

      if (html) {
        objAulasQuadroHorario.innerHTML = html;
      }

      $('#tr_aulas_lista_').show();

    }

    $('#data_falta_atraso').change(function() {
      getAulasQuadroHorario()
    });

  });
})(jQuery);
