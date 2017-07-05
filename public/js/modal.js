//MODAL CONTROLLER
var modalController = function() {
    //carrega o html do modal
    var loadModal = function(url, functionToCall, data) {
        if (typeof data != 'undefined') {
            $("#modal-container").load(url, { "data": data }, functionToCall);
        } else {
            $("#modal-container").load(url, functionToCall);
        }
    }
        //para limpar o container
        var clearContentModal = function() {
            $("#modal-container").html("");
        }
        //função de controle do modal de usuario
        var modalUsuarioController = function() {
            var modalUser = $("#modal_usuario");
        //modal user controller
        //evento antes do modal aparecer na tela
        modalUser.on("show.bs.modal", function(event) {
            if ($("#editarUsuario").length >= 1) {
                var button = $("#editarUsuario");
            } else {
                var button = $("#criarUsuario");
            }
            var logado = button.data("logado");
            if (logado) {
                user.get();
                modalUser.find("h4#modal_usuario_title").html("Editar usuario")
                modalUser.find("button#salvar").addClass("atualiza-usuario").html("<i class='fa fa-save'></i> Atualizar");
            } else {
                modalUser.find("h4#modal_usuario_title").html("Criar usuario");
                modalUser.find("button#salvar").addClass("salvar-usuario").html("<i class='fa fa-save'></i> Salvar");
            }
        }).on('hidden.bs.modal', function(e) {
            if (cookie.getCookie("userAlterado")) {
                location.reload();
            }
        });

        setTimeout(function() {
            $("button#salvar.atualiza-usuario").click(function(e) {
                e.preventDefault();
                user.update();
            });
            $("button#salvar.salvar-usuario").click(function(e) {
                e.preventDefault();
                user.create();
            });
            $("button#deleteUsuario").click(function(e) {
                e.preventDefault();
                if( confirm("ANTEÇÃO: ESTA AÇÃO NÃO PODERÁ SER REVERTIDA, SUA CONTA SERÁ EXCLUÍDA PERMANENTEMENTE!") ){
                    user.deleteUser();
                }
            });
            
        }, 500);

        //mostra o modal
        modalUser.modal("toggle");
    }

    //função de controle do modal de posts
    var modalPostFormController = function(event, d, e) {
        var modalPost = $("#modal_post");
        //modal post controller
        //evento antes do modal aparecer na tela
        modalPost.on("show.bs.modal", function(event) {
            var caller = $(event.relatedTarget);
            $('input[type=file]#imagem').on('change', file.prepare);
            $('form#postForm').on('submit', file.upload);
        }).on('hidden.bs.modal', function(e) {
            if (cookie.getCookie("postCriado")) {
                location.reload();
            }
        });
        //mostra o modal
        modalPost.modal("toggle");
    };
    //função de controle do modal de login
    var modalPostViewController = function(event) {
        var modalPostView = $("#modal_post_view");
        //modal post controller
        modalPostView.on("show.bs.modal", function(event) {
            // Button that triggered the modal
            var modal = $(this);
            var postId = modal.find('input[name="postId"]').val();
        }).on('hidden.bs.modal', function(e) {});
        //mostra o modal
        modalPostView.modal("toggle");
    };
    //função de controle do modal de login
    var modalLoginController = function() {
        var modalLogin = $("#modal_login");
        //modal post controller
        modalLogin.on("show.bs.modal", function(event) {
            var caller = $(event.relatedTarget);
        });
        modalLogin.on('hidden.bs.modal', function(e) {
            cookieExist = cookie.getCookie("logado");
            if (cookieExist == "true") {
                location.reload();
            }

        });
        //mostra o modal
        modalLogin.modal("toggle");
    };
    //funçao de logout
    var logout = function() {
        var modalmsg = $("#modal_msg");
        $.ajax({
            url: '/controller/user/logout.php',
            method: 'GET',
            dataType: 'JSON',
            success: function(ret) {
                $("h5#msg").html(ret.msg);
                cookie.eraseCookie("PHPSESSID");
                cookie.eraseCookie("user_id");
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // Handle errors here
               console.log('ERRORS: ' + textStatus);
               alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
           }
       });
        //evento antes do modal aparecer na tela
        modalmsg.on("show.bs.modal", function(event) {
            var caller = $(event.relatedTarget);
        });
        modalmsg.on('hidden.bs.modal', function(e) {
            location.reload();
        });
        //mostra o modal
        modalmsg.modal("toggle");
    };

    //funçao de logout
    var msg = function() {
        var modalmsg = $("#modal_msg");
        //evento antes do modal aparecer na tela
        modalmsg.on("show.bs.modal", function(event) {
            var caller = $(event.relatedTarget);
        });
        modalmsg.on('hidden.bs.modal', function(e) {
           location.reload();
       });
        //mostra o modal
        modalmsg.modal("toggle");
    };




    //objeto de retorno
    return {
        usuario: modalUsuarioController,
        loadHtml: loadModal,
        postForm: modalPostFormController,
        postView: modalPostViewController,
        login: modalLoginController,
        logout: logout,
        clear: clearContentModal,
        msg:msg
    };
};
