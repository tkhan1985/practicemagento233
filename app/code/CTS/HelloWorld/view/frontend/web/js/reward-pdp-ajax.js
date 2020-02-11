define([
    "jquery",
    "jquery/ui"
], function($){
   // "use strict";

    function main(config, element) {
        //var $element = $(element);
        //var AjaxUrl = config.AjaxUrl;
        var dataForm = $('#additional_reward');
        dataForm.mage('validation', {});
        $('#getReward').on('click', function (e){
            e.preventDefault();
           if (dataForm.valid()){
               var param = dataForm.serialize();
               setTimeout(function(){
                  $('body').trigger('processStart');
                   $.ajax({
                       context: '#ajaxresponse',
                       url: 'helloworld/catalog/reward',
                       type: "POST",
                       data: param,
                   }).done(function (data) {
                       $('body').trigger('processStop');
                       $('#ajaxresponse').html(data.output);
                       document.getElementById("additional_reward").reset();
                       return true;
                   }).fail(function (response) {
                  //stop loader
                     $('#ajaxresponse').html('<span style="background-color:red;padding:4px">Error in processing request!</span>');
                     $('body').trigger('processStop');
                 });
               },2000);
            }
        });
    };
    return main;
});
