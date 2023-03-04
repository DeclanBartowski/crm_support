$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
if (typeof columns != "undefined" && typeof order != 'undefined') {
    $("#data_list").DataTable({
        responsive: !0,
        searchDelay: 500,
        processing: !0,
        ajax: "?getList=Y",
        language: {
            "sProcessing": "Подождите...",
            "sLengthMenu": "Показать _MENU_ записей",
            "sZeroRecords": "Записи отсутствуют.",
            "sInfo": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "sInfoEmpty": "Записи с 0 до 0 из 0 записей",
            "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
            "sInfoPostFix": "",
            "sSearch": "Поиск:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Первая",
                "sPrevious": '<i class="la la-angle-left"></i>',
                "sNext": '<i class="la la-angle-right"></i>',
                "sLast": "Последняя"
            },
            "oAria": {
                "sSortAscending": ": активировать для сортировки столбца по возрастанию",
                "sSortDescending": ": активировать для сортировки столбцов по убыванию"
            }
        },
        columns: columns,
    })
}
$(document).on('click', '[data-ajax="true"]', function (e) {
    e.preventDefault();
    let $this = $(this),
        data = {_token: $('meta[name="csrf-token"]').attr('content')};
    $.ajax({
        url: $(this).attr('href'),
        type: 'DELETE',
        data: data,
        success: function () {
            if ($this.data('back')) {
                location.href = $this.data('back')
            } else {
                location.reload()
            }

        }
    });
    return false
})

function initWidgets() {
    $(".summernote").summernote({height: 150})
    $(".m-form select").select2({
        language: "ru",
        placeholder: "Выберите значение",
        allowClear: true
    });
    $("#data_list_wrapper select").select2({
        language: "ru",
        placeholder: "Выберите значение"
    });
}

$.each($(".repeater_block"), function (index, value) {
    var $this = $(this);
    $this.repeater({
        initEmpty: false,
        defaultValues: {"text-input": ""},
        isFirstItemUndeletable: true,
        show: function () {
            if ($this.data('max-items')) {
                if ($(this).closest('.repeater_block').find('[data-repeater-item]').length >= $this.data('max-items')) {
                    $(this).closest('.repeater_block').find('[data-repeater-create]').hide();
                } else {
                    $(this).closest('.repeater_block').find('[data-repeater-create]').show();
                }
            }
            initWidgets()
            $(this).slideDown()
        }, hide: function (e) {

            if ($this.data('max-items')) {
                if ($(this).closest('.repeater_block').find('[data-repeater-item]').length > $this.data('max-items')) {
                    $(this).closest('.repeater_block').find('[data-repeater-create]').hide();
                } else {
                    $(this).closest('.repeater_block').find('[data-repeater-create]').show();
                }
            }
            $(this).slideUp(e)

        }, ready: function (e) {

            if ($this.data('max-items')) {
                if ($this.find('[data-repeater-item]').length >= $this.data('max-items')) {
                    $this.find('[data-repeater-create]').hide();
                    $.each($this.find('[data-repeater-item]'), function (index, value) {
                        if (index >= $this.data('max-items'))
                            $(this).remove();
                    })
                } else {
                    $this.find('[data-repeater-create]').show();
                }
            }
        },
    });
})

initWidgets()
$(document).on('click', '.img_block .delete', function (e) {
    $(this).closest('.img_block').remove();
})
let hiddenFields = $('[data-show-if]');
if (hiddenFields) {
    function checkHiddenFields() {
        $.each(hiddenFields, function (index, value) {
            var input = $('[name=' + $(this).data('show-if') + ']');
            if (input.attr('type') == 'checkbox' || input.attr('type') == 'radio') {
                if (input.prop('checked')) {
                    $(this).addClass('active')
                } else {
                    $(this).removeClass('active')
                }
            } else {
                if (input.val().length > 0) {
                    $(this).addClass('active')
                } else {
                    $(this).removeClass('active')
                }
            }
        })
        initWidgets()
    }

    $.each(hiddenFields, function (index, value) {
        var input = $('[name=' + $(this).data('show-if') + ']');
        $(input).on('change', function () {
            checkHiddenFields()
        })
    })
    $(document).ready(function () {
        checkHiddenFields()
    })

}
$(document).on('change', '#data_list input[data-id]', function () {
    let $this = $(this);
    $.ajax({
        url: '/update-event',
        type: 'POST',
        data: {
            id: $this.data('id'),
            name: $this.attr('name'),
            value: $this.prop('checked') ? 1 : 0
        },
        success: function () {
            location.reload()

        }
    });
})
$(document).on('click', '[data-delete-model]', function () {
    let $this = $(this),
        ids = [];
    $.each($('.item-checker:checked'), function (index, value) {
        ids.push($(this).val())
    })
    if (ids.length > 0) {
        $.ajax({
            url: '/delete-items',
            type: 'POST',
            data: {
                ids: ids,
                model: $this.data('delete-model'),
            },
            success: function () {
                location.reload()
            }
        });
    } else {
        alert('Не выделена ни одна запись таблицы');
    }
    return false;

})

$(document).on('change', '.item-checker', function () {
    if ($('.item-checker:checked').length > 0) {
        $('.m-portlet__foot').addClass('active');
    } else {
        $('.m-portlet__foot').removeClass('active');
    }
    return false;
})

