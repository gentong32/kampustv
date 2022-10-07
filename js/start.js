// start functions boostraps js

(function(){
$('.bp-component [data-toggle="tooltip"]').tooltip();

$('[data-toggle="popover"]').popover('hide')

$('#loading-example-btn').click(function () {
  var btn = $(this);
  btn.button('loading')
});
})();
