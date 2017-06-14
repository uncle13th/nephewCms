@extends('layouts.main')
@section('css')
    {{--<link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">--}}
    <link rel="stylesheet" href="{{asset('/plugins/fancybox/jquery.fancybox.css')}}" type="text/css" media="screen" />
@endsection

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>用户权限管理</li>
                    <li class="active"><i class="fa fa-fw fa-user"></i>用户管理</li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <button id="addUser" class="btn btn-info pull-right"><span class="fa fa-fw fa-user-plus"></span>新增用户</button>
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
                        <h3 class="box-title">用户列表</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <div id="searchArea" class="input-group-btn">
                                    <button type="button" class="btn btn-warning dropdown-toggle" style="width: 100px;" data-toggle="dropdown" aria-expanded="false" k="id">用户ID
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li k="id"><a>用户ID</a></li>
                                        <li k="username"><a>用户名</a></li>
                                        <li k="nickname"><a>昵称</a></li>
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
                            <tbody>
                            <tr>
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>昵称</th>
                                <th>所属角色</th>
                                <th>状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            @if($users->total() > 0)
                                @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nickname }}</td>
                                <td><a class="btn btn-default btn-xs" href="/home/role/list?id={{$user->role_id}}">{{ @$roles[$user->role_id]['name'] }}</a></td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="label label-success">可用</span>
                                    @else
                                        <span class="label label-warning">隐藏</span>
                                    @endif
                                </td>
                                <td>{{ date('Y-m-d', $user->created_at) }}</td>
                                <td>
                                    @if($user->id != 1)
                                        <a class="btn btn-info btn-xs">修改</a>
                                        <a class="btn btn-danger btn-xs">删除</a>
                                        <input type="hidden"  value="{{json_encode($user)}}" >
                                    @endif
                                </td>
                            </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" align="center">当前无数据！</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($users->total() > 0)
                    <div class="box-footer clearfix">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <!-- 模态框 新增用户/修改用户 -->
        <div id="infoModal" class="modal " tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="box-title">新增用户</h3>
                    </div>
                    <div class="form-horizontal">
                        <input type="hidden" id="userId" value="0" >
                        <input type="hidden" id="operation" value="" >
                        <div class="box-body">
                            <div id="idArea" class="form-group" style="display: none;">
                                <label class="col-sm-2 control-label">用户ID</label>
                                <label class="col-sm-1 control-label"></label>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" placeholder="用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nickname" class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nickname" placeholder="昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="img" class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input id="img" class="img_src form-control" name="img" type="text" value="">
                                        <span class="input-group-btn">
                                            <a href="/filemanager/dialog.php?type=1&field_id=img" class="btn btn-warning iframe-btn">选择图片</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">所属角色</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="role">
                                        <option value="0">请选择</option>
                                        @if(!empty($roles))
                                            @foreach($roles as $id=>$role)
                                        <option value="{{$id}}">{{$role['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comfirm_password" class="col-sm-2 control-label">确认密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="comfirm_password" placeholder="确认密码">
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
                                    <button id="saveUser" class="btn btn-info pull-right">保存</button>
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
                        <h4 class="modal-title">删除用户</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="roleId" value="0" >
                        <p>是否确定要删除该用户？</p>
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
<script src="{{asset('/js/home/users.js')}}"></script>

@endsection