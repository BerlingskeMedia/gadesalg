(function($){
$(document).ready(function()
{
	$('#page').live('pageinit', function(e){
		$('a[data-rel="back"]').find('.ui-btn-text').text('Tilbage');
	});
});
})(jQuery);
