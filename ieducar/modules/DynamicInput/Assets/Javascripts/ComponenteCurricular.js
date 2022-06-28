<<<<<<< HEAD
(function($){
  $(document).ready(function(){

    var $anoField                  = getElementFor('ano');
    var $turmaField                = getElementFor('turma');
    var $componenteCurricularField = getElementFor('componente_curricular');

    var $componenteCurricularTitleField =  $componenteCurricularField[0].parentElement.parentElement.parentElement.children[0].children[0];
    
    var handleGetComponentesCurriculares = function(response) {
      var selectOptions = jsonResourcesToSelectOptions(response['options']);
      updateSelect($componenteCurricularField, selectOptions, "Selecione um componente curricular");
    }

    function getResultado(xml) {
      $componenteCurricularTitleField.innerText = xml.getElementsByTagName("ce")[0]?.getAttribute("resp") == '0' ? 'Componente curricular' : 'Campo de experiência';
    }

    var xml = new ajax(getResultado);
    xml.envia("educar_campo_experiencia_xml.php?tur=" + $turmaField.val());

    var updateComponentesCurriculares = function(){
      resetSelect($componenteCurricularField);

      if ($anoField.val() && $turmaField.val() && $turmaField.is(':enabled')) {
        $componenteCurricularField.children().first().html('Aguarde, carregando...');

        var xml = new ajax(getResultado);
        xml.envia("educar_campo_experiencia_xml.php?tur=" + $turmaField.val());

        var data = {
          ano      : $anoField.attr('value'),
          turma_id : $turmaField.attr('value')
        };

        var urlForGetComponentesCurriculares = getResourceUrlBuilder.buildUrl(
          '/module/DynamicInput/componenteCurricular', 'componentesCurriculares', data
        );

        var options = {
          url : urlForGetComponentesCurriculares,
          dataType : 'json',
          success  : handleGetComponentesCurriculares
        };

        getResources(options);
      }

      $componenteCurricularField.change();
    };

    // bind onchange event
    $turmaField.change(updateComponentesCurriculares);

  }); // ready
})(jQuery);
=======
(function($){
  $(document).ready(function(){

    var $anoField                  = getElementFor('ano');
    var $serieField                = getElementFor('serie');
    var $turmaField                = getElementFor('turma');
    var $componenteCurricularField = getElementFor('componente_curricular');

    var handleGetComponentesCurriculares = function(response) {
      var selectOptions = jsonResourcesToSelectOptions(response['options']);
      updateSelect($componenteCurricularField, selectOptions, "Selecione um componente curricular");
    }

    var updateComponentesCurriculares = function(){
      resetSelect($componenteCurricularField);

      if ($anoField.val() && $turmaField.val() && $turmaField.is(':enabled')) {
        $componenteCurricularField.children().first().html('Aguarde carregando...');

        var data = {
          ano      : $anoField.attr('value'),
          serie_id : $serieField.attr('value'),
          turma_id : $turmaField.attr('value')
        };

        var urlForGetComponentesCurriculares = getResourceUrlBuilder.buildUrl(
          '/module/DynamicInput/componenteCurricular', 'componentesCurriculares', data
        );

        var options = {
          url : urlForGetComponentesCurriculares,
          dataType : 'json',
          success  : handleGetComponentesCurriculares
        };

        getResources(options);
      }

      $componenteCurricularField.change();
    };

    // bind onchange event
    $turmaField.change(updateComponentesCurriculares);

  }); // ready
})(jQuery);
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
