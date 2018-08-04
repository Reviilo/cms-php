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

$('#columnasSlide').on("drop.ar", function (e) {
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
    console.log(imgType !== "image/png");
    if ( imgType !== "image/png" && imgType !== "image/jpeg" && imgType !== "image/jpg") {
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

            console.log(res);
            $('.status').remove();
            $('#columnasSlide').css({"height": "auto"});

            if ( Number(res) === 0 ) {
                $('#columnasSlide').before('<div class="alert alert-warning"> La imagen es inferior a 1600 x 600 </div>');

                setTimeout(function () {
                    $(".alert").remove();
                }, 5000);
                
                return;
                
            } else {
                $('#columnasSlide').append('<li id="'+res.id+'" class="bloqueSlide"><span class="fa fa-times eliminar-slide"></span><img src="'+res.ruta+'" class="handleImg"></li>');
                $('#columnasSlide').css({"height": "auto"});
                $('#ordenarTextSlide').append('<li id="'+res.id+'"><span class="fa fa-pencil editar-slide" style="background:blue"></span><img src="'+res.ruta+'" style="float:left; margin-bottom:10px" width="80%"><h1>'+res.titulo+'</h1><p>'+res.descripcion+'</p></li>')

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

$('.eliminar-slide').on('click', function () {
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
                    datos.append("actividad", "eliminar");
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

/**
 * Editar una imagen del slide
 */

$('.editar-slide').on('click', function() {
    var id = $(this).parent().attr('id'),
        ruta = $(this).parent().children("img").attr("src"),
        titulo = $(this).parent().children("h1").html(),
        descripcion = $(this).parent().children("p").html();
    
    $(this).parent().html('<img src="'+ruta+'" class="img-thumbnail"> <input type="text" class="form-control" placeholder="Título" value="'+titulo+'" /> <textarea row="5" class="form-control" placeholder="Descripción">'+descripcion+'</textarea> <button class="btn btn-info pull-right guardar" style="margin:10px">Guardar</button>');

    /** Guardar la edicion de la imagen del slide */

    $('.guardar').on('click', function () {
        var id = $(this).parent().attr('id'),
            ruta = $(this).parent().children("img").attr("src"),
            titulo = $(this).parent().children("input").val(),
            descripcion = $(this).parent().children("textarea").val(),
            datos = new FormData();

            datos.append("actividad", "actualizar");
            datos.append("id", id);
            datos.append("ruta", ruta);
            datos.append("titulo", titulo);
            datos.append("descripcion", descripcion);

            $.ajax({
                url: "views/ajax/gestorSlide.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    swal({
                        title: "OK!",
                        text: "La imagen se actualizo correctamente",
                        type: "success",
                        timer: 2000,
                        onClose: () => {
                            window.location = "slide";
                        }
                    });
                }
            });

        
    });
    
});

/**
 * Editar una imagen del slide
 */

function sortableOn () {
    var almacenarOrdenId = [];
    var ordenItem = [];

    $('#columnasSlide').css({'cursor': 'move'});
    $('#columnasSlide span').hide();

    $('#columnasSlide').sortable({
        revert: true,
        connectWith: '.bloqueSlide',
        handle: '.handleImg',
        stop: function (e) {
            for(var i=0; i < $('#columnasSlide li').length; i++) {
                almacenarOrdenId[i] = e.target.children[i].id;
                ordenItem[i] = i+1;
                console.log('** almacenarOrdenId[i] **', almacenarOrdenId[i]);
                console.log('** ordenItem[i] **', ordenItem[i]);

                var datos = new FormData();
                datos.append('actividad', "ordenar");
                datos.append('id', almacenarOrdenId[i]);
                datos.append('orden', ordenItem[i]);

                $.ajax({
                    url: 'views/ajax/gestorSlide.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        console.log(res);
                    }
                });
            }
        }
    });
}

/**
 * Permitir arrastrar los elementos
 */

$('#columnasSlide').on("mouseover", function (e) {
    console.log('** mouseover **', e);
    sortableOn();
});

$('#columnasSlide').on("mouseout", function (e) {
    console.log('** mouseout **', e);

    $('#columnasSlide').css({'cursor': 'pointer'});
    $('#columnasSlide span').show();

});