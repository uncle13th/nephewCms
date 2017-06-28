<?php

namespace App\Http\Model\Front;

use App\Http\Model\BaseModel;
use DB;

class IndexModel extends BaseModel
{

    protected $table = 'front_menu';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取前端网站的导航菜单
     * @param int $type 类型：1-头部导航菜单；2-底部导航菜单
     * @return array
     */
    public function getFrontMenus($type){
        $data = $this->where('status', '!=', -1)->where('menu_type', $type)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 新增菜单
     * @param array $data 菜单信息数组
     * @return bool|array
     */
    public function addData($data){
        if(empty($data) || empty($data['name']) || !isset($data['status'])
            || $data['menu_type'] < 1 || empty($data['lang']) || empty($data['target'])){
            return false;
        }

        //判断名字是否被使用了
        $num = $this->where('status', '!=', -1)->where('name', $data['name'])->where('menu_type', $data['menu_type'])->count();
        if($num > 0){
            return false;
        }

        $model = new static($data);
        if(!$model->save()){
            return false;
        }
        return $model->toArray();
    }

    /**
     * 更新菜单信息
     * @param array $data 菜单信息数组
     * @return bool|array
     */
    public function updateData($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['name']) || !isset($data['status'])
            || $data['menu_type'] < 1 || empty($data['lang']) || empty($data['target'])){
            return false;
        }

        $num = $this->where('status', '!=', -1)->where('id','!=', $data['id'])->where('name', $data['name'])
            ->where('menu_type', $data['menu_type'])->count();
        if($num > 0){
            return false;
        }

        $model = $this->where('id', $data['id'])->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        if(!$model->update($data)){
            return false;
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
            return false;
        }

        $model = $this->where('id', $id)->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }
        $info = $model->toArray();
        $data['status'] = -1;
        if(!$model->update($data)){
            return false;
        }

        //删除子菜单
        if($info['pid'] == 0){
            $model = $this->where('pid', $id)->where('status', '!=', -1);
            if($model->count() > 0){
                $data['status'] = -1;
                if(!$model->update($data)){
                    return false;
                }
            }
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
            return false;
        }

        DB::beginTransaction();

        foreach($order as $id=>$sort){
            DB::table($this->table)->where('id', $id)->update(['sort' => $sort]);
        }

        DB::commit();
        return true;
    }
}
