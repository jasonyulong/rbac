/*!
 * Start Bootstrap - Admin v3.3.7+1 (https://github.com/KevinsDeveloper/bootstrap4-admin)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
define(['jquery', 'bootstrap', 'bootstrap-select', 'template', 'laydate'], function ($, undefined, undefined, template, laydate) {
    var hepler = {
        laydate: function (dom, type) {
            laydate.render({elem: dom, type: type, theme: 'molv'});
        },
        open: function (dom, title, width, height) {
            $(dom).click(function () {
                var url = $(this).attr('data-url') || '';
                var titles = title || '编辑';
                Fast.api.open(url, titles, {area: [width, height]});
            });
        },
        cancel: function (dom) {
            //取消按钮
            $(dom).click(function () {
                parent.layer.closeAll();
            });
        },
        checked: function (dom, num) {
            $(dom).click(function () {
                if (num == 2) {
                    var thisobj = $(this);
                    var is_check = thisobj.is(':checked');

                    var sub_check_box_list = $('.data-check_box');
                    for (var i = 0; i < sub_check_box_list.length; i++) {
                        $(sub_check_box_list[i]).prop('checked', is_check);
                    }
                }
                $('.box_total').html($("input[name=box_checked]:checked").length);
            });
        },
        checkedId: function (attr_name) {
            var data_arr = [];
            var tmp_arr = $('.data-check_box');
            for (var i = 0; i < tmp_arr.length; i++) {
                if ($(tmp_arr[i]).is(':checked')) {
                    var data_item = $(tmp_arr[i]).attr(attr_name);
                    data_item = $.trim(data_item);
                    if (data_item) data_arr.push(data_item);
                }
            }

            return data_arr;
        },
        oneCheckId: function (dom) {
            //单个勾选
            $(dom).click(function () {
                $('.box_total').html($("input[name='box_checked']:checked").length);
            });
        },
        reminder: function (html) {
            //提示信息
            parent.layer.open({
                type: 1,
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                scrollbar: false,
                area: ['500px', '500px'],
                content: html,
                end: function () {
                    location.reload();
                }
            });
        },
        del: function (dom, title, ids) {
            //删除的confirm
            var title = title || '删除？';
            layer.confirm('确定要删除吗?', {icon: 3, title: title}, function (index) {
                var url = $(dom).attr('data-url');
                $.post(
                    url,
                    {ids: ids},
                    function (ret) {
                        if (ret.code > 0) {
                            var html = '';
                            $.each(ret.data, function (index, value) {
                                var cla = value.success ? '' : 'error';
                                html += '<p class="' + cla + '">' + index + '. ' + value.msg + '</p>';
                            });
                            var content = '<div class="layer-content" style="margin:15px;">' + html + '</div>';
                            hepler.reminder(content);
                        }
                    }, 'json'
                );
                layer.close(index);
            });
        },
    }
    var Controller = {
        // 初始化方法, 默认运行
        _initialize: function () {
            // bootstrap select
            $(".selectpicker").selectpicker({
                selectAllText: '全选',
                deselectAllText: '取消',
                // 是否允许搜索
                liveSearch: true,
            });
            $.validator.setTheme('bootstrap', {
                validClass: 'has-success',
                invalidClass: 'has-error',
                bindClassTo: '.form-group',
                formClass: 'n-default n-bootstrap',
                msgClass: 'n-right'
            });
            //默认选择菜单第一项
            $(".dialog-form input[type='text']").eq(0).focus();
        },
        index: function () {
            // 页面dom节点
            var doms = {
                addusername: ".addusername",
                editusername: ".editusername",
                del: ".del",
                bathdel: ".bathdel",
                editrule: ".editrule",
                addobj: ".addobj",
                showLog: ".showLog",
            };
            //全选，不全选
            hepler.checked('.data-check_box_total', 2);
            //单选
            hepler.checked('.data-check_box', 1);

            //取消按钮
            hepler.cancel('#cancel');

            //时间插件
            hepler.laydate('#preentrytime', 'datetime');
            hepler.laydate('#proceduretime', 'datetime');
            //搜索页面的时间
            hepler.laydate('#start_time', 'date');
            hepler.laydate('#end_time', 'date');
            //过期时间
            hepler.laydate('#maturitytime', 'datetime');

            //添加用户
            hepler.open(doms.addusername, '添加', '700px', '760px');

            //批量转入待处理
            $('.savePending').click(function () {
                var id = hepler.checkedId('data-id');
                var url = $(this).attr('data-url');
                if (id.length == 0) {
                    layer.msg('请选择要操作的用户!', {time: 2000});
                    return false;
                }
                layer.confirm('确定要此操作?', {icon: 3, title: '批量操作'}, function (index) {
                    $.post(
                        url,
                        {id: id, status: 2},
                        function (ret) {
                            if (ret.code > 0) {
                                var html = '';
                                $.each(ret.data, function (index, value) {
                                    var cla = value.success ? '' : 'error';
                                    html += '<p class="' + cla + '">' + index + '. ' + value.msg + '</p>';
                                });
                                var content = '<div class="layer-content" style="margin:15px;">' + html + '</div>';
                                hepler.reminder(content);
                            }
                        }
                    );
                    layer.close(index);
                });
            });
            //编辑用户
            hepler.open(doms.editusername, '编辑', '700px', '730px');

            //查看日志
            hepler.open(doms.showLog, '日志', '800px', '600px');

            //跳转到新增标签权限
            $(doms.addobj).click(function () {
                var url = $(this).attr('data-url');
                layer.open({
                    type: 2,
                    shade: false,
                    area: ['580px', '400px'],
                    maxmin: true,
                    content: url,
                    zIndex: layer.zIndex
                });
            });

            //允许登录系统的全部
            $('.allow').click(function () {
                if ($(this).prop("checked")) {
                    var bool = true;
                } else {
                    var bool = false;
                }
                $(this).siblings('.child').find("input[type='checkbox']").prop("checked", bool);
            });

            //批量编辑用户的权限，岗位，权限标签
            $(doms.editrule).click(function () {
                var id = hepler.checkedId('data-id');
                var title = $(this).attr('title');
                var length = id.length;
                if (length <= 0) {
                    layer.msg('请选择用户!', {time: 2000});
                    return false;
                }
                var ids = id.join(',');
                var urls = $(this).attr('data-url');
                var url = urls + '&ids=' + ids;
                Fast.api.open(url, title, {area: ['700px', '470px']});
            });

            //批量删除
            $(doms.bathdel).click(function () {
                var user_id = $(this).attr('datas-id');
                var ids = [];
                if (typeof(user_id) == "undefined") {
                    var ids = hepler.checkedId('data-id');
                    if (ids.length == 0) {
                        layer.msg('请选择要删除的用户!', {time: 2000});
                        return false;
                    }
                } else {
                    ids = user_id.split(',');
                }
                hepler.del(doms.bathdel, '删除？', ids)
            });
            //填写备注
            $(".notes").click(function () {
                var url = $(this).attr('data-url');
                if (!$(this).find("textarea").val()) {
                    var vl = $(this).text();
                    $(this).html("<textarea rows='2' cols='15'>" + vl + "</textarea>");
                    $(this).find("textarea").focus();
                    $(this).find("textarea").blur(function () {
                        var note = $(this).val();       //备注
                        var patObj = $(this).parent("div.notes");
                        var user_id = patObj.attr("id");    //用户ID
                        //ajax提交
                        $.post(
                            url,
                            {id: user_id, note: note},
                            function (data) {
                                if (data.code > 0) {
                                    layer.msg(data.msg);
                                } else {
                                    layer.msg(data.msg);
                                }
                            }, 'json'
                        );
                        patObj.html(note);
                    });
                }
            });
        }

    }
    return Controller;
});