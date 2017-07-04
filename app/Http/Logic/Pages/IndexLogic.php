<?php
namespace App\Http\Logic\Pages;

use App\Http\Logic\BaseLogic;
use App\Http\Model\Pages\BannerModel;
use App\Http\Model\Pages\ProductTypeModel;
use Illuminate\Support\Facades\Auth;

class IndexLogic extends BaseLogic
{

    /**
     * 获取轮播图（包含隐藏的）
     * @return array
     */
    public function getAllBanners(){
        $model = BannerModel::instance();
        $data = $model->getAllBanners();
        if(!$data){
            return array();
        }
        return $data;
    }

    public function addBanner(){
        $model = BannerModel::instance();
    }

    public function updateBanner(){
        $model = BannerModel::instance();
    }

    public function deleteBanner(){
        $model = BannerModel::instance();
    }

    /**
     * 获取所有的产品类型（包含隐藏的）
     * @return array
     */
    public function getAllProductTypes(){
        $model = ProductTypeModel::instance();
        $data = $model->getAllProductTypes();
        if(!$data){
            return array();
        }
        return $data;
    }

    public function addProductType(){

    }

    public function updateProductType(){

    }

    public function deleteProductType(){

    }
}