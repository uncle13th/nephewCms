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
                <img class="" height="200" data-original="{{$about_content['img']}}" title="1464245734139534.jpg" alt="关于我们" src="{{$about_content['img']}}" style="display: inline;">
            </p>
            <hr/>
            @if(!empty($about_content['content']))
                @foreach($about_content['content'] as $content)
            <p>{{$content}}</p>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection

@section('java-script')
<!-- jssor slider scripts-->
<script type="text/javascript" src="/plugins/bootstrap-carousel/js/jssor.slider.mini.js"></script>
<script type="text/javascript" src="front/index.js"></script>
@endsection
