<?php
namespace App\Http\Logic\Pages;

use App\Http\Logic\BaseLogic;
use App\Http\Model\Pages\ProductTypeModel;


class ProductLogic extends BaseLogic
{
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

    /**
     * 获取可以在首页展示的产品类型（根据网站的语言获取不同的产品类型信息）
     * @param string $lang 语言
     * @return array
     */
    public function getIndexProductTypes($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = ProductTypeModel::instance();
        $data = $model->getIndexProductTypes($lang);
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
    public function saveProductType($params){

        if(empty($params) ||  empty($params['name']) || !isset($params['show'])|| !isset($params['status'])
            || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1)) || empty($params['lang'])){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'name' => trim($params['name']),
            'show' => intval($params['show']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
        );

        $model = ProductTypeModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 60002;
                $this->errorMessage = '产品类型修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 60001;
                $this->errorMessage = '产品类型添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除产品类型
     * @param int $id 产品类型id
     * @return bool
     */
    public function deleteProductType($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ProductTypeModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 60003;
            $this->errorMessage = '产品类型删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存产品类型排序数据
     * @param array $order 产品类型ID对应的顺序信息
     * @return bool
     */
    public function sortProductType($order){
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

        $model = ProductTypeModel::instance();
        if(!$model->sortProductType($order)){
            $this->errorCode = 60004;
            $this->errorMessage = '产品类型顺序保存失败！';
            return false;
        }
        return true;
    }
}