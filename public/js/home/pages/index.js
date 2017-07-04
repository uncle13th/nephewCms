$(function() {

    var formType = 1; //1表示是新增或修改轮播图窗口；2表示是预览图片窗口
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

        //添加轮播图
        $(".tab-content .box-footer .btn-default").on('click', function(){
            showAddModal();
        })

        //修改轮播图
        $(".fa-edit").on('click', function(){
            var data = $(this).attr('k');
            showEditModal(data);
        })

        //保存轮播图基础信息
        $('#saveBannerData').on('click', saveBannerData);

        //删除轮播图
        $(".fa-trash-o").on('click', function(){
            var data = $(this).attr('k');
            showDeleteModal(data);
        })

        //确定删除轮播图
        $("#delModal .btn-primary").on('click', function(){
            delData();
        });

        //保存轮播图排序信息
        $('#saveSortData').on('click', saveSortData);

        //取消保存轮播图--排序
        $(".tab-content .box-footer .btn-danger").on('click', function(){
            cancelSortOrder();
        })

        //保存首页配置信息
        $('#saveConfigData').on('click', saveConfigData);

        //保存首页配置信息
        $('#saveImgData').on('click', saveImgData);

        //打开图片预览窗口
        $(".fa-image").on('click', function(){
            var id = $(this).attr('k-id')
            var img = $(this).attr('k-img')
            showImgModal(id, img)
        });

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
                });
                //因为图片选择器关闭时会把模态框一并关闭，所以这里再次打开
                //$('#infoModal').modal({'backdrop' : false});
                afterCloseForm();
            }
        });
    }

    //显示添加菜单窗口
    function showAddModal(){
        $('#operation').val('add');
        $("#infoModal .box-header h3").html('添加轮播图');

        //清空数据
        clearModalData();

        //打开模态框
        formType = 1;
        $('#infoModal').modal({'backdrop' : false});
    }

    //清除数据
    function clearModalData(){
        $("#idArea").css('display', 'none');
        $("#title").val('');
        $("#url").val('');
        $("#target").val(0);
        $("#image").val('');
        $(".lang-menu :checkbox").each(function(){
            $(this).removeAttr("checked");
        })

        $('input:radio[name="status"]').eq(0).prop('checked', "checked");

        $('#saveResult').html('');
    }

    //显示编辑菜单窗口
    function showEditModal(data){
        $('#operation').val('edit');
        $("#infoModal .box-header h3").html('修改轮播图');

        //设置数据
        setModalData(data)
        //打开模态框
        formType = 1;
        $('#infoModal').modal({'backdrop' : false});
    }

    //设置模态框数据
    function setModalData(data){
        var obj = $.parseJSON(data);
        $("#bannerId").val(obj.id);
        $("#idArea").css('display', 'block');
        $("#idArea").find('label').eq(1).html(obj.id);
        $("#title").val(obj.title);
        $("#url").val(obj.url);
        $("#image").val(obj.img);
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

    //获取tab类型（当前标签页是轮播图管理还是首页配置管理）
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

    //保存轮播图的顺序
    function saveSortData(){
        var arr = getMenuOrder();
        if(arr.length == 0){
            return false;
        }

        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;

        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            order : arr
        }
        $.ajax({
            type: "put",
            url: "/home/banner",
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

    //取消轮播图的排序
    function cancelSortOrder(){
        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;
        window.location.href = href_url;
    }

    //保存轮播图信息
    function saveBannerData(){
        var title = $.trim($("#title").val());
        if(title == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('轮播图名称不能为空！');
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

        var img = $.trim($("#image").val());
        if(img == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个图片！');
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
        var target = $("#target").val();

        var data = {
            _token : token,
            title: title,
            url: url,
            img: img,
            target: target,
            lang:lang,
            status: status
        }

        var operation = $("#operation").val();
        if(operation == 'edit'){
            data.id = $("#bannerId").val();
        }

        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;

        $.ajax({
            type: "post",
            url: "/home/banner",
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
    }

    //展示删除菜单确认窗口
    function showDeleteModal(id){
        $('#delModal').modal({'backdrop' : false});
        $("#delModal :hidden").val(id);
        $("#delModal").find('p').eq(0).html('是否确定要删除该轮播图(id=' + id + ')？');
    }

    //删除数据
    function delData(){
        var id = $("#delModal :hidden").val();
        var token = $("[name='_token']").val();
        var data = {
            _token:token,
            id:id
        }

        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;

        $("#delModal button").attr("disabled", true);
        $("#deleteResult").attr("class", 'text-green');
        $('#deleteResult').html('操作进行中，请耐心等待！');

        $.ajax({
            type: "delete",
            url: "/home/banner",
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

    //保存首页配置信息
    function saveConfigData(){
        $("#saveConfigResult").html('');
        var bannerNum = parseInt($("#bannerNum").val());
        if( isNaN(bannerNum) || typeof bannerNum == 'undefined' || bannerNum < 1){
            $("#saveConfigResult").attr("class", 'text-red');
            $("#saveConfigResult").html('轮播图数量上限必须为正整数！');
            return false;
        }

        var indexProductNum = parseInt($("#indexProductNum").val());
        if( isNaN(indexProductNum) || typeof indexProductNum == 'undefined' || indexProductNum < 1){
            $("#saveConfigResult").attr("class", 'text-red');
            $("#saveConfigResult").html('首页产品的数量必须为正整数！');
            return false;
        }

        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;

        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            bannerNum : bannerNum,
            indexProductNum : indexProductNum
        }
        $.ajax({
            type: "put",
            url: "/home/index/config",
            data: data,
            dataType: "json",
            success: function(respone){
                window.location.href = href_url;
            },
            error: function(){
                $("#saveConfigResult").attr("class", 'text-red');
                $("#saveConfigResult").html('操作失败，请重试！');
                return false;
            }
        });
    }

    //展示图片预览窗口
    function showImgModal(id, img){
        //console.log(img);return false;
        $("#sourceId").val(id);
        $("#imgShow").attr('src', img);
        $("#img").val(img);

        //打开模态框
        formType = 2;
        $('#imageModal').modal({'backdrop' : false});
    }

    //图片选择窗口关闭后
    function afterCloseForm(){
        //如果是新增或修改轮播图信息窗口关闭
        if(formType == 1){
            $('#infoModal').modal({'backdrop' : false});
        }else{
            //如果是预览图片窗口的关闭
            var imgValue = $.trim($("#img").val());
            if(imgValue != ''){
                $("#imgShow").attr('src', imgValue);
            }

            $('#imageModal').modal({'backdrop' : false});
        }
    }

    //更新轮播图的图片
    function saveImgData(){
        var imgValue = $.trim($("#img").val());
        if(imgValue == ''){
            $("#saveImgResult").attr("class", 'text-red');
            $("#saveImgResult").html('请选择一张图片！');
            return false;
        }

        var id = $("#sourceId").val();
        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            id : id,
            img : imgValue
        }

        //获取tab类型
        var menu_type = getMenuType();
        var href_url = '/home/index?menu_type=' + menu_type;

        $.ajax({
            type: "put",
            url: "/home/banner/image",
            data: data,
            dataType: "json",
            success: function(respone){
                window.location.href = href_url;
            },
            error: function(){
                $("#saveImgResult").attr("class", 'text-red');
                $("#saveImgResult").html('操作失败，请重试！');
                return false;
            }
        });
    }
});