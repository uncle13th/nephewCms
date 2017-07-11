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
                    <li class="active"><i class="fa fa-fw fa-user"></i>关于我们</li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <button id="addData" class="btn btn-info pull-right"><span class="fa fa-fw fa-plus-circle"></span>新增</button>
            </div>
        </div>
    </section>

@endsection

@section('content')
    <section class="content">
        {{--<div class="row">--}}
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">关于我们页面列表</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="todo-list ui-sortable" style="overflow: hidden;">
                        @if(!empty($list))
                            <?php $i=1; ?>
                            @foreach($list as $item)
                                <li>
                                    <input type="hidden" value="{{$item['id']}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <span class="handle ui-sortable-handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                            <span class="text">#{{$i++}}</span>
                                            <span class="text">{{$item['name']}}</span>
                                        </div>
                                        <div class="col-md-4">
                                            @if(strpos($item['lang'], 'zh_cn') !== false)
                                                <small class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</small>
                                            @endif
                                            @if(strpos($item['lang'], 'zh_tw') !== false)
                                                <small class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</small>
                                            @endif
                                            @if(strpos($item['lang'], 'en_us') !== false)
                                                <small class="label label-default"><i class="fa fa-clock-o"></i>English</small>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            @if($item['status'] == 1)
                                                <small class="label label-success"><i class="fa fa-clock-o"></i>有效</small>
                                            @else
                                                <small class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</small>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="tools" style="display:block">
                                                <i class="fa fa-edit" k="{{json_encode($item)}}"></i>
                                                <i class="fa fa-trash-o" k="{{$item['id']}}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <div class="pull-right">
                        <button type="button" class="btn btn-info">保存</button>
                        <button type="button" class="btn btn-danger">取消</button>
                    </div>
                </div>
            </div>
        </div>
        {{--</div>--}}

        {{ csrf_field() }}

        <!-- 模态框 新增数据/修改数据 -->
        <div id="infoModal" class="modal " tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="box-title">新增类型</h3>
                    </div>
                    <div class="form-horizontal">
                        <input type="hidden" id="dataId" value="0" >
                        <input type="hidden" id="operation" value="" >
                        <div class="box-body">
                            <div id="idArea" class="form-group" style="display: none;">
                                <label class="col-sm-2 control-label">ID</label>
                                <label class="col-sm-1 control-label"></label>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">标识</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="标识（名称），不会在网站上显示的">
                                </div>
                            </div>
                            <div id="imageDiv" class="form-group">
                                <label class="col-sm-2 control-label">产品图片</label>

                                <div class="col-sm-10">
                                    <img id="imageShow" style="width: 100%;height: 128px;" src="" alt="请点击选择图片按钮来添加图片">
                                    <div class="input-group">
                                        <input id="img" class="img_src form-control" name="img" type="text" value="" src="" readonly>
                                    <span class="input-group-btn">
                                        <a href="/filemanager/dialog.php?type=1&amp;field_id=img" class="btn btn-warning iframe-btn">选择图片</a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">内容</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="4" id="description" placeholder="内容" ></textarea>
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
                            <div class="form-group" style="margin-bottom: 0px;">
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
                                    <button id="saveData" class="btn btn-info pull-right">保存</button>
                                    <button class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">取消</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 模态框 删除数据 -->
        <div id="delModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-danger">
                    <div class="modal-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">删除数据</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="delId" value="0" >
                        <p>是否确定要删除该数据？</p>
                    </div>
                    <div class="box-footer">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <div class="col-sm-8">
                                <p id="deleteResult" class="text-green"></p>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-primary pull-right">确定</button>
                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('js')
    <script src="{{asset('/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{asset('/plugins/JQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/home/pages/about.js')}}"></script>

@endsection