$(function(){

    //初始化
    init();

    //执行一些初始化操作
    function init(){

        setSearchOption();
        initheckBox();

        $("#search").on('click', search);
        $("#addRole").on('click', addRole);
        $('#saveRole').on('click', saveRole);
        $("#delRoleModal .btn-primary").on('click', function(){
            delRole();
        });

        //修改按钮的点击事件处理
        $('table .btn-info').on('click', function(){
            var jsonData = $(this).parent().find(':hidden').val();
            var data = $.parseJSON(jsonData);
            editRole(data);
        });
        //删除按钮的点击事件处理
        $('table .btn-danger').on('click', function(){
            var jsonData = $(this).parent().find(':hidden').val();
            var data = $.parseJSON(jsonData);
            showDeleteModal(data);
        });
    }

    //清空模态框上所有数据
    function clearModalData(){
        $("#idArea").css('display', 'none');
        $("#name").val('');
        $('input:radio[name="status"]').eq(0).prop('checked', "checked");
        $(".role-menu :checkbox").each(function(){
            $(this).removeAttr("checked");
        })
        $('#saveResult').html('');
    }

    //初始化查询条件
    function setSearchOption(){
        $("#searchArea ul li ").click(function(){
            $("#searchArea button").html($(this).text()+'<span class="fa fa-caret-down"></span>');
            $("#searchArea button").attr('k', $(this).attr('k'));
        });
    }

    //查找角色
    function search(){
        var keyword = $("#keyword").val();
        if($.trim(keyword) == ''){
            return false;
        }
        var key = $("#searchArea button").attr('k');
        var url = '/home/role/list?' + key + "=" + keyword;
        window.location.href = url;
    }

    //添加角色信息
    function addRole(){
        $('#operation').val('add');
        $("#roleInfoModal .box-header h3").html('新增角色');
        clearModalData();
        $('#roleInfoModal').modal({'backdrop' : false});
    }

    //初始化复选框的点击操作
    function initheckBox(){
        $(".role-menu :checkbox").on('click', function(){
            if($(this).parent().parent().hasClass('col-md-offset-1')){
                //click的是二级菜单
                if($(this).get(0).checked){
                    $(this).parent().parent().prev().find(":checkbox").prop('checked', "checked");
                }else{
                    var flag = false;
                    $(this).parent().parent().find(":checkbox").each(function(){
                        if ($(this).is(":checked")) {
                            flag = true;
                            return ;
                        }
                    });
                    if(!flag){
                        $(this).parent().parent().prev().find(":checkbox").removeAttr('checked');
                    }
                }
            }else{
                //click的是一级菜单
                if($(this).get(0).checked){
                    $(this).parent().parent().next().find(":checkbox").prop('checked', "checked");
                }else{
                    $(this).parent().parent().next().find(":checkbox").removeAttr("checked");
                }
            }
        });
    }

    //获取所有复选框的值
    function getCheckBoxValue(){
        var arr = [];
        var flag = false;
        $(".role-menu :checkbox").each(function(){
            if($(this).get(0).checked){
                arr[$(this).val()] = 1;
                flag = true;
            }else{
                arr[$(this).val()] = 0;
            }
        })

        if(!flag){
            return new Array();
        }
        return arr;
    }

    //修改角色信息
    function editRole(data){
        $('#operation').val('edit');
        $("#roleInfoModal .box-header h3").html('修改角色');
        setModalData(data);
        $('#roleInfoModal').modal({'backdrop' : false});
    }

    //设置模态框各个字段信息（编辑角色）
    function setModalData(data){
        $('#roleId').val(data.id);
        $("#idArea").find('label').eq(1).html(data.id);
        $("#idArea").css('display', 'block');
        $("#name").val(data.name);
        if(data.status == 1){
            $('input:radio[name="status"]').eq(0).prop('checked', "checked");
        }else{
            $('input:radio[name="status"]').eq(1).prop('checked', "checked");
        }

        var menu_arr = [];
        var flag = false;
        if(data.menu_ids == '*'){
            flag = true;
        }else{
            var menu = $.parseJSON(data.menu_ids);
            $.each(menu, function(i, val) {
                menu_arr[i] = val;
            });
        }

        $(".role-menu :checkbox").each(function(){
            var menu_id = $(this).val();
            if(flag || menu_arr[menu_id] == 1){
                $(this).prop('checked', "checked");
            }else{
                $(this).removeAttr("checked");
            }
        })
        $('#saveResult').html('');
    }

    //保存角色信息
    function saveRole(){
        var name = $("#name").val();
        if($.trim(name) == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('角色名称不能为空！');
            return false;
        }
        var menu = getCheckBoxValue();
        if(menu.length == 0){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('角色菜单不能为空！');
            return false;
        }

        $("#saveResult").attr("class", 'text-green');
        $("#saveResult").html('保存信息中，请耐心等待...');

        setReadOnly();

        var token = $("[name='_token']").val();
        var status = $('input:radio[name="status"]:checked').val();

        var data = {
            _token : token,
            name: name,
            status: status,
            menu: menu
        }

        var operation = $("#operation").val();
        if(operation == 'edit'){
            console.log('edit')
            data.id = $("#roleId").val();
        }

        $.ajax({
            type: "post",
            url: "/home/role",
            data: data,
            dataType: "json",
            success: function(respone){
                if(respone.code != 200){
                    $("#saveResult").attr("class", 'text-red');
                    $('#saveResult').html(respone.msg);
                    cancelReadOnly();
                }else{
                    cancelReadOnly();

                    //设置关闭模态框操作
                    $('#roleInfoModal').on('hidden.bs.modal', function (e) {
                        window.location.href = '/home/role/list';
                    })

                    var i = 3;
                    $("#saveRole").attr("disabled",true)
                    $("#saveResult").attr("class", 'text-green');
                    $('#saveResult').html('操作成功，'+i+'秒后自动跳转...');

                    var interval = setInterval(function(){
                        i--;
                        if(i > 0){
                            $('#saveResult').html('操作成功，'+i+'秒后自动跳转...');
                        }else{
                            clearInterval(interval);
                            window.location.href = '/home/role/list';
                        }
                    }, 1000);
                }
            },
            error: function(){
                $("#saveResult").attr("class", 'text-yellow');
                $('#saveResult').html('系统出现异常，请稍后再试！');
                cancelReadOnly();
            }
        });
    }

    function setReadOnly(){
        $("#roleInfoModal input").attr("disabled",true)
        $("#roleInfoModal button").attr("disabled",true)
    }

    function cancelReadOnly(){
        $("#roleInfoModal input").attr("disabled",false)
        $("#roleInfoModal button").attr("disabled",false)
    }

    //展示删除角色确认窗口
    function showDeleteModal(data){
        $('#delRoleModal').modal({'backdrop' : false});
        $("#delRoleModal :hidden").val(data.id);
        $("#delRoleModal").find('p').eq(0).html('是否确定要删除该角色(id=' + data.id + ')？');

    }

    //删除角色
    function delRole(){
        var id = $("#delRoleModal :hidden").val();
        var token = $("[name='_token']").val();
        var data = {
            _token:token,
            id:id
        }

        $("#delRoleModal button").attr("disabled", true);
        $("#deleteResult").attr("class", 'text-green');
        $('#deleteResult').html('操作进行中，请耐心等待！');

        $.ajax({
            type: "delete",
            url: "/home/role",
            data: data,
            dataType: "json",
            success: function (respone) {
                if (respone.code != 200) {
                    $("#deleteResult").attr("class", 'text-red');
                    $('#deleteResult').html(respone.msg);
                    $("#delRoleModal button").attr("disabled", false)
                } else {
                    $("#delRoleModal .btn-default").attr("disabled", false)

                    //设置关闭模态框操作
                    $('#roleInfoModal').on('hidden.bs.modal', function (e) {
                        window.location.href = '/home/role/list';
                    })

                    var i = 3;
                    $("#delRoleModal .btn-primary").attr("disabled", true)
                    $("#deleteResult").attr("class", 'text-green');
                    $('#deleteResult').html('操作成功，' + i + '秒后自动跳转...');

                    var interval = setInterval(function () {
                        i--;
                        if (i > 0) {
                            $('#deleteResult').html('操作成功，' + i + '秒后自动跳转...');
                        } else {
                            clearInterval(interval);
                            window.location.href = '/home/role/list';
                        }
                    }, 1000);
                }
            },
            error: function () {
                $("#deleteResult").attr("class", 'text-yellow');
                $('#deleteResult').html('系统出现异常，请稍后再试！');
                $("#delRoleModal button").attr("disabled", false)
            }
        });
    }

});