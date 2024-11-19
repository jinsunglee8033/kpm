<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\CopyNotesRepositoryInterface;
use DB;


use App\Models\CopyNotes;
use Illuminate\Database\Eloquent\Model;

class CopyNotesRepository implements CopyNotesRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $copyNotes = new CopyNotes();

        if ($id) {
            $copyNotes = $copyNotes
                ->where('copy_id', $id);
        }

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $copyNotes = $copyNotes->orderBy($field, $sort);
            }
        }

        if ($perPage) {
            return $copyNotes->paginate($perPage);
        }

        $copyNotes = $copyNotes->get();

        return $copyNotes;
    }

    public function findById($id)
    {
        return CopyNotes::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $copyNotes = campaignNotes::create($params);
//            $this->syncRolesAndPermissions($params, $campaignBrand);

            return $copyNotes;
        });
    }

    public function update($id, $params = [])
    {
        $copyNotes = CopyNotes::findOrFail($id);

        return DB::transaction(function () use ($params, $copyNotes) {
            $copyNotes->update($params);

            return $copyNotes;
        });
    }

    public function delete($id)
    {
        $copyNotes  = CopyNotes::findOrFail($id);

        return $copyNotes->delete();
    }
}
