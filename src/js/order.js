(function($){
$(document).ready(function()
{

	$('#page').live( "pagecreate", function() {
		var sold_date = $( "#sold_date", this );
		sold_date.mobipick({
			date: new Date(),
			dateFormat: "dd-MM-yyyy"
		});

		var start_date = $( "#start_date", this );
		start_date.mobipick({
			date: new Date(),
			dateFormat: "dd-MM-yyyy"
		});
	});

	$('#page').live( "pageinit", function()
	{
		console.log("requesting callback");
		Geo.getPosition(function(pos)
		{
			if(pos.id != 0)
			{
				console.log("changing pos select: " + pos.id);
				$("#pos_id").val(pos.id);
				$("#pos_id").selectmenu("refresh");
			}
		});
	});

	$('#send_order').live('submit', function (e) {
		var $this = $(this);
		e.preventDefault();

		if(validate_order()) {
			//run an AJAX post request to your server-side script, $this.serialize() is the data from your form being added to the request
			$("[type='submit']").button('disable');
			$("[type='submit']").button('refresh');
			$.post($this.attr('action'), $this.serialize(), function (data) {
				//in here you can analyze the output from your server-side script (responseData) and validate the user's login without leaving the page
				$("[type='submit']").button('enable');
				$("[type='submit']").button('refresh');
				if(data == ':)') {
					$.mobile.changePage("index.php?q=order_saved_dialog", "pop", false, false);
					//$.mobile.changePage("index.php?q=menu", "slide");
				} else {
					//$.mobile.changePage("index.php?q=order_not_saved_dialog", "pop", false, false);
					//$.mobile.changePage("index.php?q=menu", "slide");
					console.log(data);
				}

			});
		} else {
			$('html, body').animate({
				scrollTop: $("#page").offset().top
			}, 1500);
		}

		return false;
	});

	$('#zip_input').live('blur', function(e)
	{
		var pnum = $('#zip_input').val();
		console.log("Looking up pnum " + pnum);

		$.ajax({
  			url: 'index.php?q=mingapi_lookup_zip',
  			dataType: 'json',
  			type: 'POST',
  			data: {zip: pnum},
  			success: function(data)
  			{
				console.log(data);
				$('#district_input').val(data.district);
  			}
		});
	});

	function validate_order() {
		$('.ui-form-error').removeClass('ui-form-error');
		var has_errors = false;
		var v;

		// These fields should be filled out as a minimum
		v = $('[name="firstname"]').val();
		v = isEmpty(v.toString());
		if(v) {
			set_error('firstname');
			has_errors = true;
		}

		v = $('[name="lastname"]').val();
		v = isEmpty(v.toString());
		if(v) {
			set_error('lastname');
			has_errors = true;
		}

		v = $('[name="city"]').val();
		v = isEmpty(v.toString());
		if(v) {
			set_error('city');
			has_errors = true;
		}


		// Validate content of these fields
		v = $('[name="house_number"]').val();
		v = isValidInt(v.toString());
		if(!v) {
			set_error('house_number');
			has_errors = true;
		}

		v = $('[name="email"]').val();
		if(!isEmpty(v)) {
			v = isValidEmail(v.toString());
			if(!v) {
				set_error('email');
				has_errors = true;
			}
		}

		v = $('[name="phone"]').val();
		if(!isEmpty(v)) {
			v = isValidPhone(v.toString());
			if(!v) {
				set_error('phone');
				has_errors = true;
			}
		}

		v = $('[name="mobile"]').val();
		if(!isEmpty(v)) {
			v = isValidPhone(v.toString());
			if(!v) {
				set_error('mobile');
				has_errors = true;
			}
		}

		v = $('[name="start_date"]').val();
		v = isValidDate(v.toString());
		if(!v) {
			set_error('start_date');
			has_errors = true;
		}

		v = $('[name="sold_date"]').val();
		v = isValidDate(v.toString());
		if(!v) {
			set_error('sold_date');
			has_errors = true;
		}

		v = $('[name="zip"]').val();
		if ($('[name="country"]').val() === 'Denmark') {
			v = isValidZip(v.toString());
		} else {
			v = !isEmpty(v.toString());
		}
		if(!v) {
			set_error('zip');
			has_errors = true;
		}

		v = $('[name="price"]').val();
		v = isValidDecimal(v.toString());
		if(!v) {
			set_error('price');
			has_errors = true;
		}

		v = $('[name="street"]').val();
		v = isValidStreet(v.toString());
		if(!v) {
			set_error('street');
			has_errors = true;
		}

		v = $('[name="ssn"]').val();
		if(!isEmpty(v)) {
			v = isValidSsn(v.toString());
			if(!v) {
				set_error('ssn');
				has_errors = true;
			}
		}

		v = $('[name="reg"]').val();
		if(!isEmpty(v)) {
			v = isValidPreciseInt(v.toString(),4);
			if(!v) {
				set_error('reg');
				has_errors = true;
			}
		}

		v = $('[name="knr"]').val();
		if(!isEmpty(v)) {
			v = isValidRangeInt(v.toString(),6, 10);
			if(!v) {
				set_error('knr');
				has_errors = true;
			}
		}

		v = $('[name="payment_type_id"]').val();
		if(v == 1) {
			$('[name="payment_type_id"]').parent().addClass('ui-form-error');
			has_errors = true;
		}

		return !has_errors;
	}

	function set_error(str) {
		$('[name="'+str+'"]').addClass('ui-form-error');
	}

});
})(jQuery);
