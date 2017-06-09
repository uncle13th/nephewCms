$(function(){

    //初始化
    init();

    //执行一些初始化操作
    function init(){

        setSearchOption();

        $("#search").on('click', search);
        $("#addUser").on('click', addUser);
        $('#saveUser').on('click', saveUser);
        $("#delModal .btn-primary").on('click', function(){
            delUser();
        });

        //修改按钮的点击事件处理
        $('table .btn-info').on('click', function(){
            var jsonData = $(this).parent().find(':hidden').val();
            var data = $.parseJSON(jsonData);
            editUser(data);
        });
        //删除按钮的点击事件处理
        $('table .btn-danger').on('click', function(){
            var jsonData = $(this).parent().find(':hidden').val();
            var data = $.parseJSON(jsonData);
            showDeleteModal(data);
        });
    }

    //初始化查询条件
    function setSearchOption(){
        $("#searchArea ul li ").click(function(){
            $("#searchArea button").html($(this).text()+'<span class="fa fa-caret-down"></span>');
            $("#searchArea button").attr('k', $(this).attr('k'));
        });
    }

    //查找用户
    function search(){
        var keyword = $("#keyword").val();
        if($.trim(keyword) == ''){
            return false;
        }
        var key = $("#searchArea button").attr('k');
        var url = '/home/user/list?' + key + "=" + keyword;
        window.location.href = url;
    }

    //添加用户信息
    function addUser(){
        $('#operation').val('add');
        $("#infoModal .box-header h3").html('新增用户');
        clearModalData();
        $('#infoModal').modal({'backdrop' : false});
    }

    //清空模态框上所有数据
    function clearModalData(){
        $("#idArea").css('display', 'none');
        $("#username").val('');
        $("#nickname").val('');
        $("#role").val(0);
        $('input:radio[name="status"]').eq(0).prop('checked', "checked");

        $('#saveResult').html('');
    }

    //修改用户信息
    function editUser(data){
        $('#operation').val('edit');
        $("#infoModal .box-header h3").html('修改用户');
        setModalData(data);
        $('#infoModal').modal({'backdrop' : false});
    }

    //设置模态框各个字段信息（编辑用户）
    function setModalData(data){
        //console.log(data);return;
        $("#userId").val(data.id);
        $("#idArea").find('label').eq(1).html(data.id);
        $("#idArea").css('display', 'block');
        $("#username").val(data.username);
        $("#username").attr("disabled",true);
        $("#nickname").val(data.nickname);
        $("#role").val(data.role_id);
        $(":password").parent().parent().css('display', 'none');
        if(data.status == 1){
            $('input:radio[name="status"]').eq(0).prop('checked', "checked");
        }else{
            $('input:radio[name="status"]').eq(1).prop('checked', "checked");
        }

        $('#saveResult').html('');
    }

    //保存用户信息
    function saveUser(){
        var username = $("#username").val();
        if($.trim(username) == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('用户名称不能为空！');
            return false;
        }

        var nickname = $("#nickname").val();
        if($.trim(nickname) == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('昵称不能为空！');
            return false;
        }

        var role = $("#role").val();
        if(role == 0){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个角色！');
            return false;
        }

        $("#saveResult").attr("class", 'text-green');
        $("#saveResult").html('保存信息中，请耐心等待...');

        var operation = $("#operation").val();
        if(operation == 'add'){
            var password = $.trim($("#password").val());
            var comfirm_password = $.trim($("#comfirm_password").val());
            if(password != comfirm_password){
                $("#saveResult").attr("class", 'text-red');
                $("#saveResult").html('密码和确认密码不相等，请修改！');
                return false;
            }
        }

        setReadOnly();

        var token = $("[name='_token']").val();
        var status = $('input:radio[name="status"]:checked').val();

        var data = {
            _token : token,
            nickname: nickname,
            role_id: role,
            status: status
        }

        if(operation == 'add'){
            data.username = username;
            data.password = password;
        }else{
            data.id = $("#userId").val();
        }

        $.ajax({
            type: "post",
            url: "/home/user",
            data: data,
            dataType: "json",
            success: function(respone){
                if(respone.code != 200){
                    $("#saveResult").attr("class", 'text-red');
                    $('#saveResult').html(respone.msg);
                    cancelReadOnly();
                    if(operation == 'edit'){
                        $("#username").attr("disabled",true);
                    }
                }else{
                    cancelReadOnly();
                    if(operation == 'edit'){
                        $("#username").attr("disabled",true);
                    }
                    //设置关闭模态框操作
                    $('#infoModal').on('hidden.bs.modal', function (e) {
                        window.location.href = '/home/user/list';
                    })

                    var i = 3;
                    $("#saveUser").attr("disabled",true)
                    $("#saveResult").attr("class", 'text-green');
                    $('#saveResult').html('操作成功，'+i+'秒后自动跳转...');

                    var interval = setInterval(function(){
                        i--;
                        if(i > 0){
                            $('#saveResult').html('操作成功，'+i+'秒后自动跳转...');
                        }else{
                            clearInterval(interval);
                            window.location.href = '/home/user/list';
                        }
                    }, 1000);
                }
            },
            error: function(){
                $("#saveResult").attr("class", 'text-yellow');
                $('#saveResult').html('系统出现异常，请稍后再试！');
                cancelReadOnly();
                if(operation == 'edit'){
                    $("#username").attr("disabled",true);
                }
            }
        });
    }

    function setReadOnly(){
        $("#infoModal input").attr("disabled",true)
        $("#infoModal button").attr("disabled",true)
        $("#infoModal select").attr("disabled",true)
    }

    function cancelReadOnly(){
        $("#infoModal input").attr("disabled",false)
        $("#infoModal button").attr("disabled",false)
        $("#infoModal select").attr("disabled",false)
    }

    //展示删除用户确认窗口
    function showDeleteModal(data){
        $('#delModal').modal({'backdrop' : false});
        $("#delModal :hidden").val(data.id);
        $("#delModal").find('p').eq(0).html('是否确定要删除该用户(id=' + data.id + ')？');
    }

    //删除用户
    function delUser(){
        var id = $("#delModal :hidden").val();
        var token = $("[name='_token']").val();
        var data = {
            _token:token,
            id:id
        }

        $("#delModal button").attr("disabled", true);
        $("#deleteResult").attr("class", 'text-green');
        $('#deleteResult').html('操作进行中，请耐心等待！');

        $.ajax({
            type: "delete",
            url: "/home/user",
            data: data,
            dataType: "json",
            success: function (respone) {
                if (respone.code != 200) {
                    $("#deleteResult").attr("class", 'text-red');
                    $('#deleteResult').html(respone.msg);
                    $("#delModal button").attr("disabled", false)
                } else {
                    $("#delModal .btn-default").attr("disabled", false)

                    //设置关闭模态框操作
                    $('#infoModal').on('hidden.bs.modal', function (e) {
                        window.location.href = '/home/user/list';
                    })

                    var i = 3;
                    $("#delModal .btn-primary").attr("disabled", true)
                    $("#deleteResult").attr("class", 'text-green');
                    $('#deleteResult').html('操作成功，' + i + '秒后自动跳转...');

                    var interval = setInterval(function () {
                        i--;
                        if (i > 0) {
                            $('#deleteResult').html('操作成功，' + i + '秒后自动跳转...');
                        } else {
                            clearInterval(interval);
                            window.location.href = '/home/user/list';
                        }
                    }, 1000);
                }
            },
            error: function () {
                $("#deleteResult").attr("class", 'text-yellow');
                $('#deleteResult').html('系统出现异常，请稍后再试！');
                $("#delModal button").attr("disabled", false)
            }
        });
    }

});