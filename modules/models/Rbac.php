<?php

namespace app\modules\models;
use yii\db\ActiveRecord;
use Yii;

class Rbac extends ActiveRecord
{
    /**
     * 对获取的角色信息处理
     * @param $data (角色信息)
     * @param $parent (当前要分配的角色)
     * @return array
     */
    public static function getOptions($data, $parent)
    {
        //['val'=>'test']
        $return = [];
        // 每一个数据值都是对象
        foreach ($data as $obj){
            // 判断下a角色能不能添加子节点
            // 角色不为空，分配角色不等于本身
            if(!empty($parent) && $parent->name != $obj->name
                    // 并且当前角色可以被分配
                && Yii::$app->authManager->canAddChild($parent, $obj))
            {
                $return[$obj->name] = $obj->description;
            }
            // manage/assign parent如果为空
            if (is_null($parent)) {
                $return[$obj->name] = $obj->description;
            }
        }
        return $return;

    }

    /**
     *
     * @param $children
     * @param $name
     * @return bool
     */
    public static function addChild($children, $name)
    {
        $auth = Yii::$app->authManager;
        $itemObj = $auth->getRole($name);
        // 角色不存在
        if (empty($itemObj)) {
            return false;
        }
        // 开启事务
        $trans = Yii::$app->db->beginTransaction();
        try {
            // 删除所有子节点
            $auth->removeChildren($itemObj);
            foreach ($children as $item) {
                // role不存在就拿permission
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                // 第一个是parentpermission 第二个是拿到permission
                $auth->addChild($itemObj, $obj);    //执行添加
            }
            $trans->commit();
        } catch(\Exception $e) {
            $trans->rollback();
            return false;
        }
        return true;
    }

    /**
     * 拿到当前名称下所有子节点
     * @param $name   (角色名称)
     * @return array  (包含角色和权限)
     */
    public static function getChildrenByName($name)
    {
        if (empty($name)) {
            return [];
        }
        $return = [];
        $return['roles'] = [];
        $return['permissions'] = [];
        $auth = Yii::$app->authManager;
        // 获得该名称下面所有子节点
        $children = $auth->getChildren($name);
         // var_dump($children);exit;
        if (empty($children)) {
            return [];
        }
        foreach ($children as $obj) {
            if ($obj->type == 1) {  // 是role
                $return['roles'][] = $obj->name;
            } else {        // 是权限
                $return['permissions'][] = $obj->name;
            }
        }
        return $return;

    }

    /**
     * 给每个管理员进行授权
     * @param $adminid
     * @param $children  (分配的节点 角色权限)
     * @return bool
     */
    public static function grant($adminid, $children)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
            $auth = Yii::$app->authManager;
            // 取消授权
            $auth->revokeAll($adminid);
            foreach ($children as $item) {
                // 如果拿不到角色就拿权限
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->assign($obj, $adminid);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return false;
        }
        return true;

    }

    /**
     * 用户获取下面所有权限通用方法
     * @param $adminid
     * @param $type  (roles/permission)
     * @return array
     */
    private static function _getItemByUser($adminid, $type)
    {
        $func = 'getPermissionsByUser';
        if ($type == 1) {
            $func = 'getRolesByUser';
        }
        $data = [];
        $auth = Yii::$app->authManager;
        $items = $auth->$func($adminid);
        foreach ($items as $item) {
            $data[] = $item->name;
        }
        return $data;

    }

    /**
     * 授权后，当前管理员下权限勾选上
     * (也就是拿到当前管理员拥有所有权限)
     * @param $adminid
     * @return array
     */
    public static function getChildrenByUser($adminid){
        $return = [];
        $return['roles'] = self::_getItemByUser($adminid, 1); // 1代表所有角色
        $return['permissions'] = self::_getItemByUser($adminid, 2); // 2代表所有权限
        return $return;
    }
}