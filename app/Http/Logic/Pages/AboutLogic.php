<?php
namespace App\Http\Logic\Pages;

use App\Http\Logic\BaseLogic;
use App\Http\Model\Pages\AboutModel;
use App\Http\Model\Pages\ConnectModel;

class AboutLogic extends BaseLogic
{
    /**
     * 获取关于我们列表（包含隐藏的,所有字段）
     * @return array
     */
    public function getAboutList(){
        $model = AboutModel::instance();
        $data = $model->getAboutList();
        if(!$data){
            return array();
        }
        return $data;
    }

    /**
     * 获取可以在前端网站展示的关于我们页面内容（根据网站的语言获取不同的页面内容）
     * @param string $lang 语言
     * @return array
     */
    public function getAboutContent($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = AboutModel::instance();
        $data = $model->getAboutContent($lang);
        if(!$data){
            return array();
        }

        $content = [];
        if(!empty($data['description'])){
            $content = explode("\n", $data['description']);
        }

        $result = array(
            'img' => $data['img'],
            'content' => $content,
        );
        return $result;
    }

    /**
     * 保存关于我们信息（支持新增和修改）
     * @param array $params 关于我们信息数组
     * @return bool
     */
    public function saveAboutInfo($params){

        if(empty($params) ||  empty($params['name']) || empty($params['img'])|| empty($params['description'])|| !isset($params['status'])
            || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1)) || empty($params['lang'])){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'name' => trim($params['name']),
            'img' => trim($params['img']),
            'description' => trim($params['description']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
        );

        $model = AboutModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 70002;
                $this->errorMessage = '关于我们页面信息修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 70001;
                $this->errorMessage = '关于我们页面信息添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除关于我们页面
     * @param int $id id
     * @return bool
     */
    public function deleteAboutInfo($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = AboutModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 70003;
            $this->errorMessage = '关于我们页面信息删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存关于我们页面列表排序数据
     * @param array $order ID对应的顺序信息
     * @return bool
     */
    public function sortAboutList($order){
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

        $model = AboutModel::instance();
        if(!$model->sortAboutList($order)){
            $this->errorCode = 70004;
            $this->errorMessage = '关于我们页面信息排序顺序保存失败！';
            return false;
        }
        return true;
    }

    /**
     * 获取联系我们列表（包含隐藏的,所有字段）
     * @return array
     */
    public function getConnectList(){
        $model = ConnectModel::instance();
        $data = $model->getConnectList();
        if(!$data){
            return array();
        }
        return $data;
    }

    /**
     * 获取可以在前端网站展示的联系我们页面内容（根据网站的语言获取不同的页面内容）
     * @param string $lang 语言
     * @return array
     */
    public function getConnectContent($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = ConnectModel::instance();
        $data = $model->getConnectContent($lang);
        if(!$data){
            return array();
        }

        $content = [];
        if(!empty($data['description'])){
            $content = explode("\n", $data['description']);
        }

        $result = array(
            'img' => $data['img'],
            'content' => $content,
        );
        return $result;
    }

    /**
     * 保存联系我们信息（支持新增和修改）
     * @param array $params 关于我们信息数组
     * @return bool
     */
    public function saveConnectInfo($params){

        if(empty($params) ||  empty($params['name']) || empty($params['img'])|| empty($params['description'])|| !isset($params['status'])
            || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1)) || empty($params['lang'])){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'name' => trim($params['name']),
            'img' => trim($params['img']),
            'description' => trim($params['description']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
        );

        $model = ConnectModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 70006;
                $this->errorMessage = '联系我们页面信息修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 70005;
                $this->errorMessage = '联系我们页面信息添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除联系我们页面
     * @param int $id id
     * @return bool
     */
    public function deleteConnectInfo($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ConnectModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 70007;
            $this->errorMessage = '联系我们页面信息删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 保存联系我们页面列表排序数据
     * @param array $order ID对应的顺序信息
     * @return bool
     */
    public function sortConnectList($order){
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

        $model = ConnectModel::instance();
        if(!$model->sortAboutList($order)){
            $this->errorCode = 70008;
            $this->errorMessage = '联系我们页面信息排序顺序保存失败！';
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

    /**
     * 获取产品信息
     * @param int $id 产品id
     * @return array|bool
     */
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

    /**
     * 获取可以在首页展示的产品（根据网站的语言获取不同的产品类型信息）
     * @param array $product_types 产品类型信息数组
     * @param string $lang 语言
     * @param int $limit_num 展示的条数
     * @return array
     */
    public function getIndexProductList($product_types = [], $lang = 'zh_cn', $limit_num = 8){
        if(empty($product_types) || $limit_num < 1){
            return array();
        }
        if(empty($lang)){
            $lang = 'zh_cn';
        }

        $model = ProductListModel::instance();
        $result = [];
        foreach($product_types as $type){
            $data = $model->getIndexProductList($type['id'], $lang, $limit_num);
            if(!$data){
                $result[$type['id']] = [];
            }
            $len = count($data);
            if($len == $limit_num || ($len % 4 == 0)){
                $result[$type['id']] = $data;
            }
            //不够limit_num条数据，且补位4的倍数，去掉多余的,保留4的倍数。如果总数是小于4那就有多少显示多少。
            if($len < 4){
                $result[$type['id']] = $data;
            }else{
                $num = (int)($len / 4) * 4;
                $temp = array_splice($data, 0 , $num);
                $result[$type['id']] = $temp;
            }
        }

        return $result;
    }

    /**
     * 获取可以在首页展示的产品类型（根据网站的语言获取不同的产品类型信息）
     * @param string $lang 语言
     * @return array
     */
    public function getAvailableProductTypes($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = ProductTypeModel::instance();
        $types = $model->getIndexProductTypes($lang);
        if(!$types){
            return array();
        }

        $listModel = ProductListModel::instance();
        $result = [];
        foreach($types as $type){
            $num = $listModel->getProductCount($type['id'], $lang);
            if($num > 0){
                $result[] = array(
                    'total' => $num,
                    'id' => $type['id'],
                    'name' => $type['name'],
                );
            }
        }

        return $result;
    }

    /**
     * 获取可以在前端网站展示的产品列表
     * @param int $type 产品类型id
     * @param string $lang 语言
     * @return mixed
     */
    public function getAvailableProductList($type, $lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }

        $model = ProductListModel::instance();
        return $model->getAvailableProductList($type, $lang);
    }

    /**
     * 获取产品信息(允许在前端网站展示的产品信息)
     * @param int $id 产品id
     * @return array|bool
     */
    public function getAvailableProductInfo($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = ProductListModel::instance();
        $data = $model->getAvailableProductInfo($id);
        if(!$data){
            return array();
        }

        $data['img'] = explode(';', $data['img']);
        $data['detail'] = explode(';', $data['detail']);
        return $data;
    }
}