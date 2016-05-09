(function($) {

	// SLIDER OF MILES
	$("#ex6").slider();
	$("#ex6").on("slideStop", function(slideEvt) {
		$("#ex6SliderVal").text(slideEvt.value);
	});
	
}(window.jQuery));

//pseudo ajax
$('#ex6').on('slideStop', function(slideEvt) {
	$('input[name=page]').val(1);
	$('form').submit();
});

if(window.location.hash) {
      var hash = window.location.hash.substring(1);
      $('#'+hash).removeClass('dn');
  }