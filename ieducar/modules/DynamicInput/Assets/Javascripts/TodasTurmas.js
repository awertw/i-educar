(function($){
  $(document).ready(function(){
    
    var $anoField                  = getElementFor('ano');
    var $turmaField                = getElementFor('ref_cod_turma');

    var handleGetTodasTurmas = function(response) {
      var selectOptions = jsonResourcesToSelectOptions(response['options']);
      updateSelect($turmaField, selectOptions, "Selecione uma turma");
    }

    var updateTodasTurmas = function(){
      resetSelect($turmaField);

      if ($anoField.val() && $anoField.is(':enabled')) {
        $turmaField.children().first().html('Aguarde, carregando...');

        var data = {
          ano      : $anoField.attr('value')
        };

        var urlForGetTodasTurmas = getResourceUrlBuilder.buildUrl(
          '/module/DynamicInput/todasTurmas', 'todasTurmas', data
        );

        var options = {
          url : urlForGetTodasTurmas,
          dataType : 'json',
          success  : handleGetTodasTurmas
        };

        getResources(options);
      }

      $turmaField.change();
    };

    $anoField.change(updateTodasTurmas);
  });
})(jQuery);
