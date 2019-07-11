angular.module("WholeSale",[]);

var base_url = $("#base_url").val();
var current_url = $("#current_url").val();

angular.module('WholeSale').config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

function PrintDocument()
{

}

function alert_message(title, content)
{
    $.notify({
        title: "<strong>" + title + "</strong> ",
        message: content
    }, {
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        type: 'warning'
    });
}