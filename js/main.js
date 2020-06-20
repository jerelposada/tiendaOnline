$(document).ready(function() {

    function load_cart() {

        var wrapper = $('#cart-wrapper'),
            action = 'get';
        //realizando la peticion ajax 
        $.ajax({
            url: 'app/ajax.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                action
            },
            beforeSend: function() {
                wrapper.waitMe();

            }
        }).done(function(res) {
            //esta se ejecuta cuando la conexon es exitosa
            if (res.status === 200) {
                wrapper.html(res.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'ocurrio un error!'
                })
                wrapper.html('intenta de nuevo por favor');
                return true;
            }
        }).fail(function(err) {
            // se ejecuta cuando no hay conexion o el archivo 
            //no se encuenta o hay fallos en php
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'ocurrio un error!'
            })
        }).always(function() {
            //este siempre se ejecuta alla o no conexion
            //console.log('ejecutando nunca')
            wrapper.waitMe('hide');
        });
        // wrapper.waitMe('');
    };

    load_cart();


    $('.btn-agregar').on('click', function(event) {
        event.preventDefault();
        var id = $(this).data('id'),
            cantidad = $(this).data('cantidad'),
            action = 'post';

        $.ajax({
            url: 'app/ajax.php',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data: {
                action,
                id,
                cantidad
            },
            beforeSend: function() {
                console.log('Agregando...');
            }

        }).done(function(res) {
            if (res.status === 201) {
                Swal.fire('carrito cargado');
                load_cart();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'ocurrio un error!'
                });
            }
        }).fail(function(err) {

        }).always(function() {

        });

    });

    $('body').on('click', '.btn-vaciar-carrito', borrarCarro);

    function borrarCarro(event) {

        var action = 'destroy';
        //  confirmacion;

        Swal.fire({
            title: 'estas seguro de borrar todo el carrito?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si borrar carro'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'app/ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        action
                    },
                }).done(function(res) {
                    if (res.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        load_cart();
                        return;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'ocurrio un error!'
                        });
                        return
                    }
                }).fail(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ocurrio un error e la conexion!'
                    });
                })
            }
        })






    }

    $('body').on('click', '.btn-borrar-producto', borrarElementoCarro);

    function borrarElementoCarro(event) {

        var action = 'borrarElemento',
            id = $(this).data('id');

        Swal.fire({
            title: 'estas seguro de borrar elemento del carrito?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si borrar carro'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'app/ajax.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        action,
                        id
                    },
                }).done(function(res) {
                    if (res.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        load_cart();
                        return;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'ocurrio un error!'
                        });
                        return
                    }
                }).fail(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'ocurrio un error e la conexion!'
                    });
                })
            }
        })


    }

    $('body').on('blur', '.btn-actualizarCarro', actualizarCarro);

    function actualizarCarro(event) {
        var input = $(this),
            cantidad = parseInt(input.val()),
            id = input.data('id'),
            action = 'put';
        if (cantidad) {

        }
        //validar si es numero
        // validar si es numero
        if (cantidad <= 0 || Math.floor(cantidad) !== cantidad || cantidad > 99) {
            cantidad = 1;
        }

        if (cantidad === parseInt(input.data('cantidad'))) {
            return false;
        }

        $.ajax({
            url: 'app/ajax.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                action,
                id,
                cantidad
            },
        }).done(function(res) {
            Swal.fire({
                icon: 'success',
                title: 'bien hecho',
                text: 'carito actualizar el carro'
            });
            load_cart();
            return;

        }).fail(function(err) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'ocurrio un error al actualizar el carro'
            });
        })

        console.log(cantidad);
    }
});