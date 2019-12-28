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
