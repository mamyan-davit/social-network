$(document).ready(function(){

// Hiding first items of selects from login page
	$('#countryList').click(function(){
		$('#select1').attr('disabled', 'true');
	})

	$('#genderList').click(function(){
		$('#select2').attr('disabled', 'true');
	})

	$('#select_topic').click(function(){
		$('#select3').attr('disabled', 'true');
	})



//Character counting in contact page
	var text_max = 300;
		$('#textarea_feedback').html(text_max + ' ' + 'characters remaining');
		$('#textarea').keyup(function(){
			var text_length = $('#textarea').val().length;
			var text_remain = text_max - text_length;
			$('#textarea_feedback').html(text_remain + ' ' + 'characters remaining');
	});




//showing password by checkbox in login page
	$('.password').after('<input type="checkbox" class="show_password form-control">');
			$('.show_password').change(function(){
				var prev = $(this).prev();
				var value = prev.val();
				var type = prev.attr('type');
				var name = prev.attr('name');
				var id = prev.attr('id');
				var clas = prev.attr('class');//if have other attrs, add them as well

				if (type=='password') {
					var new_type = 'text';
				}else if(type=='text'){
					var new_type = 'password';
				}

				/*short way
					var new_type = (type=='password') ? 'text' : 'password'
				*/

				prev.remove();

				$(this).before('<input type="'+ new_type +'" value="'+ value +'" name="'+ name +'" id="'+ id +'" class="'+ clas +'">')
			})
})