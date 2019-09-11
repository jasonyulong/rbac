/*!
 * Start Bootstrap - Admin v3.3.7+1 (https://github.com/KevinsDeveloper/bootstrap4-admin)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
define(['jquery', 'bootstrap', 'template'], function ($, undefined, template) {
    var dom = {
        noticeclose: '.notices .close',
    };
    var Controller = {
        index: function () {
            // 用户通知关闭
            $(dom.noticeclose).click(function () {
                var that = this;
                var options = {
                    url: $(that).attr("data-url"),
                    data: 'id=' + $(that).attr("data-id"),
                };
                options.success = function (ret, data) {
                    parent.layer.closeAll();
                    return true;
                };
                options.error = function (ret) {
                    Fast.events.error(ret.msg);
                    return false;
                };
                Fast.api.ajax(options, null, null);
                return true;
            });
        }
    }
    return Controller;
});