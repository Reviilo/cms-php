/**
 * Multiples imagenes
 */

 
$('#lightbox li').on('click', function (e) {
    // console.log(e);
    var datos = new FormData,
        src = e.target.src;
    datos.append('accion', 'prueba');
    datos.append('ruta', src);

    $.ajax({
        url: "views/ajax/gestorGaleria.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false
        // dataType: "json",
        // success: function (res) {
        //     console.log(res);
        // }
    });
});

$('#lightbox').on('dragover', function (e) {
    e.preventDefault();
    e.stopPropagation();
});

$('#lightbox').on('drop', function (e) {
    e.preventDefault();
    e.stopPropagation();
});

$('#lightbox').on('dragover', function (e) {

    e.preventDefault();
    e.stopPropagation();

    $('#lightbox').css({'background': 'url(views/images/pattern.jpg)'});
});

/**
 * Soltar las imagenes 
 */

$('#lightbox').on('drop', function (e) {

    $('#lightbox').css({'background': '#fff'});

    var archivo = e.originalEvent.dataTransfer.files,
        imgSize = [],
        imgType = [],
        datos = new FormData();

    // console.log('** e', e);
    // console.log('** archivo ', archivo);

    for( var i=0; i < archivo.length; i++) {
        img = archivo[i];
        imgSize.push(img.size);
        imgType.push(img.type);

        if ( imgSize[i] > 2500000 ) {
            if ( $(".alert").length > 0 ) {
                return;
            }
            $('.galeria').before('<div class="alert alert-warning"> El archivo excede el peso permitido, 2,5 MB </div>');
    
            setTimeout(function () {
                $(".alert").remove();
            }, 5000);
            
            return;
        }
    
        if ( imgType[i] !== "image/png" && imgType[i] !== "image/jpeg" && imgType[i] !== "image/jpg") {
            if ( $(".alert").length > 0 ) {
                return;
            }
    
            $('.galeria').before('<div class="alert alert-warning"> El archivo debe ser formato png o jpg </div>');
    
            setTimeout(function () {
                $(".alert").remove();
            }, 5000);
    
            return;
        }

        datos.append('img', img);

        $.ajax({
            url: "views/ajax/gestorGaleria.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                $('#lightbox').before('<img src="views/images/status.gif" id="status" class="status">');
            },
            success: function (res) {
    
                // console.log('** res', res);
                $('.status').remove();
    
                if ( Number(res) === 0 ) {
                    $('#arrastreImagenArticulo').before('<div class="alert alert-warning"> La imagen es inferior a 800 x 400 </div>');
    
                    setTimeout(function () {
                        $(".alert").remove();
                    }, 5000);
                    
                    return;
                    
                } else {
                    $('#lightbox').append('<li id="'+res.id+'" class="bloque"> <span class="fa fa-times eliminar-foto"></span> <a rel="grupo" href="'+res.ruta+'"> <img src="'+res.ruta+'" class="handleImg"> </a> </li>');
                }
            }
        });
    }

    
});

/**
 * Eliminar Foto
 */

$('.eliminar-foto').on('click', function () {
    var datos = new FormData(),
    id = $(this).parent().attr('id'),
    ruta = $(this).siblings().children().attr('src');

    $(this).parent().remove();

    datos.append('accion', 'eliminar');
    datos.append('id', id);
    datos.append('ruta', ruta);


    $.ajax({
        url: 'views/ajax/gestorGaleria.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        // success: function(res) {
        //     console.log(res);
        //     if (res === 'success') {
        //         swal({
        //             title: "OK!",
        //             text: "El articulo ha eliminado correctamente!",
        //             type: "success",
        //             timer: 2000
        //         });
        //     }
        // }
    });


});



/**
 * Funcion para ordenar las imagenes
 */

function sortableOn () {
    var almacenarOrdenId = [];
    var ordenItem = [];

    $('#lightbox').css({'cursor': 'move'});

    $('#lightbox').sortable({
        revert: true,
        connectWith: '.bloque',
        handle: '.handleImg',
        activate: function () {
            $('#lightbox span').hide();
        },
        stop: function (e) {

            for(var i=0; i < $('#lightbox li').length; i++) {
                almacenarOrdenId[i] = e.target.children[i].id;
                ordenItem[i] = i+1;

                var datos = new FormData();
                datos.append('accion', "ordenar");
                datos.append('id', almacenarOrdenId[i]);
                datos.append('orden', ordenItem[i]);

                $.ajax({
                    url: 'views/ajax/gestorGaleria.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    });
}

$('#lightbox span').on('mouseover', function () {
    $('#lightbox').css({'cursor': 'pointer'});
});

/**
 * Permitir arrastrar los elementos
 */

$('#lightbox').on("mouseover", function (e) {
    sortableOn();
});

$('#lightbox').on("mouseout", function (e) {

    $('#lightbox').css({'cursor': 'pointer'});
    $('#lightbox span').show();

});