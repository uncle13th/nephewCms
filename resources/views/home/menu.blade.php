@extends('layouts.main')

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>系统管理</li>
                    <li class="active"><i class="fa fa-fw fa-user"></i>导航菜单管理</li>
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
                    <li k="1" @if($menu_type == 1) class="active" @endif><a href="#tab_nav" data-toggle="tab" aria-expanded="false">头部导航菜单</a></li>
                    <li k="2" @if($menu_type == 2) class="active" @endif><a href="#tab_footer" data-toggle="tab" aria-expanded="true">底部导航菜单</a></li>
                </ul>
                <div class="tab-content">
                    <div @if($menu_type == 1) class="tab-pane active connectedSortable" @else class="tab-pane connectedSortable" @endif id="tab_nav">
                        @if(!empty($h_menus))
                            <?php $index = 1;?>
                            @foreach($h_menus as $menu)
                                <div class="box" style="position: relative; left: 0px; top: 0px;border-top-width:1px;margin-bottom: 0px;">
                                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                                <input type="hidden" pid="0" value="{{$menu['id']}}">
                                                <span class="text">#{{$index++}}</span>
                                                <a class="default" target="_blank" href="{{$menu['url']}}" title="点击跳转到{{$menu['name']}}">{{$menu['name']}}</a>
                                            </div>
                                            <div class="col-md-4">
                                                @if(strpos($menu['lang'], 'zh_cn') !== false)
                                                    <a class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</a>
                                                @endif
                                                @if(strpos($menu['lang'], 'zh_tw') !== false)
                                                    <a class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</a>
                                                @endif
                                                @if(strpos($menu['lang'], 'en_us') !== false)
                                                    <a class="label label-default"><i class="fa fa-clock-o"></i>English</a>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                @if($menu['status'] == 1)
                                                    <a class="label label-success"><i class="fa fa-clock-o"></i>有效</a>
                                                @else
                                                    <a class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</a>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="box-tools pull-right">
                                                    @if(isset($menu['children']) && !empty($menu['children']))
                                                        <a href="#"><i class="fa fa-fw fa-reorder"></i></a>
                                                    @endif
                                                    <a href="#"><i class="fa fa-fw fa-plus-square-o" k="{{$menu['id']}}"></i></a>
                                                    <a href="#"><i class="fa fa-edit" k="{{json_encode($menu)}}"></i></a>
                                                    <a href="#"><i class="fa fa-trash-o" k="{{$menu['id']}}"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: none;">
                                        <ul class="todo-list ui-sortable" style="overflow: hidden;">
                                            @if(!empty($menu['children']))
                                                <?php $i = 1;?>
                                                @foreach($menu['children'] as $child)
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-md-3 col-md-offset-1">
                                                        <span class="handle ui-sortable-handle">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </span>
                                                                <input type="hidden" pid="{{$menu['id']}}" value="{{$child['id']}}">
                                                                <span class="text">#{{$i++}}</span>
                                                                <a class="default" target="_blank" href="{{$child['url']}}" title="点击跳转到{{$child['name']}}">{{$child['name']}}</a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                @if(strpos($child['lang'], 'zh_cn') !== false)
                                                                    <small class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</small>
                                                                @endif
                                                                @if(strpos($child['lang'], 'zh_tw') !== false)
                                                                    <small class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</small>
                                                                @endif
                                                                @if(strpos($child['lang'], 'en_us') !== false)
                                                                    <small class="label label-default"><i class="fa fa-clock-o"></i>English</small>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                @if($child['status'] == 1)
                                                                    <small class="label label-success"><i class="fa fa-clock-o"></i>有效</small>
                                                                @else
                                                                    <small class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</small>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="tools" style="display:block">
                                                                    <i class="fa fa-edit" k="{{json_encode($child)}}"></i>
                                                                    <i class="fa fa-trash-o" k="{{$child['id']}}"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            @endforeach
                        @endif
                        <div class="box-footer clearfix no-border  pull-right" style="display: block;">
                            <button type="button" class="btn btn-default">新增菜单</button>
                            <button type="button" class="btn btn-info">保存</button>
                            <button type="button" class="btn btn-danger">取消</button>
                        </div>
                    </div>
                    <div @if($menu_type == 2) class="tab-pane active connectedSortable" @else class="tab-pane connectedSortable" @endif  id="tab_footer">
                        @if(!empty($f_menus))
                            <?php $index = 1;?>
                        @foreach($f_menus as $menu)
                        <div class="box" style="position: relative; left: 0px; top: 0px;border-top-width:1px;margin-bottom: 0px;">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <div class=" row">
                                    <div class="col-md-3">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                        <span class="text">#{{$index++}}</span>
                                        <a class="default" target="_blank" href="{{$menu['url']}}" title="点击跳转到{{$menu['name']}}">{{$menu['name']}}</a>
                                    </div>
                                    <div class="col-md-4">
                                        @if(strpos($menu['lang'], 'zh_cn') !== false)
                                            <a class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</a>
                                        @endif
                                        @if(strpos($menu['lang'], 'zh_tw') !== false)
                                            <a class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</a>
                                        @endif
                                        @if(strpos($menu['lang'], 'en_us') !== false)
                                            <a class="label label-default"><i class="fa fa-clock-o"></i>English</a>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        @if($menu['status'] == 1)
                                            <a class="label label-success"><i class="fa fa-clock-o"></i>有效</a>
                                        @else
                                            <a class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</a>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box-tools pull-right">
                                            @if(isset($menu['children']) && !empty($menu['children']))
                                                <a href="#"><i class="fa fa-fw fa-reorder"></i></a>
                                            @endif
                                            <a href="#"><i class="fa fa-fw fa-plus-square-o" k="{{$menu['id']}}"></i></a>
                                            <a href="#"><i class="fa fa-edit" k="{{json_encode($menu)}}"></i></a>
                                            <a href="#"><i class="fa fa-trash-o" k="{{$menu['id']}}"></i></a>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="box-body" style="display: none;">
                                <ul class="todo-list ui-sortable" style="overflow: hidden;">
                                    @if(!empty($menu['children']))
                                        <?php $i = 1;?>
                                        @foreach($menu['children'] as $child)
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-3 col-md-offset-1">
                                                        <span class="handle ui-sortable-handle">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </span>
                                                        <span class="text">#{{$i++}}</span>
                                                        <a class="default" target="_blank" href="{{$child['url']}}" title="点击跳转到{{$child['name']}}">{{$child['name']}}</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        @if(strpos($child['lang'], 'zh_cn') !== false)
                                                            <small class="label label-warning"><i class="fa fa-clock-o"></i>简体中文</small>
                                                        @endif
                                                        @if(strpos($child['lang'], 'zh_tw') !== false)
                                                            <small class="label label-primary"><i class="fa fa-clock-o"></i>繁体中文</small>
                                                        @endif
                                                        @if(strpos($child['lang'], 'en_us') !== false)
                                                            <small class="label label-default"><i class="fa fa-clock-o"></i>English</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if($child['status'] == 1)
                                                            <small class="label label-success"><i class="fa fa-clock-o"></i>有效</small>
                                                        @else
                                                            <small class="label label-danger"><i class="fa fa-clock-o"></i>隐藏</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="tools" style="display:block">
                                                            <i class="fa fa-edit" k="{{json_encode($child)}}"></i>
                                                            <i class="fa fa-trash-o" k="{{$child['id']}}"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        @endforeach
                        @endif
                        <div class="box-footer clearfix no-border  pull-right" style="display: block;">
                                <button type="button" class="btn btn-default">新增菜单</button>
                                <button type="button" class="btn btn-info">保存</button>
                                <button type="button" class="btn btn-danger">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
    <input type="hidden" id="footerMenus" value="{{json_encode($f_menus)}}" >
    <input type="hidden" id="headerMenus" value="{{json_encode($h_menus)}}" >
    <!-- 模态框 新增菜单/修改菜单 -->
    <div id="infoModal" class="modal " tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="box box-info">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="box-title">添加菜单</h3>
                </div>
                <div class="form-horizontal">
                    <input type="hidden" id="menuId" value="0" >
                    <input type="hidden" id="operation" value="" >
                    <div class="box-body">
                        <div id="idArea" class="form-group" style="display: none;">
                            <label class="col-sm-2 control-label">菜单ID</label>
                            <label class="col-sm-1 control-label"></label>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">菜单名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="菜单名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="url" placeholder="URL">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="menu_type" class="col-sm-2 control-label">菜单类型</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="menu_type">
                                    <option value="0">请选择</option>
                                    <option value="1">头部导航菜单</option>
                                    <option value="2">底部导航菜单</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pid" class="col-sm-2 control-label">上级菜单</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="pid">
                                    <option value="0">请选择</option>
                                </select>
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
                                <button id="saveData" class="btn btn-info pull-right">保存</button>
                                <button class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 模态框 删除用户 -->
    <div id="delModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="box box-danger">
                <div class="modal-header with-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除菜单</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="0" >
                    <p>是否确定要删除该菜单？</p>
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

</div>
@endsection

@section('js')
    <script src="{{asset('/plugins/JQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/home/menu.js')}}"></script>

@endsection