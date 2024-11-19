<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use DB;

use App\Repositories\Admin\Interfaces\UserRepositoryInterface;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

//use App\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $users = new User();
//        $users = (new User())->with('roles');

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $users = $users->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['team'])) {

            $users = $users->Where('team', 'LIKE', "%{$options['filter']['team']}%");
        }

        if (!empty($options['filter']['q'])) {
            $users = $users->Where('first_name', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('last_name', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('email', 'LIKE', "%{$options['filter']['q']}%");
        }

        if (!empty($options['filter']['role'])) {
            $users = $users->Where('role', '=', "{$options['filter']['role']}");
        }

        $users = $users->Where('is_active', '=', 'yes');

        if ($perPage) {
            return $users->paginate($perPage);
        }

        return $users->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $user = User::create($params);
//            $this->syncRolesAndPermissions($params, $user);

            return $user;
        });
    }

    public function update($id, $params = [])
    {
        $user = User::findOrFail($id);

        if (!isset($params['password'])) {
            unset($params['password']);
        }

        return DB::transaction(function () use ($params, $user) {

            if(isset($params['password'])){
                $params['password'] = Hash::make($params['password']);
            }
            $user->update($params);
//            $this->syncRolesAndPermissions($params, $user);

            return $user;
        });
    }

    public function delete($id)
    {
        $user  = User::findOrFail($id);

        return $user->delete();
    }

    public function findByBrandName($brand_name)
    {
        $users = new User();
        $users = $users->Where('user_brand', 'LIKE', "%$brand_name%");
        return $users->get();
    }

    public function getEmailByDesignerName($first_name) 
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")->Where('role', '=', 'graphic designer');
        return $users->get();
    }

    public function getEmailByWebName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('web production', 'web production manager'));
        return $users->get();
    }

    public function getEmailByContentName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('content creator', 'content manager'));
        return $users->get();
    }

    public function getEmailByCopyWriterName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('copywriter', 'copywriter manager'));
        return $users->get();
    }

    public function getJoahDirector()
    {
        $users = new User();
        $users = $users->Where('role', '=', "creative director")->Where('user_brand', 'LIKE', "%JOAH Beauty%");
        return $users->get();
    }

    public function getCreativeDirector()
    {
        $users = new User();
        $users = $users->Where('role', '=', "creative director")->Where('user_brand', 'NOT LIKE', "%JOAH Beauty%");
        return $users->get();
    }

    public function getContentManager()
    {
        $users = new User();
        $users = $users->Where('role', '=', "content manager");
        return $users->get();
    }

    public function getWebProductionManager()
    {
        $users = new User();
        $users = $users->Where('role', '=', "web production manager");
        return $users->get();
    }

    public function getWriterByBrandName($brand_name)
    {
        $users = new User();
        $users = $users->Where('role', '=', "copywriter")->Where('user_brand', 'LIKE', "%$brand_name%");
        return $users->get();
    }

    public function getCopyWriterManager()
    {
        $users = new User();
        $users = $users->Where('role', '=', "copywriter manager");
        return $users->get();
    }

    public function getCopywriterByFirstName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('copywriter', 'copywriter manager'));
        return $users->get();
    }

    public function getAllCopyWriters()
    {
        return DB::select('
            select * from users where role in ("copywriter", "copywriter manager") order by first_name desc
        ');
    }

    public function getBrandsAssignedWriters()
    {
        return DB::select('
            select * from users where role ="copywriter" order by char_length(user_brand) desc
        ');
    }

    public function getDesignerByFirstName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('graphic designer', 'creative director'));
        return $users->get();
    }

    public function getContentByFirstName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('content creator', 'content manager'));
        return $users->get();
    }

    public function getWebByFirstName($first_name)
    {
        $users = new User();
        $users = $users->Where('first_name', '=', "$first_name")
            ->WhereIn('role', array('web production', 'web production manager'));
        return $users->get();
    }

    public function getKissUsers()
    {
        $users = new User();
        $users = $users->get();

        $names = [];

        foreach ($users as $user){
            $full_name = $user['first_name'].' '.$user['last_name'];
            $names[$full_name] = $user['email'];
        }

        return $names;

    }

    public static function getWritersNameByBrand($brand)
    {
        return DB::select('
            select * from users where role = "copywriter" and user_brand like "%'.$brand.'%"
        ');
    }

    public static function getAssetOwnerNameById($id)
    {
        return DB::select('
            select first_name from users where id ='.$id.'
        ');
    }

    public function getDeveloperManager()
    {
        $users = new User();
        $users = $users->Where('role', '=', "developer manager");
        return $users->get();
    }

    public function getDeveloperAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('developer', 'developer manager'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getCopyTicketAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('copywriter', 'copywriter manager'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getCreativeAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('graphic designer', 'creative director'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getContentAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('content creator', 'content manager'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getCopyWriterAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('copywriter', 'copywriter manager'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getWebAssignee()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('role', array('web production', 'web production manager'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getMKTGroupByBrand($brand_name)
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->Where('team', '=', "Business Division")
            ->Where('user_brand', 'LIKE', "%$brand_name%")
            ->orderBy('first_name', 'asc');
        return $users->get();
    }

    public function getAdminGroup()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->Where('role', '=', "admin");
        return $users->get();
    }

    public function getAssetOwners()
    {
        $users = new User();
        $users = $users
            ->Where('is_active', '=', 'yes')
            ->WhereIn('team', array('KISS E-Commerce', 'KISS Sales', 'Trade Marketing'))
            ->orderBy('first_name', 'asc');
        return $users->get();
    }


//    /**
//     * Sync roles and permissions
//     *
//     * @param Request $request
//     * @param $user
//     * @return string
//     */
//    private function syncRolesAndPermissions($params, $user)
//    {
//        // Get the submitted roles
//        $roles = isset($params['role_id']) ? [$params['role_id']] : [];
//        $permissions = isset($params['permissions']) ? $params['permissions'] : [];
//
//        // Get the roles
//        $roles = Role::find($roles);
//
//        // check for current role changes
//        if (!$user->hasAllRoles($roles)) {
//            // reset all direct permissions for user
//            $user->permissions()->sync([]);
//        } else {
//            // handle permissions
//            $user->syncPermissions($permissions);
//        }
//
//        $user->syncRoles($roles);
//
//        return $user;
//    }
}
