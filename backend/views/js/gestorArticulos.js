/**
 * Boton Agregar Articulo
 */

 $('.btn-agregar').on('click', function () {
    $('#agregarArtículo').toggle(400);
 });

 $('#subirFoto').on('change', function () {
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
            $('#columnasSlide').css({"height": "auto"});

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