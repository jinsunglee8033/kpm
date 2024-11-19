<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeRollOverRepositoryInterface;

use App\Models\CampaignTypeRollOver;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeRollOverRepository implements CampaignTypeRollOverRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeRollOver = new CampaignTypeRollOver();

        if ($id) {
            $campaignTypeRollOver = $campaignTypeRollOver
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeRollOver = $campaignTypeRollOver->get();

        return $campaignTypeRollOver;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeRollOver = new campaignTypeRollOver();
        return $campaignTypeRollOver->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeRollOver = new campaignTypeRollOver();
        return $campaignTypeRollOver->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeRollOver::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeRollOver = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeRollOver);

            return $campaignTypeRollOver;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeRollOver = campaignTypeRollOver::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeRollOver) {
            $campaignTypeRollOver->update($params);

            return $campaignTypeRollOver;
        });
    }

    public function delete($id)
    {
        $campaignTypeRollOver  = CampaignTypeRollOver::findOrFail($id);

        return $campaignTypeRollOver->delete();
    }
}
