var password=document.getElementById("password"),confirm=document.getElementById("confirm");

function validatePassword(){

	if(password.value!=confirm.value){
		confirm.setCustomValidity("Password dont match ");
	}else{
		confirm.setCustomValidity("");
	}
}
password.onchange=validatePassword;
confirm.onkeyup=validatePassword;

$(function(){

	$("#role").change(function(){
		if($(this).val() == 'SELLER'){
			$("#address_block").css("display", "none");		
			$("#phone_number_block").css("display", "none");
			$("#address_block").css("height", "0px!important");		
			$("#phone_number_block").css("height", "0px!important");	

			$("#adress").attr("required", false);		
			$("#phone_number").attr("required", false);	
		}else{

			$("#address_block").css("display", "flex");		
			$("#phone_number_block").css("display", "flex");
			$("#address_block").css("height", "38px!important");		
			$("#phone_number_block").css("height", "38px!important");	
			$("#adress").attr("required", true);		
			$("#phone_number").attr("required", true);	
		}

	});

});
