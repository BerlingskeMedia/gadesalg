(function($){
$(document).ready(function()
{
	$('#login_form').live('submit', function (e) {

		//cache the form element for use in this function
		var $this = $(this);

		//prevent the default submission of the form
		e.preventDefault();

		//run an AJAX post request to your server-side script, $this.serialize() is the data from your form being added to the request
		$.post($this.attr('action'), $this.serialize(), function (data) {
			//in here you can analyze the output from your server-side script (responseData) and validate the user's login without leaving the page
			if(data == ':)') {
				$.mobile.changePage("index.php?q=menu", "slide");
			} else {
				displayMessage('Brugernavn eller password blev ikke genkendt');
			}
			//console.log(data);
		});

		return false;
	});

});

function displayMessage(message) {
	var msg = $('#messages');
	msg.text(message);
	msg.slideDown();

	var timer = setTimeout(function () {
		msg.slideUp(function(){
			msg.text('');
		});
		
	}, 3000);
}


})(jQuery);
