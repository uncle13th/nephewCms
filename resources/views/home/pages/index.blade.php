@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{asset('/plugins/fancybox/jquery.fancybox.css')}}" type="text/css" media="screen" />
@endsection
@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>页面管理</li>
                    <li class="active"><i class="fa fa-fw fa-user"></i>首页管理</li>
                </ol>
            </div>
        </div>
    </section>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom" style="margin-right: 35px;min-height:400px;">
                <ul class="nav nav-tabs">
                    <li k="1" @if($menu_type == 1) class="active" @endif><a href="#tab_banner" data-toggle="tab" aria-expanded="false">轮播图管理</a></li>
                    <li k="2" @if($menu_type == 2) class="active" @endif><a href="#tab_config" data-toggle="tab" aria-expanded="true">配置管理</a></li>
                </ul>
                <div class="tab-content">
                    <div @if($menu_type == 1) class="tab-pane active connectedSortable" @else class="tab-pane connectedSortable" @endif id="tab_banner">
                        @if(!empty($banners))
                            <?php $index = 1;?>
                            @foreach($banners as $item)
                                <div class="box" style="position: relative; left: 0px; top: 0px;border-top-width:1px;margin-bottom: 0px;">
                                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                                <input type="hidden" pid="0" value="{{$item['id']}}">
                                                <span class="text">#{{$index++}}</span>
                                                <a class="default" target="_blank" href="{{$item['url']}}" title="点击跳转到{{$item['title']}}">{{$item['title']}}</a>
                                            </div>
                                            <div class="col-md-4">
                                                @if(strpos($item['lang'], 'zh_cn') !== false)
                                                    <a class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</a>
                                                @endif
                                                @if(strpos($item['lang'], 'zh_tw') !== false)
                                                    <a class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</a>
                                                @endif
                                                @if(strpos($item['lang'], 'en_us') !== false)
                                                    <a class="label label-default"><i class="fa fa-clock-o"></i>English</a>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                @if($item['status'] == 1)
                                                    <a class="label label-success"><i class="fa fa-clock-o"></i>有效</a>
                                                @else
                                                    <a class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</a>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="box-tools pull-right">
                                                    <a href="#"><i class="fa fa-fw fa-image" k-img="{{$item['img']}}"  k-id="{{$item['id']}}"></i></a>
                                                    <a href="#"><i class="fa fa-edit" k="{{json_encode($item)}}"></i></a>
                                                    <a href="#"><i class="fa fa-trash-o" k="{{$item['id']}}"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-footer clearfix no-border  pull-right" style="display: block;">
                            <button id="addBanner" type="button" class="btn btn-default">新增轮播图</button>
                            <button id="saveSortData" type="button" class="btn btn-info">保存</button>
                            <button type="button" class="btn btn-danger">取消</button>
                        </div>
                    </div>
                    <div @if($menu_type == 2) class="tab-pane active connectedSortable" @else class="tab-pane connectedSortable" @endif  id="tab_config">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">轮播图数量上限</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="bannerNum" placeholder="请填写数字，必须大于0" value="{{$banner_num}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">首页产品的数量</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="indexProductNum" placeholder="请填写数字，必须大于0" value="{{$index_product_num}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer clearfix no-border col-sm-offset-2  " style="display: block;">
                                <button id="saveConfigData" type="button" class="btn btn-info">保存</button>
                                <button type="button" class="btn btn-danger">取消</button>
                        </div>
                        <div class="box-footer clearfix no-border col-sm-offset-2  " style="display: block;">
                            <div class="col-sm-12">
                                <p id="saveConfigResult" class="text-green"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}

    <!-- 模态框 展示图片 -->
    <div id="imageModal" class="modal " tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="box box-info">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="box-title">图片展示</h3>
                </div>
                <div class="form-horizontal">
                    <input type="hidden" id="sourceId" value="0" >
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <img id="imgShow" style="width: 100%; height: 100%;" src="http://nephewcms.com/uploads/test/1.png">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="img" class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input id="img" class="img_src form-control" name="img" type="text" value="" src="">
                                        <span class="input-group-btn">
                                            <a href="/filemanager/dialog.php?type=1&amp;field_id=img" class="btn btn-warning iframe-btn">选择图片</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <div class="col-sm-8">
                                <p id="saveImgResult" class="text-green"></p>
                            </div>
                            <div class="col-sm-4">
                                <button id="saveImgData" class="btn btn-info pull-right">保存</button>
                                <button class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 模态框 新增轮播图/修改轮播图 -->
    <div id="infoModal" class="modal " tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="box box-info">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="box-title">新增轮播图</h3>
                </div>
                <div class="form-horizontal">
                    <input type="hidden" id="bannerId" value="0" >
                    <input type="hidden" id="operation" value="" >
                    <div class="box-body">
                        <div id="idArea" class="form-group" style="display: none;">
                            <label class="col-sm-2 control-label">轮播图ID</label>
                            <label class="col-sm-1 control-label"></label>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">轮播图名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="轮播图名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="url" placeholder="URL">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target" class="col-sm-2 control-label">显示方式</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="target">
                                    <option value="0">请选择</option>
                                    <option value="_self">当前页</option>
                                    <option value="_blank">在新标签页打开</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input id="image" class="img_src form-control" name="image" type="text" value="" src="http://nephewcms.com/uploads/test/1.png">
                                        <span class="input-group-btn">
                                            <a href="/filemanager/dialog.php?type=1&amp;field_id=image" class="btn btn-warning iframe-btn">选择图片</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">语言</label>
                            <div class="col-sm-10 lang-menu">
                                <div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="zh_cn">简体中文</label>
                                        <label><input type="checkbox" value="zh_tw">繁体中文</label>
                                        <label><input type="checkbox" value="en_us">English</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="radio col-sm-12">
                                        <label>
                                            <input type="radio" name="status" value="1" checked="">
                                            有效
                                        </label>

                                        <label style="margin-left: 10px;">
                                            <input type="radio" name="status" value="0">
                                            隐藏
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <div class="col-sm-8">
                                <p id="saveResult" class="text-green"></p>
                            </div>
                            <div class="col-sm-4">
                                <button id="saveBannerData" class="btn btn-info pull-right">保存</button>
                                <button class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 模态框 删除轮播图 -->
    <div id="delModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="box box-danger">
                <div class="modal-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除轮播图</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="0" >
                    <p>是否确定要删除该轮播图？</p>
                </div>
                <div class="box-footer">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <div class="col-sm-8">
                            <p id="deleteResult" class="text-green"></p>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary pull-right">确定</button>
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

    <script src="{{asset('/plugins/JQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{asset('/js/home/pages/index.js')}}"></script>
@endsection