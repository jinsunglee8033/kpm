<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignNotesRepositoryInterface;

use App\Models\CampaignNotes;

class CampaignNotesRepository implements CampaignNotesRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignNotes = new CampaignNotes();

        if ($id) {
            $campaignNotes = $campaignNotes
                ->where('id', $id);
        }

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $campaignNotes = $campaignNotes->orderBy($field, $sort);
            }
        }

        if ($perPage) {
            return $campaignNotes->paginate($perPage);
        }

        $campaignNotes = $campaignNotes->get();

        return $campaignNotes;
    }

    public function findById($id)
    {
        return campaignNotes::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignNotes = campaignNotes::create($params);
//            $this->syncRolesAndPermissions($params, $campaignBrand);

            return $campaignNotes;
        });
    }

    public function update($id, $params = [])
    {
        $campaignNotes = campaignNote::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignNotes) {
            $campaignNotes->update($params);

            return $campaignNotes;
        });
    }

    public function delete($id)
    {
        $campaignNotes  = campaignNote::findOrFail($id);

        return $campaignNotes->delete();
    }
}
