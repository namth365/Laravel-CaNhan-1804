$(document).ready(function () {
    let btnCreate = $('.create_product');
    let urlUpdate = '';
    let urlStore = '';
    const POST = "POST";

    btnCreate.on('click', function () {
        urlStore = $(this).data("route-store");
        Product.create();
    })

    $(document).on('click', '.edit-product', function () {
        let routeEdit = $(this).data("route-edit");
        urlUpdate = $(this).data("route-update");
        $.get(routeEdit, function (data) {
            Product.edit(data);
        })
    })

    $(document).on('click', '.delete-product', function () {
        Product.delete($(this));
    })

    $('#formSave').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == 'Add') {
            let data = new FormData(this);
            Product.store(urlStore, POST, data);
        }

        if ($('#action').val() == "Edit") {
            let data = new FormData(this);
            Product.update(urlUpdate, POST, data);
        }
    })
});
