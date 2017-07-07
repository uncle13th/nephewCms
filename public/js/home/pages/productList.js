$(function(){

    //初始化
    init();

    //执行一些初始化操作
    function init(){

        //设置可以拖拽排序
        setSortable();
        //初始化查询条件
        setSearchOption();

        //设置搜索事件处理
        $("#search").on('click', search)

        //新增产品
        $("#addData").on('click', function(){
            window.location.href = '/home/product/info';
        });

        //修改产品信息
        $(".fa-edit").on('click', function(){
            var id = $(this).attr('k');
            window.location.href = '/home/product/info?id='+id;
        });

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
            refreshPage();
        })
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

    //初始化查询条件
    function setSearchOption(){
        $("#searchArea ul li ").click(function(){
            $("#searchArea button").html($(this).text()+'<span class="fa fa-caret-down"></span>');
            $("#searchArea button").attr('k', $(this).attr('k'));
        });
    }

    //查找数据
    function search(){
        var keyword = $("#keyword").val();
        var key = $("#searchArea button").attr('k');

        var type_id = $("#type").val();
        var status = $("#status").val();

        var url = '/home/product/list?type=' + type_id + '&status=' + status;
        if(keyword != ""){
            url += '&' + key + '=' + keyword;
        }
        window.location.href = url;
    }

    //展示删除确认窗口
    function showDeleteModal(data){
        $('#delModal').modal({'backdrop' : false});
        $("#delModal :hidden").val(data);
        $("#delModal").find('p').eq(0).html('是否确定要删除该产品(id=' + data + ')？');
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
            url: "/home/product/list",
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
                        window.location.href = '/home/product/list';
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
                            window.location.href = '/home/product/list';
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
        var temp = $.trim($("#sortData").val());
        if(temp == ""){
            return arr;
        }
        var originSortData = $.parseJSON(temp);

        var obj = $(".box-primary input:hidden");
        if(typeof obj == "undefined" || obj.length == 0){
            return arr;
        }

        var i = 0;
        obj.each(function(){
            var id = $(this).val();
            if(id != 0) {
                arr[id] = originSortData[i];
                i++;
            }
        })
        return arr;
    }

    //保存产品类型的排序顺序
    function saveSortData(){

        var arr = getSortOrder();
        if(arr.length == 0){
            return false;
        }

        var href_url = '/home/product/list';

        var token = $("[name='_token']").val();
        var data = {
            _token : token,
            order : arr
        }
        $.ajax({
            type: "put",
            url: "/home/product/list",
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

    function refreshPage(){
        //获取参数
        var params = $.trim($("#paramsData").val());

        //页面标刷新
        var href_url = '/home/product/list' + params;
        window.location.href = href_url;
    }
});