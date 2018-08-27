/**
 * Subir Videos
 */

$('#video').on('change', function () {
    var video = this.files[0],
        videoSize = video.size,
        videoType = video.type,
        datos = new FormData();

    if( parseInt(videoSize) > (50 * 1000000) ) {

        console.log('video size', videoSize);
        
        if ( $(".alert").length > 0 ) {
            return;
        }
        $('#galeriaVideo').before('<div class="alert alert-warning"> El archivo excede el peso permitido, 50 MB </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);

        return;
    }

    if ( videoType !== 'video/mp4') {
        if ( $(".alert").length > 0 ) {
            return;
        }
        $('#galeriaVideo').before('<div class="alert alert-warning"> El archivo debe ser de tipo mp4 </div>');

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);

        return;
    }
    
    datos.append("video", video);

    $.ajax({
        url: "views/ajax/gestorVideos.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        beforeSend: function () {
            $('#galeriaVideo').before('<img src="views/images/status.gif" id="status" class="status">');
        },
        success: function (res) {

            $('.status').remove();

            console.log(res);
            $('#galeriaVideo').append('<li id="'+res.id+'" class="bloque"> <span class="fa fa-times eliminar"></span> <video controls class="handle-video"> <source src="'+res.ruta+'" type="video/mp4"> </video><li>');

        }
    });
});

/**
 * Eliminar video
 */

$('.eliminar').on('click', function () {
    var datos = new FormData(),
    id = $(this).parent().attr('id'),
    ruta = $(this).parent().find('source').attr('src');

    $(this).parent().remove();

    datos.append('accion', 'eliminar');
    datos.append('id', id);
    datos.append('ruta', ruta);


    $.ajax({
        url: 'views/ajax/gestorVideos.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log('res', res);
        }
    });


});

/**
 * Funcion para ordenar las imagenes
 */

function sortableOn () {

    $('#galeriaVideo').css({'cursor': 'move'});

    $('#galeriaVideo').sortable({
        revert: true,
        connectWith: '.bloque',
        handle: '.handle-video',
        activate: function () {
            $('#galeriaVideo span').hide();
        },
        stop: function (e) {

            for(var i=0; i < $('#galeriaVideo li').length; i++) {

                var datos = new FormData();
                datos.append('accion', "ordenar");
                datos.append('id', e.target.children[i].id);
                datos.append('orden', i+1);

                $.ajax({
                    url: 'views/ajax/gestorVideos.php',
                    method: 'POST',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
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

$('#galeriaVideo').on("mouseover", function (e) {
    $('#galeriaVideo').css({'cursor': 'move'});
    sortableOn();
});

$('#galeriaVideo').on("mouseout", function (e) {

    $('#galeriaVideo').css({'cursor': 'pointer'});
    $('#galeriaVideo span').show();

});