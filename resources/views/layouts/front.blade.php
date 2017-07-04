<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>恩凯公司</title>

    <!-- Bootstrap core CSS -->
    <link href="{{url('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{url('plugins/bootstrap-carousel/css/carousel.css')}}">
    <link rel="stylesheet" href="{{url('front/met.css')}}">
</head>
<body>
<nav class="navbar navbar-default  met-nav" role="navigation">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle hamburger hamburger-close collapsed"
                        data-target="#navbar-default-collapse" data-toggle="collapse">
                    <span class="sr-only">导航菜单</span>
                    <span class="hamburger-bar"></span>
                </button>
                <a href="/" class="navbar-brand navbar-logo vertical-align" title="恩凯公司">
                    <h1 class='hide'>恩凯公司</h1>
                    <div class="vertical-align-middle"><img src="{{url('images/mini.logo.png')}}" alt="恩凯公司" title="科技公司" /></div>
                </a>
                <h2 class='hide'></h2>

            </div>
            <div class="collapse navbar-collapse navbar-collapse-toolbar nav-shop" id="navbar-default-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown" style="border-bottom: 5px solid #ffffff;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$system_lang[$lang]}}<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right animate">
                            @foreach($system_lang as $lang_key=>$lang_item)
                            <li><a href="?lang={{$lang_key}}" @if($lang_key == $lang) class="active" @endif >{{$lang_item}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right navlist">
                    @if(!empty($header_menu))
                        @foreach($header_menu as $h_menu)
                            @if(empty($h_menu['children']))
                                <li class="margin-left-40"><a href="{{$h_menu['url']}}"  title="{{$h_menu['name']}}" class="link " target="{{$h_menu['target']}}">{{$h_menu['name']}}</a></li>
                            @else
                                <li class="dropdown margin-left-40" style="border-bottom: 5px solid #ffffff;">
                                    <a
                                            class="dropdown-toggle link "
                                            data-toggle="dropdown"
                                            data-hover="dropdown"
                                            href="{{$h_menu['url']}}"
                                            aria-expanded="false"
                                            title="{{$h_menu['name']}}"
                                            target="{{$h_menu['target']}}"
                                    >{{$h_menu['name']}} <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-right animate">
                                        @foreach($h_menu['children'] as $h_child)
                                        <li><a href="{{$h_child['url']}}" class=""  title="{{$h_child['name']}}" target="{{$h_child['target']}}">{{$h_child['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

@yield('content')

<!-- 底部 -->
<div class="met-footnav text-center">
    <div class="container">
        <div class="row mob-masonry">

            <div class="col-md-2 col-sm-3 col-xs-6 list masonry-item">
                <h4><a href="product/"  title="产品">产品</a></h4>
                <ul>

                    <li><a href="product/product.php?lang=cn&class2=112"  title="智能手表">智能手表</a></li>

                    <li><a href="product/product.php?lang=cn&class2=113"  title="智能眼镜">智能眼镜</a></li>

                    <li><a href="product/product.php?lang=cn&class2=114"  title="机器人">机器人</a></li>

                    <li><a href="product/product.php?lang=cn&class2=118"  title="体感车">体感车</a></li>

                    <li><a href="product/product.php?lang=cn&class2=119"  title="无人机">无人机</a></li>

                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 list masonry-item">
                <h4><a href="service/show.php?lang=cn&id=129"  title="支持">支持</a></h4>
                <ul>

                    <li><a href="service/show.php?lang=cn&id=129"  title="售后政策">售后政策</a></li>

                    <li><a href="download/"  title="相关下载">相关下载</a></li>

                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 list masonry-item">
                <h4><a href="blog/"  title="博客">博客</a></h4>
                <ul>

                    <li><a href="blog/news.php?lang=cn&class2=122"  title="产品资讯">产品资讯</a></li>

                    <li><a href="blog/news.php?lang=cn&class2=123"  title="行业动态">行业动态</a></li>

                    <li><a href="blog/news.php?lang=cn&class2=124"  title="国际资讯">国际资讯</a></li>

                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 list masonry-item">
                <h4><a href="about/show.php?lang=cn&id=125"  title="关于">关于</a></h4>
                <ul>

                    <li><a href="about/show.php?lang=cn&id=125"  title="关于我们">关于我们</a></li>

                    <li><a href="about/show.php?lang=cn&id=126"  title="联系我们">联系我们</a></li>

                    <li><a href="job/"  title="加入我们">加入我们</a></li>

                    <li><a href="feedback/"  title="意见反馈">意见反馈</a></li>

                </ul>
            </div>

            <div class="col-md-3 col-ms-12 col-xs-12 info masonry-item">
                <em><a href="tel:400-000-000" title="400-000-000">400-000-000</a></em>
                <p>周一至周五 08:30~17:30</p>


                <a id="met-weixin"><i class="fa fa-weixin light-green-700" data-plugin="webuiPopover" data-trigger="hover" data-animation="pop" data-placement='top' data-width='160' data-padding='0' data-content="<img src='upload/201605/1464081530.jpg' alt='科技公司网站模板|科技公司企业网站模板-科技公司' style='width: 150px;display:block;margin:auto;'>"></i></a>

                <a href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes" rel="nofollow" target="_blank">
                    <i class="fa fa-qq"></i>
                </a>

                <a href="" rel="nofollow" target="_blank"><i class="fa fa-weibo red-600"></i></a>


            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p>版权所有 © 2008-2017 深圳市恩凯电子有限公司. All rights reserved.</p>
    </div>
</footer>
<button type="button" class="btn btn-icon btn-primary btn-squared met-scroll-top hide"><i class="icon wb-chevron-up" aria-hidden="true"></i></button>




<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.bootcss.com/jquery/1.9.1/jquery.js"></script>
{{--<script src="{{url('plugins/bootstrap-carousel/js/jssor.slider.mini.js')}}"></script>--}}
{{--<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>--}}
<script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
{{--<script src="{{url('front/docs.min.js')}}"></script>--}}
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{url('front/ie10-viewport-bug-workaround.js')}}"></script>
{{--<script src="{{url('js/metinfo.js')}}"></script>--}}
<script src="{{url('front/menu.js')}}"></script>
@yield('java-script')

</body>
</html>