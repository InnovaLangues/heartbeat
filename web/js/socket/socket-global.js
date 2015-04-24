socket.on('notification', function (data) {
    if (data.type == 'info') {
        toastr.info(data.message, data.title)
    }

    if (data.type == 'warning') {
        toastr.warning(data.message, data.title)
    }

    if (data.type == 'success') {
        toastr.success(data.message, data.title)
    }

    if (data.type == 'error') {
        toastr.error(data.message, data.title)
    }
});