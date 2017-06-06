@extends('layouts.main')
@section('css')
    {{--<link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">--}}
@endsection

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>用户权限管理</li>
                    <li class="active"><i class="fa fa-fw fa-paw"></i>角色管理</li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <button id="addRole" class="btn btn-info pull-right"><span class="fa fa-fw fa-plus-square"></span>新增角色</button>
            </div>
        </div>
    </section>

@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">角色列表</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <div id="searchArea" class="input-group-btn">
                                    <button type="button" class="btn btn-warning dropdown-toggle" style="width: 100px;" data-toggle="dropdown" aria-expanded="false" k="id">角色ID
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li k="id"><a>角色ID</a></li>
                                        <li k="name"><a>角色名称</a></li>
                                    </ul>
                                </div>
                                <input id="keyword" type="text" class="form-control" placeholder="请输入id或名称" >
                                <div class="input-group-btn">
                                    <button id="search" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tbody><tr>
                                <th>角色ID</th>
                                <th>角色名称</th>
                                <th>状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            @if($roles->total() > 0)
                                @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if($role->status == 1)
                                        <span class="label label-success">可用</span>
                                    @else
                                        <span class="label label-warning">隐藏</span>
                                    @endif
                                </td>
                                <td>{{ date('Y-m-d', $role->created_at) }}</td>
                                <td>
                                    @if($role->id != 1)
                                        <a class="btn btn-info btn-xs">修改</a>
                                        <a class="btn btn-danger btn-xs">删除</a>
                                        <input type="hidden"  value="{{json_encode($role->toArray())}}" >
                                    @endif
                                </td>
                            </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center">当前无数据！</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($roles->total() > 0)
                    <div class="box-footer clearfix">
                        {{ $roles->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <!-- 模态框 新增角色/修改橘色 -->
        <div id="roleInfoModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="box-title">新增角色</h3>
                    </div>
                    <div class="form-horizontal">
                        <input type="hidden" id="roleId" value="0" >
                        <input type="hidden" id="operation" value="" >
                        <div class="box-body">
                            <div id="idArea" class="form-group" style="display: none;">
                                <label class="col-sm-2 control-label">角色ID</label>
                                <label class="col-sm-1 control-label"></label>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">角色名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="角色名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">角色状态</label>
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label">系统菜单</label>
                                <div class="col-sm-10 role-menu">
                                    @if($menus)
                                        @foreach($menus as $menu)
                                    <div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="{{$menu['info']['id']}}">{{$menu['info']['name']}}</label>
                                        </div>

                                        <div class="checkbox col-md-offset-1">
                                            @foreach($menu['children'] as $child)
                                            <label><input type="checkbox" value="{{$child['id']}}">{{$child['name']}}</label>
                                            @endforeach
                                        </div>

                                    </div>
                                        @endforeach
                                    @endif
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
                                    <button id="saveRole" class="btn btn-info pull-right">保存</button>
                                    <button class="btn btn-default pull-right" data-dismiss="modal" style="margin-right: 10px;">取消</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 模态框 删除角色 -->
        <div id="delRoleModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-danger">
                    <div class="modal-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">删除角色</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="roleId" value="0" >
                        <p>是否确定要删除该角色？</p>
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
<script src="{{asset('/js/home/roles.js')}}"></script>
@endsection