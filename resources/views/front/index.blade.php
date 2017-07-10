@extends('layouts.front')

@section('content')

<div style="min-height: 50px;" class="carousel slide" data-ride="carousel">
    <!-- Jssor Slider Begin -->

    <!-- ================================================== -->
    <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background:url({{asset('plugins/bootstrap-carousel/img/loading.gif')}}) no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>
        <!-- Slides Container -->
        <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
            @if(!empty($banners))
                @foreach($banners as $banner)
            <div>
                <a href="{{$banner['url']}}" target="{{$banner['target']}}"><img u="image" src2="{{$banner['img']}}" /></a>
            </div>
                @endforeach
            @endif
        </div>

        <!--#region Bullet Navigator Skin Begin -->
        <!-- Help: https://www.jssor.com/development/slider-with-bullet-navigator.html -->

        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->

        <!--#region Arrow Navigator Skin Begin -->
        <!-- Help: https://www.jssor.com/development/slider-with-arrow-navigator.html -->

        <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
            </span>
        <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
            </span>
        <!--#endregion Arrow Navigator Skin End -->
    </div>
    <!-- Jssor Slider End -->
</div>


<div class="met-index-product met-index-body met-index-product-other">
    <div class="container">
        <h2 class="" data-plugin="appear" data-animate="slide-top" data-repeat="false">电子配件</h2>
        <p class="desc " data-plugin="appear" data-animate="fade" data-repeat="false">我们致力于改善人们使用电子产品的体验</p>

        <div id="typesArea" class='' data-plugin="appear" data-animate="fade" data-repeat="false">
            <div class="swiper-container swiper-navtab swiper-container-horizontal">
            <ul class="nav nav-tabs">
                @if(!empty($product_types))
                    <?php $i = 1; ?>
                    @foreach($product_types as $product_type)
                        @if(!empty($product_list[$product_type['id']]))
                <li @if($i++ == 1) class="active" @endif>
                    <a href="#indexprolist" title="{{$product_type['name']}}" data-toggle="tab" data-num='8' data-filter="list_{{$product_type['id']}}"><h3>{{$product_type['name']}}</h3></a>
                </li>
                        @endif
                    @endforeach
                 @endif
            </ul>
                <div class="swiper-scrollbar" style="display: none;"><div class="swiper-scrollbar-drag" style="width: 0px;"></div></div>
                </div>
        </div>
        @if(!empty($product_list))
            <?php $j = 0; ?>
        <ul class="blocks-2 blocks-sm-2 blocks-md-4 blocks-xlg-4 no-space" id='indexprolist' data-scale='1'>
            @foreach($product_list as $type_id=>$list)
                @if(!empty($list))
                    <?php  $j++ ?>
                    @foreach($list as $product)
            <li data-type="list_{{$type_id}}" @if($j > 1) style="display: none;" @endif >
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="/product/info?id={{$product['id']}}" title="{{$product['name']}}" target='_self'>
                            <?php
                                $img = '';
                                if(!empty($product['img'])) {
                                    $temp = explode(';', $product['img']);
                                    $img = $temp[0];
                                }
                            ?>
                            <img class="cover-image" src="{{$img}}" style='height:300px;' alt="{{$product['name']}}">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="/product/info?id={{$product['id']}}" title="{{$product['name']}}" target='_self'>{{$product['name']}}</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>2288.00元</p>
                    </h4>
                </div>
            </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
        @endif
    </div>
</div>

<!-- 关于我们 -->

<div class="met-index-about met-index-body" style="padding-top: 0px;padding-bottom: 70px;">
    <div class="container">
        <h2 data-plugin="appear" data-animate="slide-top" data-repeat="false">关于我们</h2>
        <p class="desc" data-plugin="appear" data-animate="fade" data-repeat="false">我们致力于让科技改善人们的生活</p>
        <div class="met-editor no-gallery lazyload clearfix" data-plugin="appear" data-animate="slide-bottom10" data-repeat="false">
            <p>
                <img class="" height="200" data-original="http://show.metinfo.cn/muban/res013/323/upload/201605/1464245734139534.jpg" title="1464245734139534.jpg" alt="56f8e7bf65a3f.jpg" src="http://show.metinfo.cn/muban/res013/323/upload/201605/1464245734139534.jpg" style="display: inline;">
            </p>
            <hr/><p>某科技公司是一个诞生于2013年机器人浪潮来袭前际，总部位于“硬件之都”中国深圳。</p><p>我们是一群热衷于智能机器人的极客、设计师和发烧友，对未来充满无限创想、野心和激情。“在最好的时光里，撒野去”是我们所倡导的品牌文化，号召属于这个时代的年轻人，不羁束缚、随心逐梦！</p><p>比普通创客幸运一些的是，我们成立之初，就在语义技术、图数据管理和供应链方面拥有比较丰富的经验和积累，并且、汇聚整合了完善的生产链条和多元的渠道资源，我们愿意拥抱大胆有趣的产品理念，为用户创造更多的惊喜！</p>
        </div>
    </div>
</div>

@endsection

@section('java-script')
<!-- jssor slider scripts-->
<script type="text/javascript" src="/plugins/bootstrap-carousel/js/jssor.slider.mini.js"></script>
<script type="text/javascript" src="front/index.js"></script>
@endsection
