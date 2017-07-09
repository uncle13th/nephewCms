$(function(){

    var index = 0;

    //初始化
    init();

    //执行一些初始化操作
    function init(){

        index = $("#indexId").val();
        var desc = $("#descId").val();
        if(desc != ''){
            $("#description").val(desc);
        }

        //保存数据--新增或修改数据
        $('#saveData').on('click', saveData);

        //取消按钮
        $('#refreshData').on('click', refreshData);

        //返回上一页
        $('#returnPrev').on('click', returnPrev);

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
            }
        });

        //产品图片--加号（新增一个图片）
        $(".product-img-add").on('click', function(){
            var obj = $(this).parent();
            addImageDiv(obj);
        });

        //产品内容--加号（新增一个图片）
        $(".product-detail-add").on('click', function(){
            var obj = $(this).parent();
            addDetailDiv(obj);
        });

        //产品图片--减号（删除一个图片）
        $(".product-img-del").on('click', function(){
            delImageDiv($(this));
        });

        //产品内容--减号（删除一个内容）
        $(".product-detail-del").on('click', function(){
            delDetailDiv($(this));
        });

    }

    //产品图片--新增一个图片（页面多一个图片选择控件）
    function addImageDiv(obj){
        var src =   '   <div class="col-sm-offset-2 col-sm-6" style="padding-bottom: 15px;">' +
                    '       <img style="width: 510px;min-height: 240px;" class="img-bordered" src="" alt="请点击选择图片按钮来添加图片">' +
                    '       <div class="input-group">' +
                    '           <input id="img' + index + '" class="img_src form-control" name="productImg" type="text" value="" src="" readonly>' +
                    '           <span class="input-group-btn">' +
                    '               <a href="/filemanager/dialog.php?type=1&amp;field_id=img' + index + '" class="btn btn-warning iframe-btn">选择图片</a>' +
                    '           </span>' +
                    '       </div>' +
                    '   </div>' +
                    '   <div class="col-sm-2" style="padding-top:100px;">' +
                    '       <button type="button" class="product-img-del btn btn-danger btn-sm">' +
                    '           <i class="fa fa-minus"></i>' +
                    '       </button>' +
                    '       <button type="button" class="product-img-add btn bg-teal btn-sm">' +
                    '           <i class="fa fa fa-plus"></i>' +
                    '       </button>' +
                    '   </div>';

        index++;

        obj.after(src);
        obj.next().next().find(".product-img-add").on('click', function(){
            addImageDiv($(this).parent());
        })
        obj.next().next().find(".product-img-del").on('click', function(){
            delImageDiv($(this));
        })
    }

    //产品图片--减号（删除一个图片）
    function delImageDiv(obj){
        var len = $("#imageDiv").find('img').length;
        if(len == 1){
            obj.parent().prev().find("img").attr("src", "")
            obj.parent().prev().find("input").val("")
        }else{
            obj.parent().prev().remove();
            obj.parent().remove();
        }

        $("#imageDiv").find("div").eq(0).removeClass("col-sm-offset-2")
    }

    //产品内容--新增一个图片（页面多一个图片选择控件）
    function addDetailDiv(obj){
        var src =   '   <div class="col-sm-offset-2 col-sm-6" style="padding-bottom: 15px;">' +
            '       <img style="width: 510px;min-height: 240px;" class="img-bordered" src="" alt="请点击选择图片按钮来添加图片">' +
            '       <div class="input-group">' +
            '           <input id="detail' + index + '" class="img_src form-control" name="productDetail" type="text" value="" src="" readonly>' +
            '           <span class="input-group-btn">' +
            '               <a href="/filemanager/dialog.php?type=1&amp;field_id=detail' + index + '" class="btn btn-warning iframe-btn">选择图片</a>' +
            '           </span>' +
            '       </div>' +
            '   </div>' +
            '   <div class="col-sm-2" style="padding-top:100px;">' +
            '       <button type="button" class="product-detail-del btn btn-danger btn-sm">' +
            '           <i class="fa fa-minus"></i>' +
            '       </button>' +
            '       <button type="button" class="product-detail-add btn bg-teal btn-sm">' +
            '           <i class="fa fa fa-plus"></i>' +
            '       </button>' +
            '   </div>';

        index++;

        obj.after(src);
        obj.next().next().find(".product-detail-add").on('click', function(){
            addDetailDiv($(this).parent());
        })
        obj.next().next().find(".product-detail-del").on('click', function(){
            delDetailDiv($(this));
        })
    }

    //产品内容--减号（删除一个内容）
    function delDetailDiv(obj){
        var len = $("#detailDiv").find('img').length;
        if(len == 1){
            obj.parent().prev().find("img").attr("src", "")
            obj.parent().prev().find("input").val("")
        }else{
            obj.parent().prev().remove();
            obj.parent().remove();
        }

        $("#detailDiv").find("div").eq(0).removeClass("col-sm-offset-2")
    }

    //保存信息
    function saveData(){
        var name = $.trim($("#name").val());
        if(name == ''){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('产品名称不能为空！');
            return false;
        }

        var type = $("#product_type").val();
        if(type == 0){
            $("#saveResult").attr("class", 'text-red');
            $("#saveResult").html('请选择一个产品类型！');
            return false;
        }

        var description = $.trim($("#description").val());

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
        var status = $('input:radio[name="status"]:checked').val();

        //获取产品图片
        var productImage = '';
        var item = '';
        $("#imageDiv input").each(function(){
            item = $.trim($(this).val());
            if(item != ""){
                if(productImage == ''){
                    productImage += item;
                }else{
                    productImage += ';' + item;
                }
            }
        })

        //获取产品内容
        var productDetail = '';
        item = '';
        $("#detailDiv input").each(function(){
            item = $.trim($(this).val());
            if(item != ""){
                if(productDetail == ''){
                    productDetail += item;
                }else{
                    productDetail += ';' + item;
                }
            }
        })

        var token = $("[name='_token']").val();

        $("#saveResult").attr("class", 'text-green');
        $("#saveResult").html('保存信息中，请耐心等待...');

        var data = {
            _token : token,
            name: name,
            lang:lang,
            status: status,
            description: description,
            type: type,
            img: productImage,
            detail: productDetail
        }

        var operation = $("#operation").val();
        if(operation == 'edit'){
            data.id = $("#dataId").val();
        }

        //跳转链接
        var href_url = '/home/product/list';

        $.ajax({
            type: "post",
            url: "/home/product/info",
            data: data,
            dataType: "json",
            success: function(respone){
                if(respone.code != 200){
                    $("#saveResult").attr("class", 'text-red');
                    $('#saveResult').html(respone.msg);
                }else{
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
            }
        });
    }

    function refreshData(){
        var id = $("#dataId").val();
        if(id == 0){
            window.location.href = '/home/product/info';
        }else{
            window.location.href = '/home/product/info?id=' + id;
        }
    }

    function returnPrev(){
        window.history.go(-1);
    }

});