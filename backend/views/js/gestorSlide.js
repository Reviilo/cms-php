/**
 * Ajustar el espacio de arrastre 
 */

if ( $('#columnasSlide').html() == 0 ) {
    $('#columnasSlide').css({"height": "100px"});
} else {
    $('#columnasSlide').css({"height": "auto"});
}

/**
 * Subir una imagen
 */

$('#columnasSlide').on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $('#columnasSlide').css({
        "background": "url(views/images/pattern.png)"
    });
});

/**
 * Ajustar el espacio de arrastre 
 */

$('#columnasSlide').on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $('#columnasSlide').css({
        "background": "#fff"
    });

    var archivo = e.originalEvent.dataTransfer.files;
    var img = archivo[0];
    var imgSize = Number(img.size);
    var imgType = String(img.type);

    if ( imgSize > 2500000 ) {
        if ( $(".alert").length > 0 ) {
            return;
        }
        $('#columnasSlide').before('<div class="alert alert-warning"> El archivo excede el peso permitido, 2,5 MB </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);
        
        return;
    }

    if ( imgType === "image/jpeg" || "image/jpg" || "image/png") {
        $(".alert").remove();
    } else {
        if ( $(".alert").length > 0 ) {
            return;
        }

        $('#columnasSlide').before('<div class="alert alert-warning"> El archivo debe ser formato png o jpg </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);

        return;
    }

    var datos = new FormData();
    datos.append("img", img);

    $.ajax({
        url: "views/ajax/gestorSlide.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function () {
            $('#columnasSlide').before('<img src="views/images/status.gif" id="status" class="status">');
        },
        success: function (res) {

            // console.log(res.ruta.slice(6));
            $('.status').remove();
            $('#columnasSlide').css({"height": "auto"});

            if ( res === "0" ) {
                $('#columnasSlide').before('<div class="alert alert-warning"> La imagen es inferior a 1600 x 600 </div>');
            } else {
                $('#columnasSlide').append('<li id="'+res.id+'" class="bloqueSlide"><span class="fa fa-times eliminar-slide"></span><img src="'+res.ruta+'" class="handleImg"></li>');
                $('#columnasSlide').css({"height": "auto"});
                $('#ordenarTextSlide').append('<li id="'+res.id+'"><span class="fa fa-pencil" style="background:blue"></span><img src="'+res.ruta+'" style="float:left; margin-bottom:10px" width="80%"><h1>'+res.titulo+'</h1><p>'+res.descripcion+'</p></li>')

                swal({
                    title: "OK!",
                    text: "La imagen se subio correctamente",
                    type: "success",
                    confirmButtonText: "Cerrar",
                    onClose: () => {
                        window.location = "slide";
                    }
                });
            }
        }
    });

});

/**
 * Eliminar una imagen
 */

$('.eliminar-slide').click(function () {
    var idSlide = $(this).parent().attr("id");
    var ruta = $(this).parent().children("img").attr("src");

    const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    });
      
    swalWithBootstrapButtons({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
            if (result.value) {
                swalWithBootstrapButtons(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success');

                    $(this).parent().remove();
                    $('#'+idSlide).remove();

                    var datos = new FormData();
                    datos.append("id", idSlide);
                    datos.append("ruta", ruta);

                    

                    $.ajax({
                        url: "views/ajax/gestorSlide.php",
                        method: "POST",
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            console.log(res);
                            if ( $('#columnasSlide').html().trim() == 0 ) {
                                $('#columnasSlide').css({"height": "100px"});
                            }
                        }
                    });
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error');
        }
    });

});