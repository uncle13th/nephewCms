<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\Controller;
use App\Http\Logic\Pages\AboutLogic;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * 展示关于我们页面
     */
    public function showAboutPage()
    {
        //获取列表内容
        $logic = AboutLogic::getInstance();
        $list = $logic->getAboutList();

        $pageIndex = 1004;  //页面索引，管理后台左侧菜单使用
        $data = array(
            'list' => $list,
            'pageIndex' => $pageIndex,
        );
        return view('home.pages.about', $data);
    }

    /*
     * 保存关于我们信息
     */
    public function saveAboutInfo(Request $request){
        $inputs = $request->input();
        $logic = AboutLogic::getInstance();
        $result =$logic->saveAboutInfo($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除关于我们页面
     */
    public function deleteAboutInfo(Request $request)
    {
        $id = $request->input('id');
        $logic = AboutLogic::getInstance();
        $result = $logic->deleteAboutInfo($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存关于我们页面列表排序信息
     */
    public function sortAboutList(Request $request)
    {
        $order = $request->input('order');
        $logic = AboutLogic::getInstance();
        $result = $logic->sortAboutList($order);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }


    /*
     * 展示联系我们页面
     */
    public function showConnectPage()
    {
        //获取列表内容
        $logic = AboutLogic::getInstance();
        $list = $logic->getConnectList();

        $pageIndex = 1005;  //页面索引，管理后台左侧菜单使用
        $data = array(
            'list' => $list,
            'pageIndex' => $pageIndex,
        );
        return view('home.pages.connect', $data);
    }

    /*
     * 保存联系我们信息
     */
    public function saveConnectInfo(Request $request){
        $inputs = $request->input();
        $logic = AboutLogic::getInstance();
        $result =$logic->saveConnectInfo($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除联系我们页面
     */
    public function deleteConnectInfo(Request $request)
    {
        $id = $request->input('id');
        $logic = AboutLogic::getInstance();
        $result = $logic->deleteConnectInfo($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存联系我们页面列表排序信息
     */
    public function sortConnectList(Request $request)
    {
        $order = $request->input('order');
        $logic = AboutLogic::getInstance();
        $result = $logic->sortConnectList($order);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

}
