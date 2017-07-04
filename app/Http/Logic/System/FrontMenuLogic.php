<?php
namespace App\Http\Logic\System;

use App\Http\Logic\BaseLogic;
use App\Http\Model\System\FrontMenuModel;
use Illuminate\Support\Facades\Auth;

class FrontMenuLogic extends BaseLogic
{
    /**
     * 获取头部导航菜单
     * @param string $lang 语言
     * @return array
     */
    public function getHeaderMenu($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = env('front_lang', 'zh_cn');
        }
        $model = FrontMenuModel::instance();
        $data = $model->getHeaderMenu($lang);
        if(!$data){
            return array();
        }

        $result = [];
        //1.获取父菜单（按顺序）
        foreach ($data as $key=>$item) {
            if ($item['pid'] == 0) {
                $result[$item['id']] = array(
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'target' => $item['target'],
                    'children' =>  [],
                );
            }
        }

        //2.获取子菜单
        foreach ($data as $key=>$item) {
            if($item['pid'] != 0 && isset($result[$item['pid']])){
                $result[$item['pid']]['children'][] = array(
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'target' => $item['target'],
                );
            }
        }

        return $result;
    }

    /**
     * 获取底部导航菜单
     * @param string $lang 语言
     * @return array
     */
    public function getFooterMenu($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = env('front_lang', 'zh_cn');
        }
        $model = FrontMenuModel::instance();
        $data = $model->getFooterMenu($lang);
        if(!$data){
            return array();
        }

        $result = [];
        //1.获取父菜单（按顺序）
        foreach ($data as $key=>$item) {
            if ($item['pid'] == 0) {
                $result[$item['id']] = array(
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'target' => $item['target'],
                    'children' =>  [],
                );
            }
        }

        //2.获取子菜单
        foreach ($data as $key=>$item) {
            if($item['pid'] != 0 && isset($result[$item['pid']])){
                $result[$item['pid']]['children'][] = array(
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'target' => $item['target'],
                );
            }
        }

        return $result;
    }

    /**
     * 获取前端网站的导航菜单(管理后台使用)
     * @param int $type 类型：1-头部导航菜单；2-底部导航菜单
     * @return array
     */
    public function getFrontMenus($type){
        $model = FrontMenuModel::instance();
        $data = $model->getFrontMenus($type);
        if(!$data){
            return array();
        }

        $result = [];
        //1.获取父菜单（按顺序）
        foreach ($data as $key=>$item) {
            if ($item['pid'] == 0) {
                $result[$item['id']] = array(
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'lang' => $item['lang'],
                    'url' => $item['url'],
                    'pid' =>$item['pid'],
                    'target' => $item['target'],
                    'menu_type' => $item['menu_type'],
                    'children' =>  [],
                );
            }
        }

        //2.获取子菜单
        foreach ($data as $key=>$item) {
            if($item['pid'] != 0){
                $result[$item['pid']]['children'][] = array(
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'lang' => $item['lang'],
                    'url' => $item['url'],
                    'pid' =>$item['pid'],
                    'target' => $item['target'],
                    'menu_type' => $item['menu_type'],
                );
            }
        }

        return $result;
    }

    /**
     * 保存菜单信息（支持新增菜单和修改菜单）
     * @param array $params 菜单信息数组
     * @return bool
     */
    public function saveData($params){

        if(empty($params) || (!isset($params['id']) && empty($params['name'])) || empty($params['url'])
            || !isset($params['status']) || (isset($params['id']) && (!is_numeric($params['id']) || $params['id'] < 1))
            || empty($params['lang'])  || empty($params['target']) || $params['menu_type'] < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $data = array(
            'name' => trim($params['name']),
            'url' => trim($params['url']),
            'menu_type' => intval($params['menu_type']),
            'pid' => intval($params['pid']),
            'target' => trim($params['target']),
            'lang' => trim($params['lang']),
            'status' => intval($params['status']),
        );

        $model = FrontMenuModel::instance();
        //有上传id
        if(isset($params['id'])){
            $data['id'] = intval($params['id']);
            $result = $model->updateData($data);
            if(!$result){
                $this->errorCode = 40002;
                $this->errorMessage = '菜单修改失败！';
                return false;
            }
        }else{
            $result = $model->addData($data);
            if(!$result){
                $this->errorCode = 40001;
                $this->errorMessage = '菜单添加失败！';
                return false;
            }
        }

        return true;
    }

    /**
     * 删除菜单
     * @param int $id 菜单id
     * @return bool
     */
    public function deleteData($id){
        if(!is_numeric($id) || $id < 1){
            $this->errorCode = 10001;
            $this->errorMessage = '参数异常！';
            return false;
        }

        $model = FrontMenuModel::instance();
        if(!$model->deleteData($id)){
            $this->errorCode = 40003;
            $this->errorMessage = '菜单删除失败！';
            return false;
        }
        return true;
    }

    /**
     * 给菜单排序
     * @param array $order 菜单ID对应的顺序信息
     * @return bool
     */
    public function sortMenu($order){
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

        $model = FrontMenuModel::instance();
        if(!$model->sortMenu($order)){
            $this->errorCode = 40004;
            $this->errorMessage = '菜单顺序保存失败！';
            return false;
        }
        return true;
    }
}