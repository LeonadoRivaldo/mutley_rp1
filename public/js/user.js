// MODULO DE CONTROLE DO USUARIO
var userController = function() {

    var embranco = function(campo,alertM,msg) {
        if (campo.val().length <= 0) {
            campo.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("a senha está em branco! não esqueça de preencher!");
            alertM.show("fast");
            campo.focus();
            return false;
        } else {
            campo.addClass("sucesso");
            return true;
        }
    }



    /**
     * função chama o arquivo user/get.php para buscar o usuario no banco
     * com base na sessão php criada
     */
     var get = function() {
        $.ajax({
            url: '../controller/user/get.php',
            method: 'GET',
            dataType: 'JSON',
            success: function(ret) {
                //implmentar teste para erros 
                $("input#usuarioEmail").val(ret.usuario.email);
                $("input#usuarioNome").val(ret.usuario.nome);
                //$("input#usuarioPassword").val(ret.usuario.senha);
                $("input#usuarioId").val(ret.usuario.uid);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // Handle errors here
               console.log('ERRORS: ' + textStatus);
               alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
           }
       });
    }
    var deleteUser = function() {
        alertM = $("#mensagem");
        $.ajax({
            url: '../controller/user/delete.php',
            method: 'POST',
            data:{
                uid: $("input#usuarioId").val()
            },
            dataType: 'JSON',
            success: function(ret) {
                if (ret.erro == 0) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    setTimeout(function () {
                       location.reload();
                   }, 1000);
                }else{
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // Handle errors here
               console.log('ERRORS: ' + textStatus);
               alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
           }
       });
    }

    /**
     * função para criar usuarios, vai usar ajax para chamar o user/create.php
     * e passar por post os valores de nome,email e senha
     * @param: nome => nome do usuario digitado no formulario
     * @param: email => email do usuario digitado no formulario
     * @param: senha => senha do usuario digitada no formulario
     * @return se o *ajax conseguir completar a requisão
     *   *ajax @return erro = 0 se o usuario foi criado
     *   *ajax @return erro = 1 se o usuario não foi criado
     *   *ajax @return msg = mensagem do servidor
     */
     function create() {
        alertM = $("#mensagem");
        modalLogin = $("#modal_login");
        unome = $("input#usuarioNome");
        uemail = $("input#usuarioEmail");
        usenha = $("input#usuarioPassword");
        if (unome.val().length <= 0) {
            unome.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("O nome está em branco! Não esqueça de preencher!");
            alertM.show("fast");
            unome.focus();
            return;
        } else {
            unome.addClass("sucesso");
        }

        if (uemail.val().length <= 0) {
            uemail.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("O email está em branco! Não esqueça de preencher!");
            alertM.show("fast");
            uemail.focus();
            return;
        } else {
            uemail.addClass("sucesso");
        }

        if (usenha.val().length <= 0) {
            usenha.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("A senha está em branco! Não esqueça de preencher!");
            alertM.show("fast");
            usenha.focus();
            return;
        } else {
            usenha.addClass("sucesso");
        }

        $.ajax({
            url: "../controller/user/create.php",
            method: "POST",
            dataType: 'JSON',
            data: {
                nome: unome.val(),
                email: uemail.val(),
                senha: usenha.val()
            },
            success: function(ret) {
                if (ret.erro == 0) {
                    cookie.setCookie("userAlterado", true, 0.0101);
                    login(uemail.val(), usenha.val());
                } else if (ret.erro == 2) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    uemail.removeClass("sucesso").addClass("erro").focus();
                } else if (ret.erro == 15) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html("Erro[" + ret.erro + "]: " + ret.msg).show("fast");
                    uemail.removeClass("sucesso").addClass("erro").focus();
                    usenha.removeClass("sucesso").addClass("erro");
                } else {
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
    /**
     * função para atualizar usuarios, vai usar ajax para chamar o user/update.php
     * e passar por post os valores de nome,email e senha
     * @param: nome => nome do usuario digitado no formulario
     * @param: email => email do usuario digitado no formulario
     * @param: senha => senha do usuario digitada no formulario
     * @return se o *ajax conseguir completar a requisão
     *   *ajax @return erro = 0 se o usuario foi criado
     *   *ajax @return erro = 1 se o usuario não foi criado
     *   *ajax @return msg = mensagem do servidor
     */
     function update() {
        alertM = $("#mensagem");
        modalLogin = $("#modal_login");
        unome = $("input#usuarioNome");
        uemail = $("input#usuarioEmail");
        usenha = $("input#usuarioPassword");
        if( $("input#usuarioPassword").val().length > 0 ){
            senha = $("input#usuarioPassword").val();
        }else{
            senha = "";
        }

        if (unome.val().length <= 0) {
            unome.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("O nome está em branco! Não esqueça de preencher!");
            alertM.show("fast");
            unome.focus();
            return;
        } else {
            unome.addClass("sucesso");
        }

        if (uemail.val().length <= 0) {
            uemail.addClass("erro");
            alertM.addClass("alert-danger");
            alertM.html("O email está em branco! Não esqueça de preencher!");
            alertM.show("fast");
            uemail.focus();
            return;
        } else {
            uemail.addClass("sucesso");
        }



        $.ajax({
            url: "../controller/user/update.php",
            method: "POST",
            dataType: 'JSON',
            data: {
                nome: unome.val(),
                email: uemail.val(),
                senha: senha,
                uid: $("input#usuarioId").val()
            },
            success: function(ret) {
                if (ret.erro == 0) {
                    alertM.removeClass("alert-danger").addClass("alert-success").html(ret.msg).show("fast");
                    cookie.setCookie("userAlterado", true, 0.0101);
                } else if (ret.erro == 2) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    uemail.removeClass("sucesso").addClass("erro").focus();
                } else if (ret.erro == 15) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html("Erro[" + ret.erro + "]: " + ret.msg).show("fast");
                    uemail.removeClass("sucesso").addClass("erro").focus();
                    usenha.removeClass("sucesso").addClass("erro");
                }  else if( ret.erro == 9 ){
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
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


    var login = function(usuario, senha) {
        alertM = $("#mensagem");
        modalLogin = $("#modal_login");
        $.ajax({
            url: "../controller/user/login.php",
            method: "POST",
            dataType: 'JSON',
            data: {
                email: usuario,
                senha: senha
            },
            success: function(ret) {
                if (ret.erro == 0) {
                    alertM.removeClass("alert-danger").addClass("alert-success").html(ret.msg).show("fast");
                    cookie.setCookie("user_id", ret.usuario.id, 1);
                    cookie.setCookie("logado", true, 1);
                } else if (ret.erro == 2) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    uemail.removeClass("sucesso").addClass("erro").focus();
                } else {
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


    return {
        get: get,
        create: create,
        update: update,
        deleteUser:deleteUser
    };
};
