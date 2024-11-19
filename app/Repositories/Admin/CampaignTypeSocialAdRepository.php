<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeSocialAdRepositoryInterface;

use App\Models\CampaignTypeSocialAd;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeSocialAdRepository implements CampaignTypeSocialAdRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeSocialAd = new CampaignTypeSocialAd();

        if ($id) {
            $campaignTypeSocialAd = $campaignTypeSocialAd
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeSocialAd = $campaignTypeSocialAd->get();

        return $campaignTypeSocialAd;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeSocialAd = new campaignTypeSocialAd();
        return $campaignTypeSocialAd->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeSocialAd = new campaignTypeSocialAd();
        return $campaignTypeSocialAd->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeSocialAd::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeSocialAd = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeSocialAd);

            return $campaignTypeSocialAd;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeSocialAd = campaignTypeSocialAd::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeSocialAd) {
            $campaignTypeSocialAd->update($params);

            return $campaignTypeSocialAd;
        });
    }

    public function delete($id)
    {
        $campaignTypeSocialAd  = CampaignTypeSocialAd::findOrFail($id);

        return $campaignTypeSocialAd->delete();
    }
}
