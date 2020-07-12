require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).on('click', '.delete_confirmation', function (e) {
    const apiUrl = $(this).data('api-url');


    Swal.fire({
        title: 'Are you sure?',
        text: 'You wont\' be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:
            '<i class="far fa-thumbs-up"></i> Yes, delete it!',
        showCloseButton: true,
    }).then(result => {
        if (result.value) {

            $.post(apiUrl, {'_method': 'delete'})
                .done(response => {
                    Swal.fire(
                        'Deleted',
                        response.message,
                        'success'
                    );

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                })
                .fail((error) => {
                    const {message} = error.responseJSON;

                    Swal.fire(
                        'Oops...!',
                        message,
                        'error'
                    );
                }).always(xhr => {

            })

        }
    });
});

function deleteApi() {

}
