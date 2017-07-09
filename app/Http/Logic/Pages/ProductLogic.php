<?php
namespace App\Http\Logic\Pages;

use App\Http\Logic\BaseLogic;
use App\Http\Model\Pages\ProductTypeModel;
use App\Http\Model\Pages\ProductListModel;

class ProductLogic extends BaseLogic
{
    /**
     * 获取所有的产品类型（包含隐藏的,所有字段）
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
     * 保存产品类型信息（支持新增和修改）
     * @param array $params 产品类型信息数组
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

    /**
     * 获取所有的产品类型（包含隐藏的，）
     * @return array ("id"=>"value")
     */
    public function getProductTypeMenu(){
        $model = ProductTypeModel::instance();
        $data = $model->getAllProductTypes();
        if(!$data){
            return array();
        }

        $result = [];
        foreach($data as $item){
            $result[$item['id']] = $item['name'];
        }

        return $result;
    }

    /**
     * 获取产品列表信息（包含隐藏的）
     * @param int $type_id 产品类型id
     * @param int $status 状态： -1：全部；1-有效；0-无效
     * @param int $id 产品ID
     * @param string $name 产品名称
     * @return array
     */
    public function getProductList($type_id = 0, $status = -1, $id = 0, $name = ''){
        if(!is_numeric($type_id) || $type_id < 0 || !is_numeric($status) || $status < -1 || $status >1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return array();
        }
        $model = ProductListModel::instance();
        $data = $model->getProductList($type_id, $status, $id, $name);
        if(!$data){
            return array();
        }
        return $data;
    }

    /**
     * 删除产品
     * @param int $id 产品id
     * @return bool
     */
    public function deleteProduct($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ProductListModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 60005;
            $this->errorMessage = '产品删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存产品排序数据
     * @param array $order 产品ID对应的顺序信息
     * @return bool
     */
    public function sortProductList($order){
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

        $model = ProductListModel::instance();
        if(!$model->sortProductList($order)){
            $this->errorCode = 60006;
            $this->errorMessage = '产品顺序保存失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存产品信息（支持新增和修改）
     * @param array $params 产品信息数组
     * @return bool
     */
    public function saveProduct($params){

        if(empty($params) ||  empty($params['name']) || !isset($params['type'])|| !isset($params['status'])
            || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1)) || empty($params['lang'])){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'name' => trim($params['name']),
            'type' => intval($params['type']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
            'description' => trim($params['description']),
            'img' => trim($params['img']),
            'detail' => trim($params['detail'])
        );

        $model = ProductListModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 60008;
                $this->errorMessage = '产品信息修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 60007;
                $this->errorMessage = '产品信息添加失败！';
                return false;
            }
        }

        return true;
    }


    public function getProductInfo($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ProductListModel::instance();
        $data = $model->getProductInfo($id);
        if(!$data){
            return array();
        }

        $data['img'] = explode(';', $data['img']);
        $data['detail'] = explode(';', $data['detail']);
        return $data;
    }
}