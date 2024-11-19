<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeInfoGraphicRepositoryInterface;

use App\Models\CampaignTypeInfoGraphic;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeInfoGraphicRepository implements CampaignTypeInfoGraphicRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeInfoGraphic = new CampaignTypeInfoGraphic();

        if ($id) {
            $campaignTypeInfoGraphic = $campaignTypeInfoGraphic
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeInfoGraphic = $campaignTypeInfoGraphic->get();

        return $campaignTypeInfoGraphic;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeInfoGraphic = new campaignTypeInfoGraphic();
        return $campaignTypeInfoGraphic->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeInfoGraphic = new campaignTypeInfoGraphic();
        return $campaignTypeInfoGraphic->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeInfoGraphic::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeInfoGraphic = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeInfoGraphic);

            return $campaignTypeInfoGraphic;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeInfoGraphic = campaignTypeInfoGraphic::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeInfoGraphic) {
            $campaignTypeInfoGraphic->update($params);

            return $campaignTypeInfoGraphic;
        });
    }

    public function delete($id)
    {
        $campaignTypeInfoGraphic  = CampaignTypeInfoGraphic::findOrFail($id);

        return $campaignTypeInfoGraphic->delete();
    }
}
