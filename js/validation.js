$(document).ready(function(){
	var flag = false;

	/*******************************************************************************************************************/
	/*******************************************************************************************************************/
	$( "#contactus" ).submit(function( event ) {
		
		if($('input[name="fullname"]').val()=='')
		{
			alert("Please fill in your name.");
			$('input[name="fullname"]').focus();
			event.preventDefault();
			return false;
		}

		if($('input[name="email"]').val()=='')
		{
			alert("Please fill in your email.");
			$('input[name="email"]').focus();
			event.preventDefault();
			return false;
		}
		
		var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!regex_email.test($('input[name="email"]').val()))
		{
			alert("Please fill in a valid email.");
			$('input[name="email"]').focus();
			event.preventDefault();
			return false;
		}
		
		var regex_mobile = /^[0-9\-\+]{5,20}$/;
		if($('input[name="contactno"]').val()=='')
		{
			alert("Please fill in your phone number.");
			$('input[name="contactno"]').focus();
			event.preventDefault();
			return false;
		}
	
		if($('input[name="contactno"]').val()!='')
		{
			if(!regex_mobile.test($('input[name="contactno"]').val()))
			{
				alert("Please fill in a valid phone number.");
				$('input[name="contactno"]').focus();
				event.preventDefault();
				return false;
			}
		}

		if($('input[name="inquiry"]').val()=='')
		{
			alert("Please fill in your inquiry.");
			$('input[name="inquiry"]').focus();
			event.preventDefault();
			return false;
		}
		
		if(!$('input[name="agree"]').is(':checked'))
		{
			alert("Please tick to proceed.");
			$('input[name="agree"]').focus();
			event.preventDefault();
			return false;
		}
	});
});


function validate(textbox)
{
	if($(textbox).attr("name") == 'fullname')
	{
		if (textbox.value == '')
		textbox.setCustomValidity('Please fill in your name.');
		else
		textbox.setCustomValidity('');
	}

	if($(textbox).attr("name") == 'email')
	{
		if (textbox.value == '')
		textbox.setCustomValidity('Please fill in your email.');
		else if(textbox.validity.typeMismatch)
		textbox.setCustomValidity('Please fill in a valid email.');
		else
		textbox.setCustomValidity('');
	}
	
	if($(textbox).attr("name") == 'contactno')
	{
		var regex_mobile = /^[0-9\-\+]{5,20}$/;
	
		if (textbox.value == '')
		textbox.setCustomValidity('Please fill in a valid phone number.');
		else if(textbox.value != '' && regex_mobile.test(textbox.value)==false)
		textbox.setCustomValidity('Please fill in a valid phone number.');
		else
		textbox.setCustomValidity('');
	}
	
	if($(textbox).attr("name") == 'inquiry')
	{
		if (textbox.value == '')
		textbox.setCustomValidity('Please fill in your inquiry.');
		else
		textbox.setCustomValidity('');
	}

	if($(textbox).attr("name") == 'agree')
	{
		if (textbox.checked == false) {
			textbox.setCustomValidity('Please read the Consent Clause before submit.');
		}
		else {
			textbox.setCustomValidity('');
		}
	}
}

//-->
