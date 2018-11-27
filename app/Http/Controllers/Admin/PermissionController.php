<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\PermissionRepository;
use App\Http\Requests\StorePermissionRequest;

class PermissionController extends Controller
{

    //私有属性
    protected $baseRepository;
    protected $permissionRepository;

    //构造函数
    public function __construct(PermissionRepository $permissionRepository,BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->permissionRepository = $permissionRepository;
        $this->baseRepository->model = 'permission';
        $this->baseRepository->id = 'ps_id';
    }        
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree = $this->permissionRepository->getPnameTree();
        $count = $this->permissionRepository->count();

        return view('admin.permission.index',compact('tree','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tree = $this->permissionRepository->getPnameTree();
        
        return view('admin.permission.create',compact('tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        if($this->permissionRepository->permissionUique($request->get('ps_name'))){     // return true => 为重复 false => 不重复
            return ['code'=>config('code.error'),'error'=>'权限名称不可以重复的呢!'];
        };
        //判断一个权限的层级修改导入数据库的数据
        $data = $this->permissionRepository->setLevel($request->all());

        if($this->baseRepository->BaseSave($data)){
            return ['code'=>config('code.success')];
        };

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tree = $this->permissionRepository->getPnameTree();
        $permission = $this->baseRepository->getInfoById($id);

        return view('admin.permission.edit',compact('tree','permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //判断一个权限的层级修改导入数据库的数据
        $data = $this->permissionRepository->setLevel($request->all());

        //更新指定的数据源
        if($this->baseRepository->updateByIdWithData($data,$id)){
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error'),'error'=>'更新失败!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //是否有爸爸
        if($this->permissionRepository->isHaveFather($id)){
            return ['code'=>config('code.error'),'error'=>'此物有子类!'];
        };
        //删除操作
        if($this->baseRepository->BaseDelete($id)){
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error'),'error'=>'删除操作失败!请重新执行'];
    }
}
