//função de login!
function userlogin(){
	uemail = $("#modal_login input#usuarioEmail");
	usenha = $("#modal_login input#usuarioPassword");
	alertM = $("#mensagem");
	modalLogin = $("#modal_login");

	if( uemail.val().length <= 0){
		alertM.addClass("alert-danger").html("O email está em branco! Não esqueça de preencher!").show("fast");
		uemail.removeClass("sucesso").addClass("erro").focus();
		return;
	}else {
		uemail.addClass("sucesso");
	}

	if( usenha.val().length <= 0){
		alertM.addClass("alert-danger").html("A senha está em branco! Não esqueça de preencher!").show("fast");
		usenha.removeClass("sucesso").addClass("erro").focus();
		return;
	}else {
		usenha.addClass("sucesso");
	}

	$.ajax({
		url:"../controller/user/login.php",
		method:"POST",
		dataType: 'JSON',
		data:{
			email: uemail.val(),
			senha: usenha.val()
		},
		success:function(ret){
			if(ret.erro == 0){
				alertM.removeClass("alert-danger").addClass("alert-success").html(ret.msg).show("fast");
				cookie.setCookie("user_id",ret.usuario.id,1);
				cookie.setCookie("user_name",ret.usuario.nome,1);
				cookie.setCookie("logado",true,1);
			}else if(ret.erro == 2 ){
				alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
				uemail.removeClass("sucesso").addClass("erro").focus();
			}else{
				alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
				uemail.removeClass("sucesso").addClass("erro").focus();
				usenha.removeClass("sucesso").addClass("erro");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
               // Handle errors here
               console.log('ERRORS: ' + textStatus);
               alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
           }
       });
}

$(document).ready(function(){
	$("#logar").click(function (event){
		event.preventDefault();
		userlogin();
	});
	$("#limparLogin").click(function () {
		$("#modal_login input#usuarioEmail").removeClass("sucesso").removeClass("erro");
		$("#modal_login input#usuarioPassword").removeClass("sucesso").removeClass("erro");
		$("#mensagem").hide("fast");
	})
});