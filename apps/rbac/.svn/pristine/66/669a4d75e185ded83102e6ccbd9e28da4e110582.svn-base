define(['jquery', 'bootstrap', 'template', 'datatables.net', 'datatables-bootstrap', 'bootstrap-select'], function ($, undefined, template, undefined, undefined, undefined) {
    var method = {
        open: function (dom, title, height) {
            $('.content').on('click', dom, function () {
                var url = $(this).attr('data-url') || '';
                var titles = title || '';
                var height1 = height ? height : '550px'
                Fast.api.open(url, titles, {area: ['700px', height1]});
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
            $(".selectpicker").selectpicker({
                selectAllText: '全选',
                deselectAllText: '取消'
            });

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
                    if ($('#rules_id').length > 0) {
                        var rules_id = $('#rules_id').val() ? $('#rules_id').val() : 0;
                        options.data = {ids: ids, rules_id: rules_id};
                    } else {
                        options.data = {ids: ids};
                    }
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

            // 高度
            var head = "#scroll_table_head";
            var scrollY = $(head).length > 0 ? window.screen.height - $(head).offset().top - 180 : window.screen.height - 250;
            $('.dataTables_scrollBody').css('height', '100%');

            var page_len = 500;
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
                    sScrollY: scrollY - 180,
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

        // 岗位管理
        position: function () {
            //节点
            var dom = {
                add: ".add",
                edit: ".edit",
                copy: ".copy",
                cat: ".cat",
                auth: ".auth"
            };

            //添加岗位
            method.open(dom.add, '新增岗位', '');

            //编辑岗位
            method.open(dom.edit, '编辑岗位', '');

            //复制岗位
            method.open(dom.copy, '复制岗位', '350px');

            //查看用户
            method.open(dom.cat, '查看用户', '680px');

            //查看权限
            $('.content').on('click', dom.auth, function () {
                layer.msg('待开发');
            });

            //收缩
            $('.content').on('click','.pos-show',function(){
                var tid = '.show-' + $(this).attr('data-id');
                var className = $(this).children().attr('class');
                if(className == 'glyphicon glyphicon-menu-up'){
                    $(tid).css('display','none');
                    $(this).children().attr('class','glyphicon glyphicon-menu-down');
                }else{
                    $(tid).css('display','');
                    $(this).children().attr('class','glyphicon glyphicon-menu-up');
                }
            });
        },
        //权限标签管理
        tag: function () {
            //节点
            var dom = {
                add: ".add",
                edit: ".edit",
                copy: ".copy",
                cat: ".cat",
                auth: ".auth"
            };

            //添加岗位
            method.open(dom.add, '新增标签', '400px');

            //编辑岗位
            method.open(dom.edit, '编辑标签', '400px');

            //复制岗位
            method.open(dom.copy, '复制标签', '400px');

            //查看用户
            method.open(dom.cat, '查看用户', '680px');

            //查看权限
            $(dom.auth).click(function () {
                layer.msg('待开发');
            })
        },

        access: function () {
            // 检测 该level 下的子checkbox 是否全部选中
            function is_all_sub_check(thisobj, level) {
                var is_check = $(thisobj).is(':checked');
                var rule = '.level' + level + '-rule';
                // var checkbox = '.level' + (level + 1) + '-checkbox';

                var cb = $(thisobj).closest(rule).find('input[type=checkbox]');

                // if (level == 3)console.log(cb.length);
                var check_num = 0;
                for (var i = 0; i < cb.length; i++) {
                    if ($(cb[i]).is(':checked')) check_num++;
                }

                var check_status = 0; // 0 全没选 1 全选 -1  部分选中

                if (is_check) {
                    if (check_num == 0) {
                        check_status = 0;
                    }
                    else if (check_num == (cb.length - 1)) {
                        check_status = 1;
                    }
                    else {
                        check_status = -1
                    }
                }
                else {
                    if (check_num == 0) {
                        check_status = 0;
                    }
                    else if (check_num == cb.length) {
                        check_status = 1;
                    }
                    else {
                        check_status = -1
                    }
                }

                // console.log("level:", level, " rule:", rule, ' cb size:', cb.length, 'check num:', check_num, 'check status:', check_status);

                return check_status;
            };

            // 跟新 父级 的checkbox 的 选中状态
            function update_parent_checkbox_status(thisobj, level, check_status) {
                // console.log(check_status)
                var rule = '.level' + level + '-rule';
                var checkbox = '.level' + level + '-checkbox';

                var cb = $(thisobj).closest(rule).find(checkbox);

                if (check_status == -1) {
                    $(cb).prop('indeterminate', true);
                }
                if (check_status == 1) {
                    $(cb).prop('indeterminate', false);
                    $(cb).prop('checked', check_status);
                }
                if (check_status == 0) {
                    $(cb).prop('indeterminate', false);
                    $(cb).prop('checked', false);
                }
            };

            // 更新子 checkbox
            function check_sub(thisobj, current_level) {
                var is_check = $(thisobj).is(':checked');
                var rule = '.level' + current_level + '-rule';
                while (current_level < 4) {
                    var checkbox = '.level' + (current_level + 1) + '-checkbox';
                    $(thisobj).closest(rule).find(checkbox).prop('checked', is_check);
                    current_level++;
                }
            };

            function init_access_check() {
                $('.level1-checkbox').click(function (e) {
                    check_sub($(this), 1);
                });

                $('.level2-checkbox').click(function (e) {
                    check_sub($(this), 2);
                    update_parent_checkbox_status($(this), 1, is_all_sub_check($(this), 1));
                });

                $('.level3-checkbox').click(function (e) {
                    check_sub($(this), 3);

                    update_parent_checkbox_status($(this), 2, is_all_sub_check($(this), 2));
                    update_parent_checkbox_status($(this), 1, is_all_sub_check($(this), 1));
                });

                $('.level4-checkbox').click(function (e) {
                    update_parent_checkbox_status($(this), 3, is_all_sub_check($(this), 3));
                    update_parent_checkbox_status($(this), 2, is_all_sub_check($(this), 2));
                    update_parent_checkbox_status($(this), 1, is_all_sub_check($(this), 1));
                });
            };

            function init_scroller() {
                $(".scroll-link").click(function (e) {
                    e.preventDefault();
                    var aid = $(this).attr("href");
                    $('html,body').animate({scrollTop: $(aid).offset().top - 50}, 'slow');
                    $('.scroll-to').find('svg').attr('fill', 'none');
                    $(this).siblings('svg').attr('fill', '#337ab7');
                });
            };

            function init_default_form() {
                // 阻止默认的提交行为，使用自定义的提交方法
                $('#default_form').submit(function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();

                    // console.log(data);
                    var tmp = [];
                    for (var key in data) {
                        var _data = data[key];
                        if (_data['name'].endsWith('[]')) {
                            var tmp_key = _data['name'].substr(0, _data['name'].length - 2);
                            if (!tmp[tmp_key]) tmp[tmp_key] = [];
                            tmp[tmp_key].push(_data['value']);
                        }
                        else {
                            tmp[_data['name']] = _data['value']
                        }
                    }

                    data = {};
                    for (var key in tmp) {
                        var tmp_value = tmp[key];
                        if (Array.isArray(tmp_value)) data[key] = tmp_value.join(',');
                        else data[key] = tmp_value
                    }
                    if (!data.menu) data.menu = '';
                    if (!data.menu_detail) data.menu_detail = '';
                    if (!data.store_id) data.store_id = '';
                    if (!data.account) data.account = '';
                    if (!data.order_status) data.order_status = '';
                    // console.log(data);
                    // layer.load();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: data,
                        dataType: 'JSON',
                        success: function (ret) {
                            layer.closeAll();
                            if (ret.code != 0) layer.alert(ret.msg);
                            else layer.alert(ret.msg, {
                                'yes': function () {
                                    parent.location.reload();
                                }
                            });
                        }
                    })
                });
            };

            function init_change_job_access() {
                $('#job_access').change(function () {
                    var access = $(this).val();
                    $('#default_form').find('input[type=checkbox]').prop('checked', false);

                    if (access) {
                        var access = JSON.parse(access);
                        var menu_ids = access.menu_id.split(',');
                        var menu_detail_ids = access.menu_detail_ids.split(',');
                        var all_ids = menu_ids.concat(menu_detail_ids);

                        for (var key in all_ids) {
                            $('#cb_' + all_ids[key]).prop('checked', true);
                        }

                        var store_id = access.store_id.split(',');
                        var account = access.account.split(',');
                        for (var key in store_id) {
                            $('#anchor-oversee-div').find('input[name="store_id[]"][value="' + store_id[key] + '"]').prop('checked', true);
                        }

                        for (var key in account) {
                            $('#anchor-oversee-div').find('input[name="account[]"][value="' + account[key] + '"]').prop('checked', true);
                        }
                    }
                });
            }

            function init_change_platform() {
                $('.platform-tab').click(function () {
                    var platform = $(this).attr('data-platform');
                    $('.platform-nav').find('li').attr('class', '');
                    $(this).parent('li').attr('class', 'active');

                    // console.log(platform, "." + platform + "_account_div")

                    $('.platform-div').hide();
                    $("." + platform + "_account_div").show();
                });
            };

            function init_select_platform() {
                $('.platform-select').click(function () {
                    var platform = $(this).attr('data-platform');
                    var is_check = $(this).is(':checked');
                    $('.' + platform + '_account_div').find("input[type=checkbox]").prop('checked', is_check);
                });

                $('.platform-div input[type=checkbox]').click(function () {
                    var cb = $(this).closest('.platform-div').find('input[type=checkbox]');

                    var platform = $(this).parent().parent().attr('data-platform');

                    var checked_num = 0;
                    for (var i = 0; i < cb.length; i++) {
                        if ($(cb[i]).is(':checked')) checked_num++;
                    }

                    // console.log(platform, checked_num, cb.length)

                    if (checked_num == cb.length) {
                        $('.platform-select-' + platform).prop('indeterminate', false);
                        $('.platform-select-' + platform).prop('checked', true);
                    }
                    else if (checked_num == 0) {
                        $('.platform-select-' + platform).prop('indeterminate', false);
                        $('.platform-select-' + platform).prop('checked', false);
                    }
                    else {
                        $('.platform-select-' + platform).prop('indeterminate', true);
                        $('.platform-select-' + platform).prop('checked', false);
                    }

                });
            };

            function init_change_job()
            {
                $('#job_list').change(function() {
                    var job_data =  $(this).find('option:selected').attr('data-users');
                    job_data = JSON.parse(job_data);

                    $('#user_list').find('.list-group-item').remove();
                    $('#select_users').find('option').remove();

                    $('#select_users').append('<option value="">----选择用户----</option>');

                    for (var key in job_data)
                    {
                        var _data = job_data[key];
                        var a_tag = '<a class="list-group-item" href="?job_id=' + _data.job_id + '&user_id=' + _data.id + '">' + _data.username + '</a>';

                        var opt_tag = '<option value="' + _data.id + '" data-job_id="' + _data.job_id + '">' + _data.username +'</option>';
                        $('#user_list').append(a_tag);
                        $('#select_users').append(opt_tag);
                    }
                    console.log($(this).val(), job_data);

                    $('#select_users').selectpicker('refresh');
                });
            };

            function init_change_job_user()
            {
                $('#select_users').change(function() {
                    var user_id = $(this).val();
                    var opt = $(this).find('option:selected');
                    var job_id = $(opt).attr('data-job_id');
                    location.href = "?job_id=" + job_id + '&user_id=' + user_id;
                });
            }

            init_access_check();
            init_scroller();
            init_default_form();
            init_change_job_access();
            init_change_platform();
            init_select_platform();
            init_change_job();
            init_change_job_user();
        },
    }
    return Controller;
});


