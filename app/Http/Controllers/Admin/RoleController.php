<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\StoreRoleRequest;
use App\Repositories\PermissionRepository;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $baseRepositoryl;
    protected $permissionRepository;

    /**
     * 构造函数实例化公共的方法类
     */   
    public function __construct(BaseRepository $baseRepository,RoleRepository $roleRepository,PermissionRepository $permissionRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->baseRepository->model = 'Role';                      //给公用方法提供 模型
        $this->baseRepository->id = 'r_id';                         //给公用方法提供 模型
    }
    
    /**
     * 显示列表资源
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = $this->roleRepository->getRoleFeelds();
        $count = $this->roleRepository->roleCount();
       
        return view('admin.role.index',compact('role','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 创建一个角色的实例 调用的是公共方法
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {   
        if($this->roleRepository->roleUnique($request->get('r_name'))){  
            return ['code'=>config('code.error'),'error'=>'角色存在了!'];
        };
        $data = [
            'r_name'=>$request->get('r_name'),
            'desc'=>$request->get('desc'),
            'created_at'=>date('Y-m-d h:i:s',time()),
        ];

        if($this->baseRepository->BaseSave($data)){
            return ['code'=>config('code.success'),'url'=>$_SERVER['HTTP_REFERER']];
        };

        return ['code'=>config('code.error')];
    }

    /**
     * 勾选删除
     *
     * @param  ids
     * @return \Illuminate\Http\Response
     */
    public function roleAll(Request $request)
    {
        $ids = $request->get('_ids');

        if($this->baseRepository->baseDeleteAll($ids)){
            return ['code'=>config('code.success')];
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->baseRepository->getInfoById($id);

        return view('admin.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request, $id)
    {
        if($this->baseRepository->updateByIdWithData($request->all(),$id)){
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->baseRepository->BaseDelete($id)){
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error')];
    }

    /**
     * 权限分配
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function distribute(Request $request,$id)
    {
        $getIdsCa = $this->roleRepository->normData($request->get('quanxun'),$id);
        
        if($request->isMethod('post')){
            $data = [
                'r_id'=>$request->get('r_id'),
                'desc'=>$request->get('desc'),
                'ps_ids'=>$getIdsCa['ps_ids'],
                'ps_ca'=>$getIdsCa['ps_ca'],
            ];
            if($this->baseRepository->updateByIdWithData($data,$data['r_id'])){
                return ['code'=>config('code.success')];
            };
            return ['code'=>config('code.error'),'error'=>'没有修改'];
        }
        $role = $this->baseRepository->getInfoById($id);
        $ps_ids_arr = explode(',',$role->ps_ids);
        $permission_i = $this->permissionRepository->permission_level('0');
        $permission_ii = $this->permissionRepository->permission_level('1');
        $permission_iii = $this->permissionRepository->permission_level('2');
        return view('admin.role.distribute',compact('role','permission_i','permission_ii','permission_iii','ps_ids_arr'));
    }
}
