<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\BaseRepository;
use App\Repositories\ManagerRepository;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\ResetPasswordRequest;

class ManagerController extends Controller
{
    protected $managerRepository;
    protected $baseRepository;

    //构造函数
    public function __construct(ManagerRepository $managerRepository,BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->managerRepository = $managerRepository;
        $this->baseRepository->model = 'Manager';  //给公用方法提供 模型
        $this->baseRepository->id = 'mg_id';  //给公用方法提供 模型
    }
    
    /**
     * layui 分页 搜索 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        error_reporting(0);
        //$query = http_build_query($request->all());
        $datemin = !empty($request->get('datemin')) ? trim($request->get('datemin')) : '';
        $datemax = !empty($request->get('datemax')) ? trim($request->get('datemax')) : '';
        $key = !empty($request->get('key')) ? $request->get('key') : '';

        $this->baseRepository->currPageAndSize($request->all());
        //分页逻辑 当前页
        $page = $this->baseRepository->page;
        //显示的数量
        $size = $this->baseRepository->size;
        //起始位置
        $form = $this->baseRepository->form;

        $manager = $this->managerRepository->getManagerByCondition($request->all(),$form,$size);
        $total = $this->managerRepository->getManagerByCondetionCount($request->all());
        $pageTotal = ceil($total/$size);
       
        return view('admin.manager.index',compact(
            'manager',
            'total',
            'page',
            'pageTotal',
            'query',
            'datemin',
            'datemax',
            'key'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleNameAndId = $this->managerRepository->roleNameAndId();
        
        return view('admin.manager.create',compact('roleNameAndId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManagerRequest $request)
    {
        if($this->managerRepository->managerUnique($request->get('mg_name'))){   //是否唯一  唯一的 true 不唯一 false 
            return ['code'=>config('code.error'),'error'=>'该管理员已经存在了'];
        };  

        $data = array_except($request->all(),['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        if($this->baseRepository->BaseSave($data)){
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
        $manager = $this->baseRepository->getInfoById($id);
        $roleNameAndId = $this->managerRepository->roleNameAndId();

        return view('admin.manager.edit',compact('roleNameAndId','manager'));
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
        $data = $request->all();
        if($this->managerRepository->changePassword($data['password'],$id)){    //true 修改了 false 没有修改
            $data['password'] = Hash::make($data['password']);
        };    
        if($this->baseRepository->updateByIdWithData($data,$data['mg_id'])){    
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error'),'error'=>'修改失败了'];
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
     * 状态
     *
     * @param  int  $id
     * @return 
     */
    public function status(Request $request)
    {
        if($this->baseRepository->BaseSetStatus($request->all())){
            return ['code'=>config('code.success')];
        };

        return ['code'=>config('code.error')];
    }

    /**
     * 显示
     *
     * @param  int  $id
     * @return 
     */
    public function reset(Request $request)
    {
        return view('admin.manager.reset');
    }

    /**
     * 修改动作
     *
     * @param  int  $id
     * @return 
     */
    public function doreset(ResetPasswordRequest $request)
    {
        $mg_id = Auth::guard('back')->user()->mg_id;

        if(!$this->managerRepository->checkPasswordSameById($mg_id,$request->get('oldpassword'))){  //true => 密码一致  &&  false => 密码不一致
            return ['code'=>config('code.error'),'error'=>'初始密码不对哦!'];
        };
        $data = [
            'password' => Hash::make($request->get('password'))
        ];

        if( $this->baseRepository->updateByIdWithData($data,$mg_id) ){
            Auth::guard('back')->logout();
            return ['code'=>config('code.success')];
        };
        return ['code'=>config('code.error'),'error'=>'error'];

    }
}
