<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeAContentRepositoryInterface;

use App\Models\CampaignTypeAContent;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeAContentRepository implements CampaignTypeAContentRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeAContent = new CampaignTypeAContent();

        if ($id) {
            $campaignTypeAContent = $campaignTypeAContent
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeAContent = $campaignTypeAContent->get();

        return $campaignTypeAContent;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeAContent = new campaignTypeAContent();
        return $campaignTypeAContent->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeAContent = new campaignTypeAContent();
        return $campaignTypeAContent->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeAContent::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeAContent = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeAContent);

            return $campaignTypeAContent;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeAContent = campaignTypeAContent::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeAContent) {
            $campaignTypeAContent->update($params);

            return $campaignTypeAContent;
        });
    }

    public function delete($id)
    {
        $campaignTypeAContent  = CampaignTypeAContent::findOrFail($id);

        return $campaignTypeAContent->delete();
    }
}
