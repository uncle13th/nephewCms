<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Logic\Pages\IndexLogic;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * 展示首页信息
     */
    public function showIndexPage(Request $request)
    {
        $inputs = $request->input();
        if(empty($inputs) ||empty($inputs['menu_type'])){
            $menu_type = 1;
        }else{
            $menu_type = intval($inputs['menu_type']);
            if($menu_type < 1){
                $menu_type = 1;
            }
        }

        $logic = IndexLogic::getInstance();
        //1.获取轮播图
        $banners = $logic->getAllBanners();
//        print_r($banners);exit;
        //2.获取产品类型
//        $product_types = $logic->getAllProductTypes();
//        print_r($product_types);exit;
        //3.获取产品列表
//        $product_list = $logic->getProductList();
//        print_r($product_list);exit;

        //2.获取配置信息
        $index_config = $logic->getIndexConfig();
        $banner_num = $index_config['banner_num'];
        $index_product_num = $index_config['product_num'];

        $data = array(
            'menu_type' => $menu_type,
            'banners' => $banners,
            'banner_num' => $banner_num,
            'index_product_num' => $index_product_num,
        );
        return view('home.pages.index', $data);
    }

    /*
     * 保存轮播图信息
     */
    public function saveBanner(Request $request){
        $inputs = $request->input();
        $logic = IndexLogic::getInstance();
        $result =$logic->saveBanner($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除轮播图
     */
    public function deleteBanner(Request $request)
    {
        $id = $request->input('id');
        $logic = IndexLogic::getInstance();
        $result = $logic->deleteBanner($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存轮播图排序信息
     */
    public function sortBanners(Request $request)
    {
        $order = $request->input('order');
        $logic = IndexLogic::getInstance();
        $result = $logic->sortBanners($order);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    //保存图片信息


    /*
     * 保存首页配置信息
     */
    public function saveIndexConfig(Request $request)
    {
        $bannerNum = $request->input('bannerNum');
        $indexProductNum = $request->input('indexProductNum');

        $logic = IndexLogic::getInstance();
        $result = $logic->saveIndexConfig($bannerNum, $indexProductNum);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存首页配置信息
     */
    public function updateBannerImage(Request $request)
    {
        $id = $request->input('id');
        $img = $request->input('img');

        $logic = IndexLogic::getInstance();
        $result = $logic->updateBannerImage($id, $img);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }
}
