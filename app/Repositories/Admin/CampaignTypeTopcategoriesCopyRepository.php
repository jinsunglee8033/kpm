<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeTopcategoriesCopyRepositoryInterface;

use App\Models\CampaignTypeTopcategoriesCopy;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeTopcategoriesCopyRepository implements CampaignTypeTopcategoriesCopyRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeTopcategoriesCopy = new CampaignTypeTopcategoriesCopy();

        if ($id) {
            $campaignTypeTopcategoriesCopy = $campaignTypeTopcategoriesCopy
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeTopcategoriesCopy = $campaignTypeTopcategoriesCopy->get();

        return $campaignTypeTopcategoriesCopy;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeTopcategoriesCopy = new campaignTypeTopcategoriesCopy();
        return $campaignTypeTopcategoriesCopy->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeTopcategoriesCopy = new campaignTypeTopcategoriesCopy();
        return $campaignTypeTopcategoriesCopy->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeTopcategoriesCopy::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeTopcategoriesCopy = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeTopcategoriesCopy);

            return $campaignTypeTopcategoriesCopy;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeTopcategoriesCopy = campaignTypeTopcategoriesCopy::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeTopcategoriesCopy) {
            $campaignTypeTopcategoriesCopy->update($params);

            return $campaignTypeTopcategoriesCopy;
        });
    }

    public function delete($id)
    {
        $campaignTypeTopcategoriesCopy  = CampaignTypeTopcategoriesCopy::findOrFail($id);

        return $campaignTypeTopcategoriesCopy->delete();
    }
}
