<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeMiscRepositoryInterface;

use App\Models\CampaignTypeMisc;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeMiscRepository implements CampaignTypeMiscRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeMisc = new CampaignTypeMisc();

        if ($id) {
            $campaignTypeMisc = $campaignTypeMisc
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeMisc = $campaignTypeMisc->get();

        return $campaignTypeMisc;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeMisc = new campaignTypeMisc();
        return $campaignTypeMisc->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeMisc = new campaignTypeMisc();
        return $campaignTypeMisc->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeMisc::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeMisc = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeMisc);

            return $campaignTypeMisc;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeMisc = campaignTypeMisc::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeMisc) {
            $campaignTypeMisc->update($params);

            return $campaignTypeMisc;
        });
    }

    public function delete($id)
    {
        $campaignTypeMisc  = CampaignTypeMisc::findOrFail($id);

        return $campaignTypeMisc->delete();
    }
}
