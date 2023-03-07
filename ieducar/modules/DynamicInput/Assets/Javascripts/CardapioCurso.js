(function($){
    $(document).ready(function(){
      var $anoField                  = getElementFor('ano');
      var $cursoField = getElementFor('curso');
      var $cardapioCursoField = getElementFor('cardapio_curso');

      var $cardapioComponenteTitleField =  $cardapioCursoField[0].parentElement.parentElement.parentElement.children[0].children[0];

      var handleGetCardapios = function(response) {
        var selectOptions = jsonResourcesToSelectOptions(response['options']);
        updateSelect($cardapioCursoField, selectOptions, "Selecione um cardápio");
      }

     $cardapioComponenteTitleField.innerText =  'Cardápio:';
     var updateCardapio = function(){
        $cardapioCursoField.children().first().html('Aguarde, carregando...');
        var data = {
          ano      : $anoField.attr('value'),
          curso : $cursoField.attr('value')

        };

        var urlForGetCardapioCurso = getResourceUrlBuilder.buildUrl(
          '/module/DynamicInput/cardapioCurso', 'cardapioCurso', data
        );

        var options = {
          url : urlForGetCardapioCurso,
          dataType : 'json',
          success  : handleGetCardapios
        };

        getResources(options);


      $cardapioCursoField.change();

    };
    $cursoField.change(updateCardapio);
    $anoField.change(updateCardapio);
    
      

    }); // ready
  })(jQuery);
