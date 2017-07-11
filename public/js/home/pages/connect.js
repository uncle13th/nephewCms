$(function(){

    var href_url = '/home/connect';
    //初始化
    init();

    //执行一些初始化操作
    function init(){

        //设置可以拖拽排序
        setSortable();

        //添加数据
        $("#addData").on('click', showAddModal);

        //保存数据--新增或修改数据
        $('#saveData').on('click', saveData);

        //打开修改数据弹窗
        $(".fa-edit").on('click', function(){
            var data = $(this).attr('k');
            showEditModal(data);
        })

        //打开删除数据弹窗
        $(".fa-trash-o").on('click', function(){
            var data = $(this).attr('k');
            showDeleteModal(data);
        })

        //确定删除数据
        $("#delModal .btn-primary").on('click', function(){
            delData();
        });

        //保存排序数据
        $(".box-primary .box-footer .btn-info").on('click', function(){
            saveSortData();
        })

        //取消排序数据--刷新页面
        $(".box-primary .box-footer .btn-danger").on('click', function(){
            cancelSortData();
        })

        //选择图片
        $('.iframe-btn').fancybox({
            'type'		: 'iframe',
            'autoSize'  : false,
            beforeLoad : function() {
                this.width  = 900;
                this.height = 600;
            },
            afterClose: function() {
                $('.img_src').each(function() {
                    $('#'+$(this).attr('id').replace('source', 'image')).attr("src", $(this).val());
                    $('#'+$(this).attr('id')).parent().prev().attr('src', $(this).val());
                });
                //因为modal会被关闭，所以在此打开
                $('#infoModal').modal({'backdrop' : false});
            }
        });
    }

    //设置可以拖拽排序
    function setSortable(){
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
    }

    //打开添加数据弹窗
    function showAddModal(){
        $('#operation').val('add');
        $("#infoModal .box-header h3").html('新增');
        clearModalData();
        $('#infoModal').modal({'backdrop' : false});
    }

    //清空模态框上所有数据
    function clearModalData(){
        $("#idArea").css('display', 'none');
        $("#name").val('');
        $("#description").val('');
        $("#imageShow").attr('src', "");
        $("#img").val('');

        $(".lang-menu :checkbox").each(function(){
            $(this).removeAttr("checked");
        })

        $('input:radio[name="show"]').eq(0).prop('checked', "checked");
        $('input:radio[name="status"]').eq(0).prop('checked', "checked");

        $('#saveResult').html('');
    }

    //修改数据
    function showEditModal(data){
        $('#operation').val('edit');
        $("#infoModal .box-header h3").html('修改');
        setModalData(data);
        $('#infoModal').modal({'backdrop' : false});
    }

    //设置模态框各个字段信息（编辑）
    function setModalData(data){

        var obj = $.parseJSON(data);
        $("#dataId").val(obj.id);
        $("#idArea").find('label').eq(1).html(obj.id);
        $("#idArea").css('display', 'block');
        $("#name").val(obj.name);

        $(".lang-menu :checkbox").each(function(){
            var lang = $(this).val();
            if(obj.lang.indexOf(lang) != -1){
                $(this).prop('checked', "checked");
            }else{
                $(this).removeAttr("checked");
            }
        })

        $("#description").val(obj.description);
        $("#imageShow").attr('src', obj.img);
        $("#img").val(obj.img);

        if(obj.status == 1){
            $('input:radio[name="status"]').eq(0).prop('checked', "checked");
        }else{
            $('input:radio[name="status"]').eq(1).prop('checked', "checked");
        }

        $('#saveResult').html('');
    }

    //保存信息
    function saveData(){
        var name = $.trim($("#name").val());
        if(name == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('标识名称不能为空！');
            return false;
        }

        var img = $.trim($("#img").val());
        if(img == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个图片！');
            return false;
        }

        var description = $.trim($("#description").val());
        if(description == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('内容不能为空！');
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

        var data = {
            _token : token,
            name: name,
            lang:lang,
            status: status,
            img: img,
            description: description
        }

        var operation = $("#operation").val();
        if(operation == 'edit'){
            data.id = $("#dataId").val();
        }

        $.ajax({
            type: "post",
            url: "/home/connect",
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
    }

    function cancelReadOnly(){
        $("#infoModal input").attr("disabled",false)
        $("#infoModal button").attr("disabled",false)
    }

    //展示删除确认窗口
    function showDeleteModal(data){
        $('#delModal').modal({'backdrop' : false});
        $("#delModal :hidden").val(data);
        $("#delModal").find('p').eq(0).html('是否确定要删除该数据(id=' + data + ')？');
    }

    //删除数据
    function delData(){
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
            url: "/home/connect",
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
                    $('#delModal').on('hidden.bs.modal', function (e) {
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

    //获取排序的顺序
    function getSortOrder(){
        var arr = new Array();
        var obj = $(".box-primary input:hidden");
        if(typeof obj == "undefined" || obj.length == 0){
            return arr;
        }

        var i = 1;
        obj.each(function(){
            var id = $(this).val();
            arr[id] = i++;

        })
        return arr;
    }

    //保存产品类型的排序顺序
    function saveSortData(){
        var arr = getSortOrder();
        if(arr.length == 0){
            return false;
        }

        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            order : arr
        }
        $.ajax({
            type: "put",
            url: "/home/connect",
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

    //取消产品类型的排序
    function cancelSortData(){
        window.location.href = href_url;
    }
});