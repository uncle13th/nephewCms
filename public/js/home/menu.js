$(function() {

    //初始化
    init();

    function init(){

        $(".connectedSortable").sortable({
            placeholder: "sort-highlight",
            connectWith: ".connectedSortable",
            handle: ".box-header, .nav-tabs",
            forcePlaceholderSize: true,
            zIndex: 999999
        });
        $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

        //
        $(".todo-list").sortable({
            placeholder: "sort-highlight",
            handle: ".handle",
            forcePlaceholderSize: true,
            zIndex: 999999
        });


        //设置显示和隐藏子菜单
        $(".fa-reorder").on('click', function(){
            var obj = $(this).parent().parent().parent().parent().parent().next();
            if(obj.css("display") == 'none'){
                obj.css("display", "block");
            }else{
                obj.css("display", "none");
            }
        })

        //添加菜单
        $(".fa-plus-square-o").on('click', function(){
            var pid = $(this).attr('k');
            showAddModal(pid);
        })

        //添加菜单
        $(".tab-content .box-footer .btn-default").on('click', function(){
            showAddModal(0);
        })

        //修改菜单
        $(".fa-edit").on('click', function(){
            var data = $(this).attr('k');
            showEditModal(data);
        })

        //修改菜单
        $(".fa-trash-o").on('click', function(){
            var data = $(this).attr('k');
            showDeleteModal(data);
        })

        $('#saveData').on('click', saveData);

        $("#delModal .btn-primary").on('click', function(){
            delData();
        });

        //保存菜单--排序
        $(".tab-content .box-footer .btn-info").on('click', function(){
            setMenuOrder();
        })

        //保存菜单--排序
        $(".tab-content .box-footer .btn-danger").on('click', function(){
            cancelSortOrder();
        })
    }

    //显示添加菜单窗口
    function showAddModal(pid){
        $('#operation').val('add');
        $("#infoModal .box-header h3").html('添加菜单');

        //清空数据
        clearModalData();
        //设置上级菜单
        $("#pid").val(pid);

        //设置菜单类型
        $(".nav-tabs-custom .nav-tabs li").each(function(){
            if($(this).hasClass("active")){
                var menu_type = $(this).attr("k");
                $("#menu_type").val(menu_type);
                $("#menu_type").attr("disabled", true);
                return false;
            }
        })

        //打开模态框
        $('#infoModal').modal({'backdrop' : false});
    }

    //清除数据
    function clearModalData(){
        $("#idArea").css('display', 'none');
        $("#name").val('');
        $("#url").val('');
        $("#menu_type").val(0);
        $("#menu_type").attr("disabled", true);
        $("#pid").val(0);
        $("#target").val(0);
        $(".lang-menu :checkbox").each(function(){
            $(this).removeAttr("checked");
        })

        $('input:radio[name="status"]').eq(0).prop('checked', "checked");

        //初始化pid下拉框的值
        setPidData();

        $('#saveResult').html('');
    }

    //显示编辑菜单窗口
    function showEditModal(data){
        $('#operation').val('edit');
        $("#infoModal .box-header h3").html('修改菜单');

        //设置数据
        setModalData(data)
        //打开模态框
        $('#infoModal').modal({'backdrop' : false});
    }

    //设置模态框数据
    function setModalData(data){
        var obj = $.parseJSON(data);
        $("#menuId").val(obj.id);
        $("#idArea").css('display', 'block');
        $("#idArea").find('label').eq(1).html(obj.id);
        $("#name").val(obj.name);
        $("#url").val(obj.url);
        $("#menu_type").val(obj.menu_type);
        $("#menu_type").attr("disabled", true);
        //初始化pid下拉框的值
        setPidData();

        $("#pid").val(obj.pid);
        //设置上级菜单
        if(obj.pid == 0){
            //一级菜单
            $("#pid").attr("disabled", true);
        }else{
            //二级菜单
            $("#pid").attr("disabled", false);
        }
        $("#target").val(obj.target);
        $(".lang-menu :checkbox").each(function(){
            var lang = $(this).val();
            if(obj.lang.indexOf(lang) != -1){
                $(this).prop('checked', "checked");
            }else{
                $(this).removeAttr("checked");
            }
        })

        if(obj.status == 1){
            $('input:radio[name="status"]').eq(0).prop('checked', "checked");
        }else{
            $('input:radio[name="status"]').eq(1).prop('checked', "checked");
        }

        $('#saveResult').html('');
    }

    //初始化pid下拉框的值
    function setPidData(){
        var data = '<option value="0">请选择</option>';
        //获取菜单类型
        var menu_type = getMenuType();

        var jsonData = '';
        if(menu_type == 1){
            //头部导航菜单
            jsonData = $("#headerMenus").val()
        }else{
            //底部导航菜单
            jsonData = $("#footerMenus").val()
        }

        if(jsonData != ''){
            var obj = $.parseJSON(jsonData);
            $.each(obj, function(i, val) {
                data += '<option value="' + val.id +'">'+ val.name +'</option>';
            });
        }

        $("#pid").html(data);
    }

    //获取菜单类型（当前标签页是头部导航标签还是底部导航标签）
    function getMenuType(){
        var menu_type = 1;
        $(".nav-tabs-custom .nav-tabs li").each(function(){
            if($(this).hasClass("active")){
                menu_type = $(this).attr("k");
                return false;
            }
        })
        return menu_type;
    }

    //获取菜单的顺序
    function getMenuOrder(){
        var arr = new Array();
        var obj = $(".nav-tabs-custom .tab-pane.active input:hidden");
        if(typeof obj == "undefined" || obj.length == 0){
            return arr;
        }

        var i = 1;
        var j = 1;
        obj.each(function(){
            var id = $(this).val();
            var pid = $(this).attr("pid");
            if(pid == 0){
                j = 1;
                arr[id] = i++;
            }else{
                arr[id] = j++;
            }
        })
        return arr;
    }

    //保存菜单的顺序
    function setMenuOrder(){
        var arr = getMenuOrder();
        if(arr.length == 0){
            return false;
        }

        //获取菜单类型
        var menu_type = getMenuType();
        var href_url = '/home/front_menu?menu_type=' + menu_type;

        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            order : arr
        }
        $.ajax({
            type: "put",
            url: "/home/front_menu",
            data: data,
            dataType: "json",
            success: function(respone){
                window.location.href = href_url;
            },
            error: function(){
                window.location.href = href_url;
            }
        });

    }

    //取消菜单的排序
    function cancelSortOrder(){
        //获取菜单类型
        var menu_type = getMenuType();
        var href_url = '/home/front_menu?menu_type=' + menu_type;
        window.location.href = href_url;
    }

    //保存菜单信息
    function saveData(){
        var name = $.trim($("#name").val());
        if(name == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('菜单名称不能为空！');
            return false;
        }

        var url = $.trim($("#url").val());
        if(url == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('URL不能为空！');
            return false;
        }

        var target = $("#target").val();
        if(target == 0){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个显示方式！');
            return false;
        }

        var arr = [];
        var i = 0;
        $(".lang-menu :checkbox").each(function(){
            if($(this).get(0).checked){
                arr[i] = $(this).val();
                i++;
            }
        })

        if(i == 0){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个语言！');
            return false;
        }

        var lang = arr.join(',');

        $("#saveResult").attr("class", 'text-green');
        $("#saveResult").html('保存信息中，请耐心等待...');

        setReadOnly();

        var token = $("[name='_token']").val();
        var status = $('input:radio[name="status"]:checked').val();
        var menu_type = $("#menu_type").val();
        var pid = $("#pid").val();
        var target = $("#target").val();

        var data = {
            _token : token,
            name: name,
            url: url,
            menu_type:menu_type,
            pid: pid,
            target: target,
            lang:lang,
            status: status
        }

        var operation = $("#operation").val();
        if(operation == 'edit'){
            data.id = $("#menuId").val();
        }

        //获取菜单类型
        var menu_type = getMenuType();
        var href_url = '/home/front_menu?menu_type=' + menu_type;

        $.ajax({
            type: "post",
            url: "/home/front_menu",
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
                    $('#infoModal').on('hidden.bs.modal', function (e) {
                        window.location.href = href_url;
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
                            window.location.href = href_url;
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
        $("#infoModal input").attr("disabled",true)
        $("#infoModal button").attr("disabled",true)
        $("#infoModal select").attr("disabled",true)
    }

    function cancelReadOnly(){
        $("#infoModal input").attr("disabled",false)
        $("#infoModal button").attr("disabled",false)
        $("#infoModal select").attr("disabled",false)
        $("#menu_type").attr("disabled", true);
    }

    //展示删除菜单确认窗口
    function showDeleteModal(id){
        $('#delModal').modal({'backdrop' : false});
        $("#delModal :hidden").val(id);
        $("#delModal").find('p').eq(0).html('是否确定要删除该菜单(id=' + id + ')？');
    }

    //删除数据
    function delData(){
        var id = $("#delModal :hidden").val();
        var token = $("[name='_token']").val();
        var data = {
            _token:token,
            id:id
        }

        //获取菜单类型
        var menu_type = getMenuType();
        var href_url = '/home/front_menu?menu_type=' + menu_type;

        $("#delModal button").attr("disabled", true);
        $("#deleteResult").attr("class", 'text-green');
        $('#deleteResult').html('操作进行中，请耐心等待！');

        $.ajax({
            type: "delete",
            url: "/home/front_menu",
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
                        window.location.href = href_url;
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
                            window.location.href = href_url;
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