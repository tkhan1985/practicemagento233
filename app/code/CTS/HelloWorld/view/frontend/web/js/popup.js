require(
      [
           'jquery',
           'Magento_Ui/js/modal/modal',
           'domReady!'
      ],
      function($, modal) {
          $('.main-block-image').on('click', function (e){
              e.preventDefault();
              var id = $(this).data('id');
              var images = $('#'+id).prop('src');
              //var url = e.currentTarget.href;
              //alert(url);
                    var options = {
                        type: 'popup',
                        responsive: true,
                        innerScroll: true,
                        buttons: false
                    };
                    var divid = "display-actual-image-"+id;
                    $('#'+divid).html('<img src="'+images+'">') ;
                    var popup = modal(options, $('#'+divid));
                    $("#"+divid).modal("openModal");
                 });
          });
