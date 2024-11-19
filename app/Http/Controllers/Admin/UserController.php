<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\Interfaces\RoleRepositoryInterface;
use App\Repositories\Admin\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Admin\Interfaces\UserRepositoryInterface;

use App\Repositories\Admin\UserRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\PermissionRepository;

use App\Repositories\Admin\CampaignBrandsRepository;

use App\Authorizable;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;
    private $campaignBrandsRepository;

    public function __construct(UserRepository $userRepository, CampaignBrandsRepository $campaignBrandsRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->campaignBrandsRepository = $campaignBrandsRepository;

        $this->data['currentAdminMenu'] = 'users';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['filter'] = $params;
        $this->data['users'] = $this->userRepository->findAll($options);
        $this->data['teams_'] = [
            'KISS E-Commerce',
            'KISS Sales',
            'Creative',
            'Business Division',
            'Trade Marketing',
            'CPA',
            'AST',
            'MeAmora',
            'Joah',
        ];
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Copywriter Manager' => 'copywriter manager',
            'Copywriter' => 'copywriter',
            'Developer Manager' => 'developer manager',
            'Developer' => 'developer',
            'Ecommerce Specialist' => 'ecommerce specialist',
            'Social Media Manager' => 'social media manager',
            'Marketing' => 'marketing',
            'Creative Director' => 'creative director',
            'Creative Senior Director' => 'creative senior director',
            'Graphic Designer' => 'graphic designer',
            'Content Manager' => 'content manager',
            'Content Creator' => 'content creator',
            'Web Production Manager' => 'web production manager',
            'Web Production' => 'web production',
            'Videographer' => 'videographer',
        ];
        $this->data['team_'] = !empty($params['team']) ? $params['team'] : '';
        $this->data['role_'] = !empty($params['role']) ? $params['role'] : '';

        return view('admin.users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
        $this->data['teams'] = [
            'KISS E-Commerce',
            'KISS Sales',
            'Creative',
            'Business Division',
            'Trade Marketing',
            'CPA',
            'AST',
            'MeAmora',
            'Joah',
        ];
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Copywriter Manager' => 'copywriter manager',
            'Copywriter' => 'copywriter',
            'Developer Manager' => 'developer manager',
            'Developer' => "developer",
            'Ecommerce Specialist' => 'ecommerce specialist',
            'Social Media Manager' => 'social media manager',
            'Marketing' => 'marketing',
            'Creative Director' => 'creative director',
            'Creative Senior Director' => 'creative senior director',
            'Graphic Designer' => 'graphic designer',
            'Content Manager' => 'content manager',
            'Content Creator' => 'content creator',
            'Web Production Manager' => 'web production manager',
            'Web Production' => 'web production',
            'Videographer' => 'videographer',
        ];
        $this->data['access_levels'] = [
            'Affiliate',
            'Customer Service',
            'Ecommerce',
            'Customer Service / Ecommerce',
            'Admin',
            'Call Center',
            'IT'
        ];
        $this->data['is_active'] = [
            'YES' => 'yes',
            'NO' => 'no',
        ];
        $this->data['roleId'] = null;
        $this->data['access_level'] = null;
        $this->data['team'] = null;
        $this->data['role_'] = null;
        $this->data['user_brand'] = null;
        $this->data['is_active_'] = null;

        return view('admin.users.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $params = $request->validated();

        $params['password'] = Hash::make($params['password']);

        if (isset($params['user_brand'])) {
            $params['user_brand'] = implode(', ', $params['user_brand']);
        } else {
            $params['user_brand'] = '';
        }

        if ($this->userRepository->create($params)) {
            return redirect('admin/users')
                ->with('success', __('users.success_create_message'));
        }

        return redirect('admin/users/create')
            ->with('error', __('users.fail_create_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = $this->userRepository->findById($id);

        return view('admin.users.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( ($id != auth()->user()->id) && (auth()->user()->role !='admin') ) {
            return redirect('admin/campaign')
                ->with('error', 'Could not change.');
        }

        $user = $this->userRepository->findById($id);

        $this->data['user'] = $user;
        $this->data['team'] = $user->team;
        $this->data['role_'] = $user->role;
        $this->data['user_brand'] = $user->user_brand;
        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
        $this->data['is_active_'] = $user->is_active;
        $this->data['is_active'] = [
            'YES' => 'yes',
            'NO' => 'no',
        ];
        $this->data['teams'] = [
            'KISS E-Commerce',
            'KISS Sales',
            'Creative',
            'Business Division',
            'Trade Marketing',
            'CPA',
            'AST',
            'MeAmora',
            'Joah',
        ];
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Copywriter Manager' => 'copywriter manager',
            'Copywriter' => 'copywriter',
            'Developer Manager' => 'developer manager',
            'Developer' => 'developer',
            'Ecommerce Specialist' => 'ecommerce specialist',
            'Social Media Manager' => 'social media manager',
            'Marketing' => 'marketing',
            'Creative Director' => 'creative director',
            'Creative Senior Director' => 'creative senior director',
            'Graphic Designer' => 'graphic designer',
            'Content Manager' => 'content manager',
            'Content Creator' => 'content creator',
            'Web Production Manager' => 'web production manager',
            'Web Production' => 'web production',
            'Videographer' => 'videographer',
        ];
        return view('admin.users.form', $this->data);
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
        $user = $this->userRepository->findById($id);
        $param = $request->request->all();
        $log_user = auth()->user();

        if($log_user['role'] != 'admin'){
            if($param['password'] == null){
                return redirect('admin/users/'.$id.'/edit')
                    ->with('error', 'Please enter your password to update');
            }
        }

        if (isset($param['user_brand'])) {
            $param['user_brand'] = implode(', ', $param['user_brand']);
        } else {
            $param['user_brand'] = '';
        }

        if ($this->userRepository->update($id, $param)) {
            return redirect('admin/users/'.$id.'/edit')
                ->with('success', __('users.success_updated_message', ['first_name' => $user->first_name]));
        }

        return redirect('admin/users/'.$id.'/edit')
                ->with('error', __('users.fail_to_update_message', ['first_name' => $user->first_name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if ($user->id == auth()->user()->id) {
            return redirect('admin/users')
                ->with('error', 'Could not delete yourself.');
        }

        if ($this->userRepository->delete($id)) {
            return redirect('admin/users')
                ->with('success', __('users.success_deleted_message', ['first_name' => $user->first_name]));
        }
        return redirect('admin/users')
                ->with('error', __('users.fail_to_delete_message', ['first_name' => $user->first_name]));
    }
}
