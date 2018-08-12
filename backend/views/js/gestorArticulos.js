/**
 * Boton Agregar Articulo
 */

 $('.btn-agregar').on('click', function () {
    $('#agregarArtículo').toggle(400);
 });

 $('#subirFoto').on('change', function subirImagen() {
    var img = this.files[0],
        imgSize = img.size,
        imgType = img.type,
        datos = new FormData();
    
    if ($('#imagenArticulo').children().length > 0) {
        $('#imagenArticulo').children().remove();
    }

    if ( imgSize > 2500000 ) {
        if ( $(".alert").length > 0 ) {
            return;
        }
        $('#arrastreImagenArticulo').before('<div class="alert alert-warning"> El archivo excede el peso permitido, 2,5 MB </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);
        
        return;
    }

    if ( imgType !== "image/png" && imgType !== "image/jpeg" && imgType !== "image/jpg") {
        if ( $(".alert").length > 0 ) {
            return;
        }

        $('#arrastreImagenArticulo').before('<div class="alert alert-warning"> El archivo debe ser formato png o jpg </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);

        return;
    }

    datos.append("img", img);

    $.ajax({
        url: "views/ajax/gestorArticulos.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#arrastreImagenArticulo').before('<img src="views/images/status.gif" id="status" class="status">');
        },
        success: function (res) {

            console.log(res);
            $('.status').remove();

            if ( Number(res) === 0 ) {
                $('#arrastreImagenArticulo').before('<div class="alert alert-warning"> La imagen es inferior a 800 x 400 </div>');

                setTimeout(function () {
                    $(".alert").remove();
                }, 5000);
                
                return;
                
            } else {
                $('#imagenArticulo').append('<img src="'+res+'" class="img-thumbnail">');
            }
        }
    });
});


/**
 * Eliminar una imagen
 */

// $('.eliminar-articulo').on('click', function () {
//     var id = $(this).parents('li').attr("id");
//     var ruta = $(this).parents('li').children("img").attr("src");

//     const swalWithBootstrapButtons = swal.mixin({
//         confirmButtonClass: 'btn btn-success',
//         cancelButtonClass: 'btn btn-danger',
//         buttonsStyling: false,
//     });
      
//     swalWithBootstrapButtons({
//         title: 'Esta seguro?',
//         text: "Usted no puede devolver el cambio!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Si, eliminar!',
//         cancelButtonText: 'No, cancelar!',
//         reverseButtons: true
//     }).then((result) => {
//         if (result.value) {
//             swalWithBootstrapButtons(
//                 'Eliminado!',
//                 'Su archivo ha sido eliminado.',
//                 'success');

//             $(this).parents('li').siblings()[0].remove();
//             $(this).parents('li').remove();

//             var datos = new FormData();
//             datos.append("actividad", "eliminar");
//             datos.append("id", id);
//             datos.append("ruta", ruta);

//             $.ajax({
//                 url: "views/ajax/gestorArticulos.php",
//                 method: "POST",
//                 data: datos,
//                 cache: false,
//                 contentType: false,
//                 processData: false,
//                 success: function (res) {
//                     console.log(res);
//                 }
//             });
//         } else if (result.dismiss === swal.DismissReason.cancel) {
//             swalWithBootstrapButtons(
//                 'Cancelled',
//                 'Your imaginary file is safe :)',
//                 'error');
//         }
//     });

// });


/**
 * Editar articulo
 */

 $('.editar-articulo').on('click', function () {
        var id = $(this).parents('li').attr("id"),
            ruta = $(this).parents('li').children("img").attr("src"),
            titulo = $(this).parents('li').children('h1').html(),
            intro = $(this).parents('li').children('p').html(),
            contenido = $(this).parents('li').children('.contenido').val();
        
        $('#'+id).html('<form method="post" enctype="multipart/form-data"><input type="hidden" name="accion" value="editar" /><input type="hidden" name="id" value="'+id+'" /> <input type="hidden" name="imagen" value="'+ruta+'" /> <span> <input type="submit" class="btn btn-primary pull-right" value="Guardar" /></span> <div id="editarImagen"><span class="fa fa-times cambiar-imagen "></span><img src="'+ruta+'" class="img-thumbnail"></div> <input class="titulo" name="titulo" type="text" value="'+titulo+'"> <textarea name="intro" cols="30" rows="5">'+intro+'</textarea> <textarea name="contenido" id="editarContenido" cols="30" rows="10">'+contenido+'</textarea> <hr></form>');
        

        $('.cambiar-imagen').on('click', function () {
            console.log('entra');

            // $(this).hide();
            // $('.subir-foto').show();

            // $(this).parent().children('img').remove();

            $(this).parent().html('<input name="imagen" type="file" class="subir-imagen" required />');

            $('.subir-imagen').on('change', function subirImagen() {
                var img = this.files[0],
                    imgSize = img.size,
                    imgType = img.type,
                    datos = new FormData();
                
                if ($('#editarImagen').children('img').length > 0) {
                    $('#editarImagen').children('img').remove();
                }
            
                if ( imgSize > 2500000 ) {
                    if ( $(".alert").length > 0 ) {
                        return;
                    }
                    $('#editarImagen').before('<div class="alert alert-warning"> El archivo excede el peso permitido, 2,5 MB </div>');
            
                    setTimeout(function () {
                        $(".alert").remove();
                    }, 5000);
                    
                    return;
                }
            
                if ( imgType !== "image/png" && imgType !== "image/jpeg" && imgType !== "image/jpg") {
                    if ( $(".alert").length > 0 ) {
                        return;
                    }
            
                    $('#editarImagen').before('<div class="alert alert-warning"> El archivo debe ser formato png o jpg </div>');
            
                    setTimeout(function () {
                        $(".alert").remove();
                    }, 5000);
            
                    return;
                }
            
                datos.append("img", img);
            
                $.ajax({
                    url: "views/ajax/gestorArticulos.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#editarImagen').before('<img src="views/images/status.gif" id="status" class="status">');
                    },
                    success: function (res) {
            
                        console.log(res);
                        $('.status').remove();
            
                        if ( Number(res) === 0 ) {
                            $('#editarImagen').before('<div class="alert alert-warning"> La imagen es inferior a 800 x 400 </div>');
            
                            setTimeout(function () {
                                $(".alert").remove();
                            }, 5000);
                            
                            return;
                            
                        } else {
                            $('#editarImagen').append('<img src="'+res+'" class="img-thumbnail">');
                        }
                    }
                });
            });
       
        });

 });

 /**
 * Ordenar los articulos
 */

 $('.ordenar-articulos').on('click', function () {
    var almacenarOrdenId = [],
        ordenItem = [],
        items = $('#editarArticulo li').length;

    $('.ordenar-articulos').hide();
    $('.guardar-orden').show();

    $('#editarArticulo').css({'cursor': 'move'});
    $('#editarArticulo span i').hide();
    $('#editarArticulo button').hide();
    $('#editarArticulo img').hide();
    $('#editarArticulo p').hide();
    $('#editarArticulo hr').hide();
    $('#editarArticulo div').hide();
    $('#editarArticulo h1').css({
        "font-size": "14px",
        "position": "absolute",
        "padding": "12px",
        "top": "0"
    });

    $('#editarArticulo span').append('<i class="glyphicon glyphicon-move" style="padding: 8px;">');

    $("body, html").animate({
        scrollTop: $("body").offset().top
    }, 500);

    $('#editarArticulo').sortable({
        revert: true,
        connectWidth: ".bloque-articulo",
        handle: ".handle-article",
        stop: function (e) {
            
            for (var i=0; i < items; i++) {
                almacenarOrdenId[i] = e.target.children[i].id;
                ordenItem[i] = i+1;
            }
        }
    });

    

    $('.guardar-orden').on('click', function () {
        $('.ordenar-articulos').show();
        $('.guardar-orden').hide ();

        for (var i=0; i < items; i++) {
            
            var datos = new FormData();
            datos.append("accion", "ordenar");
            datos.append("id", almacenarOrdenId[i]);
            datos.append("orden", ordenItem[i]);

            $.ajax({
                url: "views/ajax/gestorArticulos.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    swal({
                        title: "OK!",
                        text: "los articulos se han organizado correctamente!",
                        type: "success",
                        timer: 2000,
                        onClose: () => {
                            window.location = "articulos";
                        }
                    });
                }
            });

        }
    });
 });

 