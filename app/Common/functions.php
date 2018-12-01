<?php 


/**
 * 1 为正常 2 为非正常
 *
 * @param  $int  $id
 * @return html 
 */
function show_status($int,$str1,$str2)
{
	if($int == 1){
		return '<button class="btn btn-success radius size-S status" data-status="'.$int.'">'.$str1.'</button>';
	}
	if($int == 2){
		return '<button class="btn btn-warning radius size-S status" data-status="'.$int.'">'.$str2.'</button>';
	}
	
}
/**
 * 0 顶级权限 1 一级权限 2 二级权限
 *
 * @param  状态值
 * @return  
 */
function permission_status($int)
{
    if($int == 0){
        return '<span class="label label-default radius">顶级权限</span>';
    }
    if($int == 1){
        return '<span class="label label-secondary radius">一级权限</span>';
    }
    if($int == 2){
        return '<span class="label label-success radius">二级权限</span>';
    }
}
/**
 * 1 下单 2 支付成功 3辉煌入款成功 4辉煌查询后台失败 5辉煌入款失败
 *
 * @param  状态值
 * @return  
 */
function order_status($int)
{
    if($int == 1){
        return '<span class="label label-default radius">下单成功</span>';
    }
    if($int == 2){
        return '<span class="label label-primary radius">支付成功</span>';
    }
    if($int == 3){
        return '<span class="label label-success radius">辉煌入款成功</span>';
    }
    if($int == 4){
        return '<span class="label label-warning radius">辉煌查询后台失败</span>';
    }
    if($int == 5){
        return '<span class="label label-danger radius">辉煌入款失败</span>';
    }
    if($int == 6){
        return '<span class="label label-success radius">辉煌补单成功</span>';
    }
}
/**
 * 递归方式获取上下级权限信息
 *
 * @param  $int  $id
 * @return html 
 */
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['ps_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['ps_pid']])){
            $items[$item['ps_pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}
/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}


/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,DIRECTORY_SEPARATOR),1));

    return ['controller' => $class, 'method' => $method];
}