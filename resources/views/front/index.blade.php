@extends('layouts.front')

@section('content')

<div style="min-height: 50px;" class="carousel slide" data-ride="carousel">
    <!-- Jssor Slider Begin -->

    <!-- ================================================== -->
    <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('plugins/bootstrap-carousel/img/loading.gif') no-repeat 50% 50%; background-color: rgba(0, 0, 0, .7);"></div>
        <!-- Slides Container -->
        <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <div>
                <img u="image" src2="images/01.jpg" />
            </div>
            <div>
                <img u="image" src2="images/02.jpg" />
            </div>
            <div>
                <img u="image" src2="images/03.jpg" />
            </div>
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
        <a style="display: none" href="https://www.jssor.com">Bootstrap Carousel</a>
    </div>
    <!-- Jssor Slider End -->
</div>


<div class="met-index-product met-index-body met-index-product-other">
    <div class="container">
        <h2 class="" data-plugin="appear" data-animate="slide-top" data-repeat="false">电子配件</h2>
        <p class="desc " data-plugin="appear" data-animate="fade" data-repeat="false">我们致力于改善人们使用电子产品的体验</p>

        <div class='' data-plugin="appear" data-animate="fade" data-repeat="false">
            <div class="swiper-container swiper-navtab swiper-container-horizontal">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#indexprolist" title="全部" data-toggle="tab" data-num='8' data-filter="*"><h3>全部</h3></a>
                </li>

                <li>
                    <a href="#indexprolist" title="智能手表" data-toggle="tab" data-filter="list_112"><h3>智能手表</h3></a>
                </li>

                <li>
                    <a href="#indexprolist" title="智能眼镜" data-toggle="tab" data-filter="list_113"><h3>智能眼镜</h3></a>
                </li>

                <li>
                    <a href="#indexprolist" title="机器人" data-toggle="tab" data-filter="list_114"><h3>机器人</h3></a>
                </li>

                <li>
                    <a href="#indexprolist" title="体感车" data-toggle="tab" data-filter="list_118"><h3>体感车</h3></a>
                </li>

                <li>
                    <a href="#indexprolist" title="无人机" data-toggle="tab" data-filter="list_119"><h3>无人机</h3></a>
                </li>

            </ul>
                <div class="swiper-scrollbar" style="display: none;"><div class="swiper-scrollbar-drag" style="width: 0px;"></div></div>
                </div>
        </div>
        <ul class="blocks-2 blocks-sm-2 blocks-md-4 blocks-xlg-4 no-space" id='indexprolist' data-scale='1'>

            <li data-type="list_112">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=48" title="Apple Watch Sport" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="Apple Watch Sport">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=48" title="Apple Watch Sport" target='_self'>Apple Watch Sport</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>2288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_112">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=26" title="儿童手表" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="儿童手表">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=26" title="儿童手表" target='_self'>儿童手表</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_112">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=51" title="公子小白" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="公子小白">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=51" title="公子小白" target='_self'>公子小白</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1880.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_112">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=47" title="Gear VR" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="Gear VR">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=47" title="Gear VR" target='_self'>Gear VR</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_113">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=27" title="Gear VR" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="Gear VR">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=27" title="Gear VR" target='_self'>Gear VR</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_113">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=56" title="Apple Watch Sport" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="Apple Watch Sport">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=56" title="Apple Watch Sport" target='_self'>Apple Watch Sport</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>2288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_113">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=28" title="Pico Neo" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="Pico Neo">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=28" title="Pico Neo" target='_self'>Pico Neo</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>3399.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_113">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=52" title="ALPHA 2" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="ALPHA 2">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=52" title="ALPHA 2" target='_self'>ALPHA 2</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>7999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_114" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=29" title="ALPHA 2" target='_self'>
                            <img class="cover-image" src="images/shoubiao.jpg" style='height:300px;' alt="ALPHA 2">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=29" title="ALPHA 2" target='_self'>ALPHA 2</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>7999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_114" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=39" title="Gear VR" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463987967.jpg&x=400&y=400" style='height:300px;' alt="Gear VR">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=39" title="Gear VR" target='_self'>Gear VR</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_114" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=37" title="儿童手表" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463972218.jpg&x=400&y=400" style='height:300px;' alt="儿童手表">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=37" title="儿童手表" target='_self'>儿童手表</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_114" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=36" title="ALPHA 2" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463990444.jpg&x=400&y=400" style='height:300px;' alt="ALPHA 2">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=36" title="ALPHA 2" target='_self'>ALPHA 2</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>7999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_118" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=31" title="九号平衡车" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463993502.jpg&x=400&y=400" style='height:300px;' alt="九号平衡车">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=31" title="九号平衡车" target='_self'>九号平衡车</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_118" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=30" title="公子小白" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463992341.jpg&x=400&y=400" style='height:300px;' alt="公子小白">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=30" title="公子小白" target='_self'>公子小白</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1880.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_118" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=40" title="Apple Watch Sport" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463968649.jpg&x=400&y=400" style='height:300px;' alt="Apple Watch Sport">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=40" title="Apple Watch Sport" target='_self'>Apple Watch Sport</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>2288.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_118" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=38" title="Pico Neo" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463989303.jpg&x=400&y=400" style='height:300px;' alt="Pico Neo">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=38" title="Pico Neo" target='_self'>Pico Neo</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>3399.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_119" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=32" title="Phantom 4" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463993829.png&x=400&y=400" style='height:300px;' alt="Phantom 4">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=32" title="Phantom 4" target='_self'>Phantom 4</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>9999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_119" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=49" title="Phantom 4" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463993829.png&x=400&y=400" style='height:300px;' alt="Phantom 4">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=49" title="Phantom 4" target='_self'>Phantom 4</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>9999.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_119" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=43" title="公子小白" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463992341.jpg&x=400&y=400" style='height:300px;' alt="公子小白">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=43" title="公子小白" target='_self'>公子小白</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>1880.00元</p>
                    </h4>
                </div>
            </li>

            <li data-type="list_119" style="display:none;">
                <div class="widget widget-shadow " data-plugin="appear" data-animate="slide-bottom50" data-repeat="false">
                    <figure class="widget-header cover">
                        <a href="product/showproduct.php?lang=cn&id=54" title="Pico Neo" target='_self'>
                            <img class="cover-image" data-original="include/thumb.php?dir=upload/201605/1463989303.jpg&x=400&y=400" style='height:300px;' alt="Pico Neo">
                        </a>
                    </figure>
                    <h4 class="widget-title">
                        <a href="product/showproduct.php?lang=cn&id=54" title="Pico Neo" target='_self'>Pico Neo</a>
                        <p class='margin-bottom-0 margin-top-5 red-600'>3399.00元</p>
                    </h4>
                </div>
            </li>

        </ul>

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
