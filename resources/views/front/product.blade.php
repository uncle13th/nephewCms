@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('/plugins/pic_tab/pic_tab.css')}}" type="text/css"/>
@endsection

@section('content')

    <div class="met-position  pattern-show">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="/" title="首页">
                            <i class="icon wb-home" aria-hidden="true"></i>首页
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="/product/list"
                           title="产品"
                           class="dropdown-toggle"
                           data-toggle="dropdown"
                           aria-expanded="false"
                        >产品 <i class="caret"></i></a>
                        <ul class="dropdown-menu animate">
                            @if(!empty($product_types))
                                @foreach($product_types as $type)
                            <li><a href="/product/list?type={{$type['id']}}"  title="{{$type['name']}}">{{$type['name']}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="/product/list?type={{$product_type}}" title="{{$type_name}}">
                            {{$type_name}}
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="page met-showproduct pagetype1 animsition">

        <div class="met-showproduct-head">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="ban" id="demo1" style="margin-top: 0px;">
                            <div class="ban2" id="ban_pic1">
                                <div class="prev1" id="prev1"><img src="/plugins/pic_tab/index_tab_l.png" width="28" height="51"  alt=""/></div>
                                <div class="next1" id="next1"><img src="/plugins/pic_tab/index_tab_r.png" width="28" height="51"  alt=""/></div>
                                <ul>
                                    <li><a href="javascript:;"><img src="http://nephewcms.com/uploads/zhinengshoubiao/znsb-1.jpg" width="500" height="500" alt=""/></a></li>
                                    <li><a href="javascript:;"><img src="http://nephewcms.com/uploads/zhinengshoubiao/znsb-2.jpg" width="500" height="500" alt=""/></a></li>
                                    <li><a href="javascript:;"><img src="images/b3.jpg" width="500" height="500" alt=""/></a></li>
                                    <li><a href="javascript:;"><img src="images/b4.jpg" width="500" height="500" alt=""/></a></li>
                                    <li><a href="javascript:;"><img src="images/b5.jpg" width="500" height="500" alt=""/></a></li>
                                </ul>
                            </div>
                            <div class="min_pic">
                                <div class="prev_btn1" id="prev_btn1"><img src="/plugins/pic_tab/feel3.png" width="9" height="18"  alt=""/></div>
                                <div class="num clearfix" id="ban_num1">
                                    <ul>
                                        <li><a href="javascript:;"><img src="http://nephewcms.com/uploads/zhinengshoubiao/znsb-1.jpg" width="78" height="78" alt=""/></a></li>
                                        <li><a href="javascript:;"><img src="http://nephewcms.com/uploads/zhinengshoubiao/znsb-2.jpg" width="78" height="78" alt=""/></a></li>
                                        <li><a href="javascript:;"><img src="/plugins/pic_tab/s1.jpg" width="78" height="78" alt=""/></a></li>
                                        <li><a href="javascript:;"><img src="/plugins/pic_tab/s1.jpg" width="78" height="78" alt=""/></a></li>
                                        <li><a href="javascript:;"><img src="images/s5.jpg" width="80" height="80" alt=""/></a></li>
                                    </ul>
                                </div>
                                <div class="next_btn1" id="next_btn1"><img src="/plugins/pic_tab/feel4.png" width="9" height="18"  alt=""/></div>
                            </div>
                        </div>
                        <div class="mhc"></div>
                    </div>
                    {{--<div class="col-md-7">--}}
                        {{--<div class='met-showproduct-list fnGallery text-center slick-dotted' id="met-imgs-carousel">--}}
                            {{--<button type="button" class="slick-prev slick-arrow" style="display: block;"><i class="icon pe-angle-left vertical-align-middle"></i></button>--}}
                            {{--<div aria-live="polite" class="slick-list draggable">--}}
                                {{--<div class="slick-track" role="listbox" style="opacity: 1; width: 3918px; transform: translate3d(-2612px, 0px, 0px);">--}}
                            {{--@if(!empty($product_info))--}}
                                {{--@foreach($product_info['img'] as $img)--}}
                            {{--<div class='slick-slide lg-item-box' data-src="" data-exthumbimage="{{$img}}">--}}
                            {{--<span>--}}
                                {{--<img src="{{$img}}" class="img-responsive" alt="{{$product_info['name']}}" />--}}
                            {{--</span>--}}
                            {{--</div>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<button type="button" class="slick-next slick-arrow" style="display: block;"><i class="icon pe-angle-right vertical-align-middle"></i></button>--}}
                            {{--<ul class="slick-dots" role="tablist" style="display: block;">--}}
                                {{--<div role="toolbar" style="width: 286px;">--}}
                                    {{--<li class="" aria-hidden="true" role="presentation" aria-selected="true" aria-controls="navigation00" id="slick-slide00">--}}
                                        {{--<img src="../include/thumb.php?dir=../upload/201605/1463972218.jpg&amp;x=400&amp;y=400" alt="儿童手表">--}}
                                    {{--</li>--}}
                                    {{--<li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation01" id="slick-slide01" class="">--}}
                                        {{--<img src="../include/thumb.php?dir=../upload/201605/1463972203.jpg&amp;x=400&amp;y=400" alt="儿童手表">--}}
                                    {{--</li>--}}
                                    {{--<li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation02" id="slick-slide02" class="">--}}
                                        {{--<img src="../include/thumb.php?dir=../upload/201605/1463972133.jpg&amp;x=60&amp;y=60" alt="儿童手表">--}}
                                    {{--</li>--}}
                                    {{--<li aria-hidden="false" role="presentation" aria-selected="false" aria-controls="navigation03" id="slick-slide03" class="slick-active">--}}
                                        {{--<img src="../include/thumb.php?dir=../upload/201605/1463971739.jpg&amp;x=60&amp;y=60" alt="儿童手表">--}}
                                    {{--</li>--}}
                                {{--</div>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="col-md-5 product-intro">
                        <h1>Apple Watch Sport</h1>

                        <script>var stockjson = [{"id":"1028","pid":"48","price":"2688","valuelist":"黄色,42毫米","stock":"959","sales":"0","price_str":"2688.00元"},{"id":"1027","pid":"48","price":"2288","valuelist":"黄色,38毫米","stock":"990","sales":"0","price_str":"2288.00元"},{"id":"1026","pid":"48","price":"2688","valuelist":"橙色,42毫米","stock":"799","sales":"0","price_str":"2688.00元"},{"id":"1025","pid":"48","price":"2288","valuelist":"橙色,38毫米","stock":"993","sales":"0","price_str":"2288.00元"},{"id":"1024","pid":"48","price":"2688","valuelist":"宝蓝色,42毫米","stock":"992","sales":"0","price_str":"2688.00元"},{"id":"1023","pid":"48","price":"2288","valuelist":"宝蓝色,38毫米","stock":"990","sales":"0","price_str":"2288.00元"},{"id":"1022","pid":"48","price":"2688","valuelist":"白色,42毫米","stock":"699","sales":"0","price_str":"2688.00元"},{"id":"1021","pid":"48","price":"2288","valuelist":"白色,38毫米","stock":"899","sales":"0","price_str":"2288.00元"},{"id":"1020","pid":"48","price":"2688","valuelist":"黑色,42毫米","stock":"99","sales":"0","price_str":"2688.00元"},{"id":"1019","pid":"48","price":"2288","valuelist":"黑色,38毫米","stock":"999","sales":"0","price_str":"2288.00元"}];</script>
                        <div class="shop-product-intro grey-500">
                            <div class="padding-20 bg-grey-100 price">
                                <span id="price" class="red-600">test</span>
                            </div>

                            <div class="form-group margin-top-15">
                                <label class="control-label font-weight-unset">选择颜色</label>
                                <div class="selectpara-body">

                                    <a href="javascript:;" data-val="黑色" class="selectpara btn btn-squared btn-outline btn-default btn-danger margin-right-10">黑色</a>

                                    <a href="javascript:;" data-val="白色" class="selectpara btn btn-squared btn-outline btn-default  margin-right-10">白色</a>

                                    <a href="javascript:;" data-val="宝蓝色" class="selectpara btn btn-squared btn-outline btn-default  margin-right-10">宝蓝色</a>

                                    <a href="javascript:;" data-val="橙色" class="selectpara btn btn-squared btn-outline btn-default  margin-right-10">橙色</a>

                                    <a href="javascript:;" data-val="黄色" class="selectpara btn btn-squared btn-outline btn-default  margin-right-10">黄色</a>

                                </div>
                            </div>

                            <div class="form-group margin-top-15">
                                <label class="control-label font-weight-unset">表壳尺寸</label>
                                <div class="selectpara-body">

                                    <a href="javascript:;" data-val="38毫米" class="selectpara btn btn-squared btn-outline btn-default btn-danger margin-right-10">38毫米</a>

                                    <a href="javascript:;" data-val="42毫米" class="selectpara btn btn-squared btn-outline btn-default  margin-right-10">42毫米</a>

                                </div>
                            </div>

                            <div class="form-group margin-top-15">
                                <label class="control-label font-weight-unset">数量</label>
                                <div class="width-150 margin-top-5">
                                    <input type="text" class="form-control text-center" data-min="1" data-max="8419" data-plugin="touchSpin" name="buynum" id="buynum" autocomplete="off" value="1">
                                </div>

                                <p class='margin-bottom-0 margin-top-5'>库存 <span id='stock-num' class='hide'>8419</span> 件</p>

                            </div>
                            {{--<div class="form-group margin-top-20 purchase-btn">--}}
                                {{--<a href="http://show.metinfo.cn/muban/res013/323/shop/cart.php?lang=cn&a=dotocart&action=buynow&pid=48" class="btn btn-lg btn-squared btn-danger margin-right-20 product-buynow">立即购买</a>--}}
                                {{--<a href="http://show.metinfo.cn/muban/res013/323/shop/cart.php?lang=cn&a=dotocart&pid=48" class="btn btn-lg btn-squared btn-primary product-tocart"><i class="icon fa-cart-plus font-size-20" aria-hidden="true"></i>加入购物车</a>--}}
                            {{--</div>--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="met-showproduct-body">
            <div class="container">
                <div class="row no-space">
                    <div class="col-md-9 product-content-body">
                        <div class="row">

                            <div class="panel product-detail">
                                <div class="panel-body">
                                    <ul class="nav nav-tabs nav-tabs-line met-showproduct-navtabs affix-nav">
                                        <li class="active"><a data-toggle="tab" href="#product-details" data-get="product-details">详情</a></li>

                                        <li><a data-toggle="tab" href="#product-content1" data-get="product-content1">功能</a></li>

                                        <li><a data-toggle="tab" href="#product-content2" data-get="product-content2">包装</a></li>

                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane met-editor lazyload clearfix animation-fade active" id="product-details">

                                            <ul class="para blocks-2 blocks-md-4">

                                                <li>
                                                    适用人群：儿童，成年人，老年人
                                                </li>

                                                <li>
                                                    商品毛重：255g
                                                </li>

                                                <li>
                                                    商品产地：中国大陆
                                                </li>

                                                <li>
                                                    兼容性：<script language='javascript' src='../include/access.php?metmemberforce=&metuser=para&metaccess=1&lang=cn&listinfo=08efJeymetinfoSzBmetinfoBN09MyK3WYFB3yvaN956QGGmetinfoU1N2metinfometinfo0cSrt4P5metinfoxndfG&paratype=1'></script>
                                                </li>

                                            </ul>

                                            <div><p><img class="imgloading" height="200" data-original="http://show.metinfo.cn/muban/res013/323/upload/201605/1463968457167910.jpg" style="" title="1463968457167910.jpg"/ alt="图片关键词"></p><p><img class="imgloading" height="200" data-original="http://show.metinfo.cn/muban/res013/323/upload/201605/1463968457105651.jpg" style="" title="1463968457105651.jpg"/ alt="图片关键词"></p><p><br/></p><div id="metinfo_additional"></div></div>
                                        </div>

                                        <div class="tab-pane met-editor lazyload clearfix animation-fade" id="product-content1">
                                            <div><ul class=" list-paddingleft-2" style="list-style-type: disc;"><li><p>银色、深空灰色、金色或玫瑰金色阳极氧化铝金属表壳</p></li><li><p>Ion-X 玻璃材质</p></li><li><p>具备 Force Touch 功能的 Retina 显示屏</p></li><li><p>复合材质表背</p></li><li><p>Digital Crown</p></li><li><p>心率传感器、加速感应器和陀螺仪</p></li><li><p>环境光传感器</p></li><li><p>扬声器和麦克风</p></li><li><p>无线网络 (802.11b/g/n 2.4GHz)</p></li><li><p>蓝牙 4.0</p></li><li><p>最长可达 18 小时的电池使用时间*</p></li><li><p>防水**</p></li><li><p>watchOS 2</p></li></ul><div id="metinfo_additional"></div></div>
                                        </div>

                                        <div class="tab-pane met-editor lazyload clearfix animation-fade" id="product-content2">
                                            <div><ul class=" list-paddingleft-2" style="list-style-type: disc;"><li><p>Apple Watch</p></li><li><p>磁性充电线缆 (2 米)</p></li><li><p>USB 电源适配器 (5W)</p></li><li><p>表带 (所含运动型表带可组装成 S/M 或 M/L 的长度)</p></li><li><p>快速入门指南</p></li></ul><div id="metinfo_additional"></div></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--右侧开始-->
                    <div class="col-md-3">
                        <div class="row">
                            <div class="panel product-hot">
                                <div class="panel-body">
                                    <h4 class="example-title">热门推荐</h4>
                                    <ul class="blocks-2 blocks-sm-3 mob-masonry" data-scale='1'>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=48" target="_blank" class="img" title="Apple Watch Sport">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463968649.jpg&x=250&y=250" class="cover-image" style='height:200px;' alt="Apple Watch Sport">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=48" target="_blank" class="txt" title="Apple Watch Sport">Apple Watch Sport</a>
                                            <p class='margin-bottom-0 red-600'>2288.00元</p>
                                        </li>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=27" target="_blank" class="img" title="Gear VR">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463987967.jpg&x=250&y=250" class="cover-image" style='height:200px;' alt="Gear VR">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=27" target="_blank" class="txt" title="Gear VR">Gear VR</a>
                                            <p class='margin-bottom-0 red-600'>1288.00元</p>
                                        </li>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=29" target="_blank" class="img" title="ALPHA 2">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463990444.jpg&x=250&y=250" class="cover-image" style='height:200px;' alt="ALPHA 2">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=29" target="_blank" class="txt" title="ALPHA 2">ALPHA 2</a>
                                            <p class='margin-bottom-0 red-600'>7999.00元</p>
                                        </li>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=31" target="_blank" class="img" title="九号平衡车">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463993502.jpg&x=250&y=250" class="cover-image" style='height:200px;' alt="九号平衡车">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=31" target="_blank" class="txt" title="九号平衡车">九号平衡车</a>
                                            <p class='margin-bottom-0 red-600'>1999.00元</p>
                                        </li>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=32" target="_blank" class="img" title="Phantom 4">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463993829.png&x=250&y=250" class="cover-image" style='height:200px;' alt="Phantom 4">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=32" target="_blank" class="txt" title="Phantom 4">Phantom 4</a>
                                            <p class='margin-bottom-0 red-600'>9999.00元</p>
                                        </li>

                                        <li>
                                            <a href="../product/showproduct.php?lang=cn&id=26" target="_blank" class="img" title="儿童手表">
                                                <img data-original="../include/thumb.php?dir=../upload/201605/1463972218.jpg&x=250&y=250" class="cover-image" style='height:200px;' alt="儿童手表">
                                            </a>
                                            <a href="../product/showproduct.php?lang=cn&id=26" target="_blank" class="txt" title="儿童手表">儿童手表</a>
                                            <p class='margin-bottom-0 red-600'>999.00元</p>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--右侧结束-->

                </div>
            </div>
        </div>
    </div>


@endsection

@section('java-script')

    <script type="text/javascript" src="/plugins/pic_tab/pic_tab.js"></script>
    <script src="{{url('front/product.js')}}"></script>
    <script type="text/javascript">
        jq('#demo1').banqh({
            box:"#demo1",//总框架
            pic:"#ban_pic1",//大图框架
            pnum:"#ban_num1",//小图框架
            prev_btn:"#prev_btn1",//小图左箭头
            next_btn:"#next_btn1",//小图右箭头
            pop_prev:"#prev2",//弹出框左箭头
            pop_next:"#next2",//弹出框右箭头
            prev:"#prev1",//大图左箭头
            next:"#next1",//大图右箭头
//            pop_div:"#demo2",//弹出框框架
//            pop_pic:"#ban_pic2",//弹出框图片框架
//            pop_xx:".pop_up_xx",//关闭弹出框按钮
//            mhc:".mhc",//朦灰层
            autoplay:true,//是否自动播放
            interTime:5000,//图片自动切换间隔
            delayTime:400,//切换一张图片时间
//            pop_delayTime:400,//弹出框切换一张图片时间
            order:0,//当前显示的图片（从0开始）
            picdire:true,//大图滚动方向（true为水平方向滚动）
            mindire:true,//小图滚动方向（true为水平方向滚动）
            min_picnum:5,//小图显示数量
//            pop_up:true//大图是否有弹出框
        })
    </script>
@endsection
