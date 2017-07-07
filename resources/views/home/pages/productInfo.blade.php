@extends('layouts.main')
{{--@section('css')--}}
{{--<link rel="stylesheet" href="{{asset('/plugins/fancybox/jquery.fancybox.css')}}" type="text/css" media="screen" />--}}
{{--@endsection--}}

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>页面管理</li>
                    <li class="active"><i class="fa fa-fw fa-user"></i>产品列表管理</li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <button id="addData" class="btn btn-info pull-right"><span class="fa fa-fw fa-plus-circle"></span>新增产品</button>
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
                    <h3 class="box-title">产品列表</h3>
                    <div class="box-tools pull-right">
                        <div class="input-group input-group-sm" style="width: 550px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn bg-purple" style="width: 100px;" >产品类型</button>
                            </div>
                            {{--<input id="keyword" type="text" class="form-control" placeholder="请输入id或名称" >--}}
                            <select class="form-control">
                                @if(!empty($types))
                                    @foreach($types as $type)
                                <option value="{{$type['id']}}" @if($type_id == $type['id']) selected @endif>{{$type['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div id="searchArea" class="input-group-btn" style="padding-left: 20px;">
                                <button type="button" class="btn btn-warning dropdown-toggle" style="width: 100px;" data-toggle="dropdown" aria-expanded="false" k="id">产品ID
                                    <span class="fa fa-caret-down"></span></button>
                                <ul class="dropdown-menu">
                                    <li k="id"><a>产品ID</a></li>
                                    <li k="name"><a>产品名称</a></li>
                                </ul>
                            </div>
                            <input id="keyword" type="text" class="form-control" placeholder="请输入id或名称" >
                            <div class="input-group-btn">
                                <button id="search" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="todo-list ui-sortable" style="overflow: hidden;">
                        <li style="background-color: #f5d8d8;">
                            <input type="hidden" value="0">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="text">[产品ID]</span>
                                    <span class="text">产品名称</span>
                                </div>
                                <div class="col-md-1">
                                    <span class="text">类型</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="text">语言</span>
                                </div>
                                <div class="col-md-1">
                                    <span class="text">状态</span>
                                </div>
                                <div class="col-md-2">
                                    <div class="tools" style="display:block">
                                        <span class="text">操作</span>
                                    </div>
                                </div>
                            </div>
                        </li>


                        @if(!empty($product_list))
                            <?php $i=1; ?>
                            @foreach($product_list as $product)
                                <li>
                                    <input type="hidden" value="{{$product['id']}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <span class="handle ui-sortable-handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                            {{--<span class="text">#{{$i++}}</span>--}}
                                            <span class="text">[{{$product['id']}}]</span>
                                            <span class="text">{{$product['name']}}</span>
                                            {{--<a class="default" target="_blank" href="#" title="点击跳转到{{$type['name']}}">{{$type['name']}}</a>--}}
                                        </div>
                                        <div class="col-md-1">
                                            @if(isset($types[$product['type']]))
                                                <small class="label label-default"><i class="fa fa-clock-o"></i>{{$types[$product['type']]['name']}}</small>
                                            @else
                                                <small class="label label-default"><i class="fa fa-clock-o"></i>其他</small>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if(strpos($product['lang'], 'zh_cn') !== false)
                                                <small class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</small>
                                            @endif
                                            @if(strpos($product['lang'], 'zh_tw') !== false)
                                                <small class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</small>
                                            @endif
                                            @if(strpos($product['lang'], 'en_us') !== false)
                                                <small class="label label-default"><i class="fa fa-clock-o"></i>English</small>
                                            @endif
                                        </div>
                                        <div class="col-md-1">
                                            @if($product['status'] == 1)
                                                <small class="label label-success"><i class="fa fa-clock-o"></i>有效</small>
                                            @else
                                                <small class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</small>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="tools" style="display:block">
                                                <i class="fa fa-edit" k="{{$product['id']}}"></i>
                                                <i class="fa fa-trash-o" k="{{$product['id']}}"></i>
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
                                <label class="col-sm-2 control-label">类型ID</label>
                                <label class="col-sm-1 control-label"></label>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">类型名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="类型名称">
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
                                <label for="show" class="col-sm-2 control-label">在首页展示</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <div class="radio col-sm-12">
                                            <label>
                                                <input type="radio" name="show" value="1" checked="">
                                                展示
                                            </label>

                                            <label style="margin-left: 10px;">
                                                <input type="radio" name="show" value="0">
                                                隐藏
                                            </label>
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
                        <h4 class="modal-title">删除产品类型</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="delId" value="0" >
                        <p>是否确定要删除该产品类型？</p>
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
    {{--<script src="{{asset('/plugins/fancybox/jquery.fancybox.js')}}"></script>--}}
    <script src="{{asset('/plugins/JQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/home/pages/productList.js')}}"></script>

@endsection