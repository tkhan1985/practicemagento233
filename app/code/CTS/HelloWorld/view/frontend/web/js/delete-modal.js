define([
    'jquery',
    'Magento_Ui/js/modal/confirm'
],
function($, confirmation) {
    $('.delete_item').on('click', function (e){
        e.preventDefault();
        var url = e.currentTarget.href;
        //alert(url);
        confirmation({
            title: 'Delete Item',
            content: 'Do you want to delete this item?',
            actions: {
                confirm: function () {
                    $.ajax({
                         showLoader: true,
                         url: url,
                         data: {},
                         type: "GET",
                         success: function (data) {
                              //$(this).parents("tr").remove();
                              window.location.reload(true);
                              //window.location.href = '/helloworld';
                        }, error: function (error) {

                        }
                    });
                },
                cancel: function () {
                    return false;
                }
            }
        });
    });
});
