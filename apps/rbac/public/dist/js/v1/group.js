/*!
 * Start Bootstrap - Admin v3.3.7+1 (https://github.com/KevinsDeveloper/bootstrap4-admin)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
define(['jquery', 'bootstrap', 'bootstrap-select', 'datatables.net', 'datatables-bootstrap','jquery-base64'], function ($, undefined, undefined, undefined, undefined, undefined) {
    var method = {
        open: function (dom, title, weight, height) {
            $('.content').on('click', dom, function () {
                var org_id = $(this).attr('data-id');
                var url = $(this).attr('data-url') || '';
                url = url + '&org_id=' + org_id;
                var titles = title || '';
                var height1 = height ? height : '550px'
                var weight1 = weight ? weight : '700px';
                Fast.api.open(url, titles, {area: [weight1, height1]});
            });
        },
        get_batch_params: function () {
            var data_arr = [];
            var tmp_arr = $('.data-check_box');
            var attr_name = 'data-id';
            for (var i = 0; i < tmp_arr.length; i++) {
                if ($(tmp_arr[i]).is(':checked')) {
                    var data_item = $(tmp_arr[i]).attr(attr_name);
                    data_item = $.trim(data_item);
                    if (data_item) data_arr.push(data_item);
                }
            }
            var id = data_arr;
            return id;
        },
        //刷新页面
        fun: function () {
            window.location.reload();
        }
    }

    var Controller = {
        // 初始化方法, 默认运行
        _initialize: function () {
            //默认选择菜单第一项
            $(".dialog-form input[type='text']").eq(0).focus();
            //全选操作
            $('.data-check_box_total').click(function () {
                var thisobj = $(this);
                var is_check = thisobj.is(':checked');
                var sub_check_box_list = $('.data-check_box');
                for (var i = 0; i < sub_check_box_list.length; i++) {
                    $(sub_check_box_list[i]).prop('checked', is_check);
                }
                $('.box_total').html($("input[name='box_checked']:checked").length);
            });
            // 统计选择数量
            $(".data-check_box").click(function () {
                $('.box_total').html($("input[name='box_checked']:checked").length);
            });
            //批量删除
            $('.batch_delete').click(function () {
                layer.confirm('确定删除吗?', {icon: 3, title: '重要提示'}, function (index) {
                    var url = $('.batch_delete').attr('data-url');
                    var id = method.get_batch_params();
                    console.log(url);
                    if (id.length == 0) {
                        layer.msg('请选择操作的数据');
                        return false;
                    }
                    var ids = id.join(',');
                    var options = [];
                    options.url = url;
                    options.data = {ids: ids};
                    Fast.api.ajax(options, method.fun);
                });
            });


            //批量移除用户
            $('.batch_move').click(function () {
                layer.confirm('确定移除吗?', {icon: 3, title: '重要提示'}, function (index) {
                    var url = $('.batch_move').attr('data-url');
                    var id = method.get_batch_params();
                    if (id.length == 0) {
                        layer.msg('请选择操作的数据');
                        return false;
                    }
                    var ids = id.join(',');
                    var options = [];
                    options.url = url;
                    options.data = {ids: ids};
                    Fast.api.ajax(options, method.fun);
                });
            });

            //移除单个用户
            $('.move').click(function () {
                var url = $(this).attr('data-url');
                layer.confirm('确定移除吗?', {icon: 3, title: '重要提示'}, function (index) {
                    console.log(url);
                    var options = [];
                    options.url = url;
                    Fast.api.ajax(options, method.fun);
                });
            });

            //批量禁用成员
            $('.batch_forbid').click(function () {
                layer.confirm('确定禁用吗?', {icon: 3, title: '重要提示'}, function (index) {
                    var url = $('.batch_forbid').attr('data-url');
                    var id = method.get_batch_params();
                    if (id.length == 0) {
                        layer.msg('请选择操作的数据');
                        return false;
                    }
                    var ids = id.join(',');
                    var options = [];
                    options.url = url;
                    options.data = {id: ids};
                    Fast.api.ajax(options, method.fun);
                });
            });

            /*切换折叠指示图标*/
            $(".panel-heading").click(function (e) {
                $(this).find(".right").toggleClass("glyphicon-menu-left");
                $(this).find(".right").toggleClass("glyphicon-menu-down");
            });

            //搜索
            $(".selectpicker").selectpicker({
                selectAllText: '全选',
                deselectAllText: '取消',
                liveSearch: true,
            });

            // 高度
            var head = "#scroll_table_head";
            var scrollY = $(head).length > 0 ? window.screen.height - $(head).offset().top - 180 : window.screen.height - 250;
            $('.dataTables_scrollBody').css('height', '100%');

            var page_len = Config.app.pagesize || 25;
            var maxpage = parseInt((window.screen.height - 200) / 50);
            if (maxpage > page_len) {
                page_len = maxpage;
            }
            // 表格分页
            $(document).ready(function () {
                $('.dataTables').DataTable({
                    searching: true,
                    order: false,
                    info: false,
                    ordering: false,
                    sorting: false,
                    aLengthMenu: [10, 20, 25, 50, 100, 200, 300, 500],
                    scrollX: true,
                    scrollY: scrollY,
                    sScrollY: scrollY - 150,
                    autoWidth: false,
                    pagingType: "full_numbers",
                    pageLength: page_len,
                    language: {
                        sSearch: "搜索：",
                        lengthMenu: "每页 _MENU_ 条记录",
                        emptyTable: '未找到相关数据',
                        paginate: {
                            previous: '上一页',
                            next: '下一页',
                            first: '首页',
                            last: '末页',
                        },
                    }
                });
            });
        },

        // 部门管理
        department: function () {
            //节点
            var dom = {
                add: ".add",
                copy: ".copy",
                cat: ".cat",
                edit: ".edit"
            };

            //添加部门
            method.open(dom.add, '新增部门', '', '');

            //编辑岗位
            method.open(dom.edit, '编辑部门', '', '');

            //复制部门
            method.open(dom.copy, '复制部门', '', '');

            //查看用户
            method.open(dom.cat, '查看用户', '980px', '720px');

            //禁用部门
            $('body').on('click', '.forbid', function () {
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                layer.confirm('确定禁用吗?', {icon: 3, title: '重要提示'}, function (index) {
                    console.log(url);
                    var options = [];
                    options.url = url;
                    options.data = {id: id}
                    Fast.api.ajax(options, method.fun);
                });
            });

            //启用部门
            $('.content').on('click', '.start', function () {
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                layer.confirm('确定启用吗?', {icon: 3, title: '重要提示'}, function (index) {
                    console.log(url);
                    var options = [];
                    options.url = url;
                    options.data = {id: id}
                    Fast.api.ajax(options, method.fun);
                });
            });
        },

        //组织架构列表
        organization: function () {
            //节点
            var dom = {
                add: ".add",
                copy: ".copy",
                edit: ".edit",
                cat : ".cat",
                add_account : '.add_account',
                edit_account: '.edit_account'
            };

            //查看绑定账号
            method.open(dom.cat, '查看成员帐号', '900px', '550px');

            //添加成员
            method.open(dom.add, '新增成员', '700px', '550px');

            //编辑成员
            method.open(dom.edit, '成员帐号', '900px', '600px');

            //复制成员
            method.open(dom.copy, '复制成员', '700px', '550px');

            //新增帐号
            method.open(dom.add_account, '新增帐号', '', '500px');

            //编辑帐号
            method.open(dom.edit_account, '编辑帐号', '', '500px');

            //修改
            $('.org-edit').click(function () {
                $('#status').removeAttr('disabled');
            });

            //查看location
            $('.table').on('click', '.cat_locations', function () {
                var url = $(this).attr('data-url');
                var titles = "查看location";
                Fast.api.open(url, titles, {area: ['700px', '500px']});
            });

            //查看销售标签
            $('.table').on('click', '.cat_label', function () {
                var url = $(this).attr('data-url');
                var titles = "查看销售标签";
                Fast.api.open(url, titles, {area: ['700px', '500px']});
            });

            //移除账号
            $('.move_account').click(function(){
                var obj = $(this);
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                layer.confirm('确定移除吗?', {icon: 3, title: '重要提示'}, function (index) {
                    var options = [];
                    options.url = url;
                    options.data = {id:id};
                    Fast.api.ajax(options,
                        function(){
                            obj.parent().parent().remove();
                        }
                    );
                });
            });

            //一键移除帐号
            $('.batch_move_account').click(function(){
                var url     = $(this).attr('data-url');
                var org_id  = $(this).attr('data-org');
                var user_id = $(this).attr('data-user');
                layer.confirm('确定移除吗?', {icon: 3, title: '重要提示'}, function (index) {
                    var options = [];
                    options.url = url;
                    options.data = {org_id:org_id, user_id:user_id};
                    Fast.api.ajax(options,
                        function(){
                            $("#body").html('');
                        }
                    );
                });
            });

            //平台帐号二级联动
            $('#platform-select').change(function(){
                var select_item = $(this).val();
                var all_data = $('#td-platform-account').attr('data-all');
                all_data = JSON.parse($.base64.decode(all_data));
                var bind_data = $('#bind-account').attr('data-all');
                bind_data = JSON.parse($.base64.decode(bind_data));
                if (!all_data) return false;
                $('#select-ebay_account').find('option').remove();
                if (select_item) {
                    var account_list = all_data[select_item];
                    var element_str = '<option value="">请选择</option>';
                    for (_k in account_list) {
                        var key = $.inArray(account_list[_k],bind_data);
                        if(key >= 0){
                            element_str += '<option disabled="disabled" value="' + account_list[_k] + '">' + account_list[_k] + '</option>';
                        }else {
                            element_str += '<option value="' + account_list[_k] + '">' + account_list[_k] + '</option>';
                        }
                    }
                    $('#select-ebay_account').append(element_str);
                }
                if(select_item == 'ebay'){
                    $('#store').css('display','block');
                    $('#locations').css('display','block');
                    $('#sales_label').css('display','block');
                }else{
                    $('#store').css('display','none');
                    $('#locations').css('display','none');
                    $('#sales_label').css('display','none');
                }
                $('#select-ebay_account').selectpicker('refresh');
            })
        },
    }
    return Controller;
});