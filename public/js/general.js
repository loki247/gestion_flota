function notificacionToast(tipo, mensaje) {
    switch (tipo) {
        case 1:
            swal.fire({
                toast: true,
                type: 'success',
                title: '<h4>' + mensaje + '</h4>',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            break;
        case 2:
            swal.fire({
                toast: true,
                type: 'error',
                title: '<h4>' + mensaje + '</h4>',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            break;
    }
}

function block() {
    $.blockUI({
        message: 'Espere un momento...',
        baseZ: 5000,
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });
}

function unblock() {
    $.unblockUI();
}