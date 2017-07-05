<?php
namespace App\Http\Logic\Pages;

use App\Http\Logic\BaseLogic;
use App\Http\Model\Pages\BannerModel;
use App\Http\Model\System\ConfigModel;
use App\Http\Model\Pages\ProductTypeModel;


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

    /**
     * 获取可以在首页展示的轮播图（根据网站的语言获取不同的轮播图信息）
     * @param string $lang 语言
     * @return array
     */
    public function getIndexBanners($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = BannerModel::instance();
        $data = $model->getIndexBanners($lang);
        if(!$data){
            return array();
        }
        return $data;
    }

    /**
     * 保存轮播图信息（支持新增和修改轮播图）
     * @param array $params 轮播图信息数组
     * @return bool
     */
    public function saveBanner($params){

        if(empty($params) ||  empty($params['title']) || empty($params['url']) || empty($params['img'])
            || !isset($params['status']) || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1))
            || empty($params['lang'])  || empty($params['target'])){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'title' => trim($params['title']),
            'url' => trim($params['url']),
            'img' => trim($params['img']),
            'target' => trim($params['target']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
        );

        $model = BannerModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 50002;
                $this->errorMessage = '轮播图修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 50001;
                $this->errorMessage = '轮播图添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除轮播图
     * @param int $id 轮播图id
     * @return bool
     */
    public function deleteBanner($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = BannerModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 50003;
            $this->errorMessage = '轮播图删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存轮播图排序数据
     * @param array $order 轮播图ID对应的顺序信息
     * @return bool
     */
    public function sortBanners($order){
        if(empty($order) || !is_array($order)){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        //过滤
        foreach($order as $id=>$sort){
            if(!$sort){
                unset($order[$id]);
            }
        }

        $model = BannerModel::instance();
        if(!$model->sortBanners($order)){
            $this->errorCode = 50004;
            $this->errorMessage = '轮播图顺序保存失败！';
            return false;
        }
        return true;
    }

    /**
     * 获取首页配置信息
     * @return mixed
     */
    public function getIndexConfig(){
        $model = ConfigModel::instance();
        return $model->getIndexConfig();
    }

    /**
     * 保存首页配置信息
     * @param int $bannerNum 首页轮播图数量的上限
     * @param int $indexProductNum 首页展示的产品位置的数量
     * @return bool
     */
    public function saveIndexConfig($bannerNum, $indexProductNum)
    {
        if(!is_numeric($bannerNum) || !is_numeric($indexProductNum) || $bannerNum < 1 || $indexProductNum < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ConfigModel::instance();
        if(!$model->saveIndexConfig($bannerNum, $indexProductNum)){
            $this->errorCode = 50005;
            $this->errorMessage = '首页配置信息保存失败！';
            return false;
        }

        return true;
    }

    /**
     * 修改轮播图的图片
     * @param int $id 轮播图id
     * @param string $img 图片地址
     * @return bool
     */
    public function updateBannerImage($id, $img){
        if(!is_numeric($id) || $id < 1 || empty($img)){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = BannerModel::instance();
        if(!$model->updateBannerImage($id, $img)){
            $this->errorCode = 50006;
            $this->errorMessage = '轮播图的图片修改失败！';
            return false;
        }
        return true;
    }
}