@extends('layouts.main')

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
    <?php $i = 1; $sort = [];?>
    <section class="content">
        {{--<div class="row">--}}
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">产品列表</h3>
                    <div class="box-tools pull-right">
                        <div class="input-group input-group-sm" style="width: 750px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn" style="width: 100px; background-color: #a0a9dd" >产品类型</button>
                            </div>
                            <select id="type" class="form-control">
                                @if(!empty($types))
                                    @foreach($types as $id=>$name)
                                        <option value="{{$id}}" @if($type_id == $id) selected @endif>{{$name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="input-group-btn" style="padding-left: 20px;">
                                <button type="button" class="btn bg-purple" style="width: 100px;" >产品状态</button>
                            </div>
                            <select id="status" class="form-control">
                                <option value="-1" @if($status == -1) selected @endif>全部</option>
                                <option value="1" @if($status == 1) selected @endif>有效</option>
                                <option value="0" @if($status == 0) selected @endif>隐藏</option>
                            </select>
                            <div id="searchArea" class="input-group-btn" style="padding-left: 20px;">

                                <button type="button" class="btn btn-warning dropdown-toggle" style="width: 100px;" data-toggle="dropdown"
                                        aria-expanded="false" @if(isset($params['name'])) k="name" @else k="id" @endif>
                                    @if(isset($params['name'])) 产品名称 @else 产品ID @endif
                                    <span class="fa fa-caret-down"></span></button>

                                <ul class="dropdown-menu">
                                    <li k="id"><a>产品ID</a></li>
                                    <li k="name"><a>产品名称</a></li>
                                </ul>
                            </div>
                            <input id="keyword" type="text" class="form-control" placeholder="请输入id或名称"
                            @if(isset($params['id'])) value="{{$params['id']}}" @elseif(isset($params['name'])) value="{{$params['name']}}" @endif >
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
                            <?php $i = 1; ?>
                            @foreach($product_list as $product)
                                <li>
                                    <?php $sort[] = $product['sort']; ?>
                                    <input type="hidden" value="{{$product['id']}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <span class="handle ui-sortable-handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                            <span class="text">[{{$product['id']}}]</span>
                                            <span class="text">{{$product['name']}}</span>
                                        </div>
                                        <div class="col-md-1">
                                            @if(isset($types[$product['type']]))
                                                <small class="label label-default"><i class="fa fa-clock-o"></i>{{$types[$product['type']]}}</small>
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
        <input id="sortData" type="hidden" value="{{json_encode($sort)}}">
        <input id="paramsData" type="hidden" value="{{$jsonParams}}">
        {{ csrf_field() }}

        <!-- 模态框 删除数据 -->
        <div id="delModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-danger">
                    <div class="modal-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">删除产品</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="delId" value="0" >
                        <p>是否确定要删除该产品？</p>
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
    <script src="{{asset('/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/home/pages/productList.js')}}"></script>
@endsection