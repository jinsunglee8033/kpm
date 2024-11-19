<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeStoreFrontRepositoryInterface;

use App\Models\CampaignTypeStoreFront;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeStoreFrontRepository implements CampaignTypeStoreFrontRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeStoreFront = new CampaignTypeStoreFront();

        if ($id) {
            $campaignTypeStoreFront = $campaignTypeStoreFront
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeStoreFront = $campaignTypeStoreFront->get();

        return $campaignTypeStoreFront;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeStoreFront = new campaignTypeStoreFront();
        return $campaignTypeStoreFront->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeStoreFront = new campaignTypeStoreFront();
        return $campaignTypeStoreFront->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeStoreFront::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeStoreFront = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeStoreFront);

            return $campaignTypeStoreFront;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeStoreFront = campaignTypeStoreFront::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeStoreFront) {
            $campaignTypeStoreFront->update($params);

            return $campaignTypeStoreFront;
        });
    }

    public function delete($id)
    {
        $campaignTypeStoreFront  = CampaignTypeStoreFront::findOrFail($id);

        return $campaignTypeStoreFront->delete();
    }
}
