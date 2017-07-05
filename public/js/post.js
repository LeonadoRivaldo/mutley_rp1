Number.prototype.padLeft = function(base, chr) {
    var len = (String(base || 10).length - String(this).length) + 1;
    return len > 0 ? new Array(len).join(chr || '0') + this : this;
}



//modulo de post
var postController = function() {
    //envia form do post
    var submitForm = function(event, data) {
        desc = $('textarea#descricao');
        alertM = $("#mensagem");
        phpFile = $('form#postForm').data('url');
        path = '../../controller/post/' + phpFile;

        dados = {
            postId: data.postId,
            imagem: data.path,
            descricao: desc.val(),
            ext: data.ext
        };

        if (typeof data.uid != 'undefined') {
            dados.uid = data.uid;
        }


        $.ajax({
            url: path,
            type: 'POST',
            data: dados,
            cache: false,
            dataType: 'json',
            success: function(ret, textStatus, jqXHR) {
                if (ret.erro == 0) {
                    alertM.removeClass("alert-danger").addClass("alert-success").html(ret.msg).show("fast");
                    cookie.setCookie("postCriado", true, 0.00101);
                    cookie.eraseCookie("postEditing");
                } else if (ret.erro == 10) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                } else if (ret.erro == 15) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html("Erro[" + ret.erro + "]: " + ret.msg).show("fast");
                } else if (ret.erro == 9) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
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

    var getPostById = function(id, modal) {
        //TODO
    }


    var lista = function(lista, page, ordem, limite, data) {
        dados = {
            page: page,
            order: order,
            limite: limite,
            lista: lista
        };
        if (typeof data != 'undefined') {
            dados.data = data;
        }

        if( $("#campoBusca").val().length > 0 ){
            dados.desc = $("#campoBusca").val();
        }


        $.ajax({
            url: '../controller/post/list.php',
            method: 'POST',
            dataType: 'JSON',
            data: dados,
            success: function(ret) {
                if (ret.erro == 0) {
                    if (page == 1) {
                        $('#lista-publicacao-corpo .row').html("");
                    }
                    ret.posts.forEach(function(element, index, array) {
                        data = {
                            post: {
                                path: element.imagem,
                                id: element.id,
                                ext: element.ext,
                                likes: element.likes,
                                dataCriacao: element.dataCriacao
                            }
                        };
                        $('#lista-publicacao-corpo .row').append($("<div class='post'></div>").load('../../views/post.php', data));
                    });
                } else if (ret.erro = 16) {
                    if ($("#listaerro").length <= 0) {
                        $("#lista-publicacao-corpo .row").append('<div class="col-xs-12"><div id="listaerro" class="alert alert-danger" role="alert">' + ret.msg + '</div></div>');
                        $("#listaerro").show();
                    }
                } else {
                    $('#lista-publicacao-corpo .row').html("");
                    $("#lista-publicacao-corpo .row").append('<div id="listaerro" class="alert alert-danger" role="alert">' + ret.msg + '</div>');
                    $("#listaerro").show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
            }
        });
    }



    var addComentario = function(comentario, postId, autor, comentariosContainer) {
        alertM = $("#mensagem");
        var modalPostView = $("#modal_post_view");
        dados = {
            texto: comentario,
            postId: postId,
            userId: autor.id,
            userName: autor.nome
        };

        $.ajax({
            url: '../controller/comentario/create.php',
            method: 'POST',
            dataType: 'JSON',
            data: dados,
            success: function(ret) {
                if (ret.erro == 0) {
                    alertM.removeClass("alert-danger").addClass("alert-success").html(ret.msg).show("fast");
                    if (typeof comentariosContainer == "undefined") {
                        setTimeout(function() {
                            $("#modal_post_view").modal("hide");
                            viewPost($("input[name='postId']"), event)
                        }, 1000);
                    } else {
                        index = comentariosContainer.children().length;
                        dados.index = index;
                        html = '<div class="comentario_0"></div>';
                        dados.load = true;
                        d = new Date, dformat = [(d.getMonth() + 1).padLeft(),
                                    d.getDate().padLeft(),
                                    d.getFullYear()
                                ].join('/') +
                                ' ' + [d.getHours().padLeft(),
                                    d.getMinutes().padLeft(),
                                    d.getSeconds().padLeft()
                                ].join(':');
                        dados.dataCriacao = dformat;
                        dados.autorId = $("input[name='autorId']").val();
                        dados.comentarioId = ret.comentarioId; 
                        console.log(dados);
                        comentariosContainer.append($(html).load('../../views/comentario.php', dados));
                    }
                } else {
                    alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
            }
        });


    };

    return {
        save: submitForm,
        get: getPostById,
        lista: lista,
        comentario: addComentario
    }
}

var post = postController();
var files;

var fileController = function() {
    //preparing files
    var prepareUpload = function(event) {
        files = event.target.files;
    }

    //uploading files
    var uploadFiles = function(event) {
        alertM = $("#mensagem");
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening


        if (cookie.getCookie("postEditing") && typeof files == 'undefined') {
            data = {
                postId: $('input#postId').val(),
                descricao: $("textarea#descricao").val(),
                ext: $('input#ext').val(),
                path: $('input#path').val(),
                uid: $("input#autorId").val()
            };
            console.log(data);
            post.save(event, data);
            return;
        }



        if (typeof files != 'undefined') {
            if (files.length != 0) {
                if (files[0].size > 2000000) {
                    alertM.removeClass("alert-success").addClass("alert-danger").html("Selecione uma imagem menor que 2mb.").show("fast");
                    $('.spinner').remove();
                    return;
                } else {
                    alertM.hide();
                }
            }

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value) {
                data.append(key, value);
            });
            url = '../../controller/post/upload.php?files';
            if (cookie.getCookie("postEditing")) {
                id = $("input#postId").val();
                url = '../../controller/post/upload.php?files=' + files + '&id=' + id
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(ret, textStatus, jqXHR) {
                    if (ret.erro == 0) {
                        if (cookie.getCookie("postEditing")) {
                            ret.uid = $("input#autorId").val();
                        }
                        // Success so call function to process the form
                        post.save(event, ret);
                        //console.log(data);
                    } else if (ret.erro == 9) {
                        alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alertM.removeClass("alert-success").addClass("alert-danger").html(ret.msg).show("fast");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    // STOP LOADING SPINNER
                    alert("Desculpe mas alguma coisa errada aconteceu, contate o suporte pelo email: suporte@sistemamutley.com.br");
                }
            });
        } else {
            alertM.removeClass("alert-success").addClass("alert-danger").html("Nem uma imagem foi anexada!").show("fast");
        }
    }
    return {
        upload: uploadFiles,
        prepare: prepareUpload
    }

}
