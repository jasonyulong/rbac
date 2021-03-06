/*!
 * Start Bootstrap - Admin v3.3.7+1 (https://github.com/KevinsDeveloper/bootstrap4-admin)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
define(['jquery', 'bootstrap', 'template'], function ($, undefined, template) {
    var Controller = {
        // 初始化方法, 默认运行
        _initialize: function () {
            var form = $(".dialog-form");
            //默认选择菜单第一项
            $(".dialog-form input[type='text']").eq(0).focus();
            //追加控制
            $(".fieldlist", form).on("click", ".btn-append,.append", function (e, row) {
                var container = $(this).closest("dl");
                var index = container.data("index");
                var name = container.data("name");
                var data = container.data();
                index = index ? parseInt(index) : 0;
                container.data("index", index + 1);
                var row = row ? row : {};
                var vars = {index: index, name: name, data: data, row: row};

                var html = '<dd class="form-inline"><input type="text" name="<%=name%>[field][]" class="form-control" value="" size="10" /> <input type="text" name="<%=name%>[value][]" class="form-control" value="" size="40" /> <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span></dd>';

                html = html.replace('<%=name%>', vars.name);
                html = html.replace('<%=name%>', vars.name);

                $(html).insertBefore($(this).closest("dd"));
                $(this).trigger("fa.event.appendfieldlist", $(this).closest("dd").prev());
            });
            //移除控制
            $(".fieldlist", form).on("click", "dd .btn-remove", function () {
                $(this).closest("dd").remove();
            });
        }
    }
    return Controller;
})