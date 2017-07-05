var utils = function() {

    function listaFiltros(page) {
        order = $(".select-ordenacao").val();
        limite = $(".select-quantidade").val();
        lista = $('input[name="lista"').val();
        if ($("input#dataHorario").val() != "0000-00-00" && $("input#dataHorario").length > 0) {

            data = $("input#dataHorario").val().split("/");
            if (data.length > 1) {
                data = data[1] + "/" + data[0] + "/" + data[2];
            } else {
                data = data[0];
            }
            post.lista(lista, page, order, limite, data);
        } else {
            post.lista(lista, page, order, limite);
        }
    }

    function getFileName() {
        /* this gets the full url,
         * (#) this removes the anchor at the end, if there is one
         * (?) this removes the query after the file name, if there is one
         * (/) this removes everything before the last slash in the path */

        var url = document.location.href;
        url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
        url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
        url = url.substring(url.lastIndexOf("/") + 1, url.length);
        return url;
    }





    return {
        filtraLista: listaFiltros,
        getFileName: getFileName
    }
}



function deletaComentario(elem) {

    $.ajax({
        url: "../../controller/comentario/delete.php",
        method: 'POST',
        dataType: 'JSON',
        data: {
            comentarioId: $(elem).data("cid")
        },
        success: function(ret) {
            if (ret.erro == 0) {
                row = ".comentario_" + $(elem).data("index");
                $(row).remove();
            } else {
                alert(ret.msg);
            }
        }
    });
}


function viewPost(elem, event) {
    if (typeof event != 'undefined') {
        event.preventDefault();
    }
    dataPost = {
        post: {
            postId: $(elem).data('id')
        }
    };
    $.ajax({
        url: '../controller/post/get.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            postId: $(elem).data('id')
        },
        success: function(ret, textStatus, jqXHR) {
            if (ret.erro == 0) {
                // Success so call function to process the form
                dataPost.post.path = ret.post.imagem;
                dataPost.post.descricao = ret.post.descricao;
                dataPost.post.criacao = ret.post.dataCriacao;
                dataPost.post.comentarios = ret.comentarios;
                dataPost.post.ext = ret.post.ext;
                dataPost.post.denuncias = ret.post.denuncias;
                dataPost.post.likes = ret.post.likes;
                dataPost.post.autor = ret.autor;
                modal.loadHtml("./views/modal/post_view.php", modal.postView, dataPost);
                //console.log(data);
            } else {
                modal.loadHtml("./views/modal/msg_retorno.php", modal.msg, {
                    'msg': ret.msg
                });
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
            alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
        }
    });

}



//MODULOS
var cookie = cookieController();
var user = userController();
var modal = modalController();
var post = postController();
var file = fileController();
var ferramentas = utils();
if (cookie.getCookie("user_id")) {
    cookie.setCookie("logado", true, 1);
} else {
    cookie.setCookie("logado", false, 1);
}


$(document).ready(function() {
    $("#editarUsuario").click(function(e) {
        e.preventDefault();
        modal.loadHtml("./views/modal/form_usuario.php", modal.usuario);
    });
    $("#criarUsuario").click(function(e) {
        e.preventDefault();
        modal.loadHtml("./views/modal/form_usuario.php", modal.usuario);
    });
    $("#criarPublicacao").click(function(e) {
        e.preventDefault();
        modal.loadHtml("./views/modal/form_publicacao.php", modal.postForm, {
            'url': 'create.php'
        });
    });
    $("#login").click(function(e) {
        e.preventDefault();
        modal.loadHtml("./views/modal/form_login.php", modal.login);
    });
    $("#logout").click(function(e) {
        e.preventDefault();
        modal.loadHtml("./views/modal/msg_retorno.php", modal.logout);
    });


    var page = 1;

    if (ferramentas.getFileName() != "manutencao.php") {
        ferramentas.filtraLista(page);


        $(".select-ordenacao, .select-quantidade").on("change", function() {
            page = 1;
            ferramentas.filtraLista(page);
        });

        $('#datetimepicker1').datetimepicker({
            language: 'pt-BR'
        }).on('changeDate', function(e) {
            $("input#dataHorario").val(e.date.toString());
            page = 1;
            ferramentas.filtraLista(page);
        });


        $("#pesquisar").click(function() {
            if ($("#campoBusca").val().length <= 0) {
                $("#campoBusca").addClass("erro").attr("placeholder", "Não esqueça desse campo!!").focus();
            } else {
                page = 1;
                $("#campoBusca").removeClass("erro").addClass("sucesso");
                ferramentas.filtraLista(page);
            }
        });


        $("#meusPosts").click(function(e) {
            e.preventDefault();
            $(this).hide();
            $("input[name='lista']").val("user");
            $("#listaDefault").show();
            $("#lista-publicacao-cabecalho .titulo h4").html("Minhas Publicações");
            page = 1;
            ferramentas.filtraLista(page);
        });

        $("#listaDefault").click(function(e) {
            e.preventDefault();
            $(this).hide();
            $("#lista-publicacao-cabecalho .titulo h4").html("Publicações");
            $("input[name='lista']").val("default");
            $("#meusPosts").show();
            page = 1;
            ferramentas.filtraLista(page);
        });




        //infinite scroll
        $(window).scroll(function() {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                page++;
                ferramentas.filtraLista(page);
            }
        });
    }

    //loading
    $(document).on("ajaxSend", function() {
        v = 1;
        spinner = '<div class="spinner chide"><img class="chide" src="../public/files/default/gears.svg?v=' + v + '" /></div>';
        $('body').append(spinner);
        setTimeout(function() {
            $('.spinner').removeClass('chide');
            setTimeout(function() {
                $('.spinner img').removeClass('chide');
            }, 100)
        }, 300);

    }).on("ajaxComplete", function() {
        setTimeout(function() {
            $('.spinner').remove();
        }, 600);
    });

});
