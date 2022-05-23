const Product = (function () {
    let modules = {};
    const DELETE = "GET";
    let path = '/thumbnail/';

    function callAjaxWithForm(url, method, data) {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: method,
            url: url,
            data: data,
            success: function () {
                location.reload();
            }
        });
    }

    function callAjaxWithFormData(url, method, data) {
        return $.ajax({

            url: url,
            method: method,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function () {
                location.reload();
            }
        });
    }

    modules.create = function () {
        $('.modal-title').text("Add New Record");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#formModal').modal('show');
        $('#formSave').trigger("reset");
        $('#img-thumbnail').remove();
        $('#id').val('');
    }

    modules.edit = function (product) {
        let data = product.data;
        $('.modal-title').text("Edit New Record");
        $('#action_button').val("Edit");
        $('#action').val("Edit");
        $('#formModal').modal('show');
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#price').val(data.price);
        $('#description').val(data.description);
        $('#category_id').val(data.categories.data[0].id);
        $('#store_image').html("<img src=" + (path + data.image) + " width='70' class='img-thumbnail' id='img-thumbnail' />");
        $('#store_image').append("<input type='hidden' name='hidden_image' value='" + (path + data.image) + "' />");
    }

    modules.delete = function (element) {
        let productId = $(element).data("id");
        let routeDestroy = $(element).data("route-destroy");
        callAjaxWithForm(routeDestroy, DELETE).done(function () {
            $("#product_id_" + productId).remove();
        });
    }

    modules.store = function (url, method, data) {
        callAjaxWithFormData(url, method, data).done(function () {
            let html = '';
            $('#user_table').prepend(html);
        })
    }

    modules.update = function (url, method, data) {
        callAjaxWithFormData(url, method, data).done(function (data) {
            let productId = '#product_id_' + data.data.id;
            let html = '';
            $(productId).replaceWith(html);
        })
    }
    return modules;
})();
