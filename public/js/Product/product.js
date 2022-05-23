$(function () {
    $(".js-modal-create").click(function (event) {
        event.preventDefault();
        $("#myModal").modal('show');
        $("#form-create")[0].reset();
    })
    $(".js-modal-update").click(function (event) {
        event.preventDefault();
        let url = $(this).data('route-edit');
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            success: function (response) {
                $('#name').val(response.productEdit.name);
                $('#price').val(response.productEdit.price);
                $('#description').val(response.productEdit.description);
                $('#id').val(response.productEdit.id);
            }
        })
        $("#myModalUpdate").modal('show');
        $("#form-update")[0].reset();
    });
    $(".js-modal-delete").click(function (event) {
        event.preventDefault();
        $("#myModalDelete").modal('show');
        let url = $(this).data('route');
        $('.js-btn-delete').click(function (e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                method: "POST",
                success: function () {
                    location.reload();
                }
            })
                .done(function (results) {
                    $("#myModal").modal('hide');
                    $("#form-create")[0].reset();
                })
                .fail(function (data) {
                    var errors = data.responseJSON;
                    $.each(errors.errors, function (i, val) {
                        $domForm.find('input[name=' + i + ']').siblings('.error-form').text(val[0]);
                    });
                });
        });
    })
})
$(".close").click(function (event) {
    event.preventDefault();
    $("#myModal").modal('hide');
    $("#myModalUpdate").modal('hide');
})
$("#xx").click(function (event) {
    event.preventDefault();
    $("#myModalDelete").modal('hide');
})
$('.js-btn-create').click(function (e) {
    e.preventDefault();
    let url = $("#form-create").data('route');
    var data = new FormData(document.getElementById("form-create"));
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
    })
        .done(function (results) {
            $("#myModal").modal('hide');
            $("#form-create")[0].reset();
            location.reload();
        })
});
$('.js-btn-update').click(function (e) {
    e.preventDefault();
    let $this = $(this);
    let $domForm = $this.closest('form');
    let url = $('#form-update').data('route-update');
    var data = new FormData(document.getElementById("form-update"));
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
    })
        .done(function (results) {
            $("#myModalUpdate").modal('hide');
            $("#form-update")[0].reset();
            location.reload();
        })
});
