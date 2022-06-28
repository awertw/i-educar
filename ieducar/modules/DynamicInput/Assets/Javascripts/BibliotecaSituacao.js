<<<<<<< HEAD
(function($){
  $(document).ready(function(){
    var $bibliotecaField = getElementFor('biblioteca');
    var $situacaoField   = getElementFor('situacao');

    var handleGetSituacoes = function(resources) {
      var selectOptions = xmlResourcesToSelectOptions(resources, 'query', 'cod_situacao');
      updateSelect($situacaoField, selectOptions, "Selecione uma situa&ccedil;&atilde;o");
    }

    var updateSituacoes = function(){
      resetSelect($situacaoField);

      if ($bibliotecaField.val() && $bibliotecaField.is(':enabled')) {
        $situacaoField.children().first().html('Aguarde carregando...');

        var urlForGetSituacoes = getResourceUrlBuilder.buildUrl('educar_situacao_xml.php', '', {
                                                       bib : $bibliotecaField.attr('value') });

        var options = {
          url : urlForGetSituacoes,
          dataType : 'xml',
          success  : handleGetSituacoes
        };

        getResources(options);
      }

      $situacaoField.change();
    };

    // bind onchange event
    $bibliotecaField.change(updateSituacoes);

  }); // ready
})(jQuery);
=======
(function($){
  $(document).ready(function(){
    var $bibliotecaField = getElementFor('biblioteca');
    var $situacaoField   = getElementFor('situacao');

    var handleGetSituacoes = function(resources) {
      var selectOptions = xmlResourcesToSelectOptions(resources, 'query', 'cod_situacao');
      updateSelect($situacaoField, selectOptions, "Selecione uma situação");
    }

    var updateSituacoes = function(){
      resetSelect($situacaoField);

      if ($bibliotecaField.val() && $bibliotecaField.is(':enabled')) {
        $situacaoField.children().first().html('Aguarde carregando...');

        var urlForGetSituacoes = getResourceUrlBuilder.buildUrl('educar_situacao_xml.php', '', {
                                                       bib : $bibliotecaField.attr('value') });

        var options = {
          url : urlForGetSituacoes,
          dataType : 'xml',
          success  : handleGetSituacoes
        };

        getResources(options);
      }

      $situacaoField.change();
    };

    // bind onchange event
    $bibliotecaField.change(updateSituacoes);

  }); // ready
})(jQuery);
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
