<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\CopyRepositoryInterface;
use DB;

use App\Models\Copy;
use Illuminate\Database\Eloquent\Model;

class CopyRepository implements CopyRepositoryInterface
{
    public function findAll($options = [])
    {
        $copy = new Copy();

        $copy = $copy->orderBy('created_at', 'asc')->get();

        return $copy;
    }

    public function findById($id)
    {
        return Copy::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $copy = Copy::create($params);
            return $copy;
        });
    }

    public function update($id, $params = [])
    {
        $copy = Copy::findOrFail($id);

        return DB::transaction(function () use ($params, $copy) {
            $copy->update($params);

            return $copy;
        });
    }

    public function delete($id)
    {
        $role  = Copy::findOrFail($id);

        return $role->delete();
    }

    public function get_jira_copy_requested($priority, $copywriter)
    {
        if($priority != '') {
            $priority_filter = ' and c.priority ="' . $priority . '" ';
        }else{
            $priority_filter = ' ';
        }

        if($copywriter != '') {
            $copywriter_filter = ' and c.assign_to =' . $copywriter . ' ';
        }else{
            $copywriter_filter = ' ';
        }

        return DB::select(
            'select  c.id as copy_id,
                        c.title as title,
                        c.type as type,
                        c.domain as domain,
                        c.description as description,
                        u.first_name as request_by,
                        v.first_name as assign_to,
                        c.priority as priority,
                        c.status as status,
                        c.created_at as created_at,
                        c.updated_at as updated_at
                from copy c
                left join users u on u.id = c.request_by
                left join users v on v.id = c.assign_to
                where c.status in ("copy_requested")
                  ' . $priority_filter . '
                  ' . $copywriter_filter . '
                order by c.created_at asc');
    }

    public function get_jira_copy_to_do($priority, $copywriter)
    {
        if($priority != '') {
            $priority_filter = ' and c.priority ="' . $priority . '" ';
        }else{
            $priority_filter = ' ';
        }

        if($copywriter != '') {
            $copywriter_filter = ' and c.assign_to =' . $copywriter . ' ';
        }else{
            $copywriter_filter = ' ';
        }

        return DB::select(
            'select  c.id as copy_id,
                        c.title as title,
                        c.type as type,
                        c.domain as domain,
                        c.description as descriptoin,
                        u.first_name as request_by,
                        v.first_name as assign_to,
                        c.priority as priority,
                        c.status as status,
                        c.created_at as created_at,
                        c.updated_at as updated_at
                from copy c
                left join users u on u.id = c.request_by
                left join users v on v.id = c.assign_to
                where c.status in ("copy_to_do")
                  ' . $priority_filter . '
                  ' . $copywriter_filter . '
                order by c.created_at asc');
    }

    public function get_jira_copy_in_progress($priority, $copywriter)
    {
        if($priority != '') {
            $priority_filter = ' and c.priority ="' . $priority . '" ';
        }else{
            $priority_filter = ' ';
        }

        if($copywriter != '') {
            $copywriter_filter = ' and c.assign_to =' . $copywriter . ' ';
        }else{
            $copywriter_filter = ' ';
        }

        return DB::select(
            'select  c.id as copy_id,
                        c.title as title,
                        c.type as type,
                        c.domain as domain,
                        c.description as descriptoin,
                        u.first_name as request_by,
                        v.first_name as assign_to,
                        c.priority as priority,
                        c.status as status,
                        c.created_at as created_at,
                        c.updated_at as updated_at
                from copy c
                left join users u on u.id = c.request_by
                left join users v on v.id = c.assign_to
                where c.status in ("copy_in_progress")
                  ' . $priority_filter . '
                  ' . $copywriter_filter . '
                order by c.created_at asc');
    }

    public function get_jira_copy_review($priority, $copywriter)
    {
        if($priority != '') {
            $priority_filter = ' and c.priority ="' . $priority . '" ';
        }else{
            $priority_filter = ' ';
        }

        if($copywriter != '') {
            $copywriter_filter = ' and c.assign_to =' . $copywriter . ' ';
        }else{
            $copywriter_filter = ' ';
        }

        return DB::select(
            'select  c.id as copy_id,
                        c.title as title,
                        c.type as type,
                        c.domain as domain,
                        c.description as descriptoin,
                        u.first_name as request_by,
                        v.first_name as assign_to,
                        c.priority as priority,
                        c.status as status,
                        c.created_at as created_at,
                        c.updated_at as updated_at
                from copy c
                left join users u on u.id = c.request_by
                left join users v on v.id = c.assign_to
                where c.status in ("copy_review")
                  ' . $priority_filter . '
                  ' . $copywriter_filter . '
                order by c.created_at asc');
    }

    public function get_jira_copy_done($priority, $copywriter)
    {
        if($priority != '') {
            $priority_filter = ' and c.priority ="' . $priority . '" ';
        }else{
            $priority_filter = ' ';
        }

        if($copywriter != '') {
            $copywriter_filter = ' and c.assign_to =' . $copywriter . ' ';
        }else{
            $copywriter_filter = ' ';
        }

        return DB::select(
            'select  c.id as copy_id,
                        c.title as title,
                        c.type as type,
                        c.domain as domain,
                        c.description as descriptoin,
                        u.first_name as request_by,
                        v.first_name as assign_to,
                        c.priority as priority,
                        c.status as status,
                        c.created_at as created_at,
                        c.updated_at as updated_at
                from copy c
                left join users u on u.id = c.request_by
                left join users v on v.id = c.assign_to
                where c.status in ("copy_done")
                  ' . $priority_filter . '
                  ' . $copywriter_filter . '
                and c.updated_at >= DATE_ADD(CURDATE(), INTERVAL -21 DAY)
                order by c.created_at asc');
    }

    public function get_copy_approval_list()
    {
        return DB::select(
            'select c.id as copy_id,
                    c.title as title,
                    c.type as type,
                    c.domain as domain,
                    u.first_name as requested_by,
                    u.first_name as assign_to,
                    c.priority as priority,
                    c.created_at as created_at
                from copy c
                left join users u on u.id = c.request_by
                where c.status = "copy_requested"
                order by c.created_at desc');
    }

    public function get_copy_archives_list()
    {
        return DB::select(
            'select c.id as copy_id,
                    c.title as title,
                    c.type as type,
                    c.domain as domain,
                    u.first_name as requested_by,
                    k.first_name as assign_to,
                    c.priority as priority,
                    c.created_at as created_at
                from copy c
                left join users u on u.id = c.request_by
                left join users k on k.id = c.assign_to
                where c.status = "copy_done"
                order by c.created_at desc');
    }

}
