
function isValid(str,regex) {
	var r = str.match(regex);
	console.log(r);
	if(r == null)
		return false;
	return (r.length > 0 ? true : false);
}

function isEmpty(str) {
	return (str.trim().length == 0);
}

function isValidInt(str) {
	return isValid(str,/^\d+$/);
}

function isValidEmail(str) {
	return isValid(str,/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]+\.[A-Za-z]{2,4}$/);
}

function isValidPhone(str) {
	return isValid(str,/^(\+45){0,1}[ ]{0,1}([1-9][0-9][ ]{0,1}\d{2}[ ]{0,1}\d{2}[ ]{0,1}\d{2})$/);
}


function isValidDate(str) {
	return isValid(str,/^(0[1-9]|[12][0-9]|3[01])[-](0[1-9]|1[012])[-]\d\d\d\d$/);
}

function isValidZip(str) {
	return isValid(str,/^\d{3,4}$/);
}

function isValidDecimal(str) {
	return isValid(str,/^\d+([\.,](\d{1,2}))?$/);
}

function isValidStreet(str) {
	return isValid(str,/^[A-Za-z\u0080-\u00FF][A-Za-z \.\u0080-\u00FF]+$/);
}


function isValidPreciseInt(str,size) {
	var regex = new RegExp('^\\d{'+size.toString()+'}$');
	console.log(regex);
	return isValid(str,regex);
}

function isValidRangeInt(str, min_size, max_size) {
	var regex = new RegExp('^\\d{'+min_size.toString().concat(',', max_size)+'}$');
	console.log(regex);
	return isValid(str,regex);
}

function isValidSsn (str) {
	if (str.length === 8) {
		var cvr_check = "2765432";
		return mod11(str, cvr_check);
	} else if (str.length === 10) {
		var cpr_check = "432765432";
		return mod11(str, cpr_check);
	} else {
		return false;
	}
}


// From http://kode.porten.dk/cpr_fix/
function mod11 (value, check) {
	var sum = 0;

	for(var i = 0; i < value.length - 1; i++) {
		sum += parseInt(value.charAt(i), 10) * parseInt(check.charAt(i), 10);
	}

	var check_digit = 11 - sum % 11;
	var valid = check_digit === parseInt(value.charAt(value.length - 1), 10);
	return valid;
}

/*


*/
