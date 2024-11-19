<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeWebsiteChangesRepositoryInterface;

use App\Models\CampaignTypeWebsiteChanges;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeWebsiteChangesRepository implements CampaignTypeWebsiteChangesRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeWebsiteChanges = new CampaignTypeWebsiteChanges();

        if ($id) {
            $campaignTypeWebsiteChanges = $campaignTypeWebsiteChanges
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeWebsiteChanges = $campaignTypeWebsiteChanges->get();

        return $campaignTypeWebsiteChanges;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeWebsiteChanges = new campaignTypeWebsiteChanges();
        return $campaignTypeWebsiteChanges->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeWebsiteChanges = new campaignTypeWebsiteChanges();
        return $campaignTypeWebsiteChanges->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeWebsiteChanges::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeWebsiteChanges = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeWebsiteChanges);

            return $campaignTypeWebsiteChanges;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeWebsiteChanges = campaignTypeWebsiteChanges::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeWebsiteChanges) {
            $campaignTypeWebsiteChanges->update($params);

            return $campaignTypeWebsiteChanges;
        });
    }

    public function delete($id)
    {
        $campaignTypeWebsiteChanges  = CampaignTypeWebsiteChanges::findOrFail($id);

        return $campaignTypeWebsiteChanges->delete();
    }
}
