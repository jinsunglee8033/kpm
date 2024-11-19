<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeYoutubeCopyRepositoryInterface;

use App\Models\CampaignTypeYoutubeCopy;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeYoutubeCopyRepository implements CampaignTypeYoutubeCopyRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeYoutubeCopy = new CampaignTypeYoutubeCopy();

        if ($id) {
            $campaignTypeYoutubeCopy = $campaignTypeYoutubeCopy
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeYoutubeCopy = $campaignTypeYoutubeCopy->get();

        return $campaignTypeYoutubeCopy;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeYoutubeCopy = new campaignTypeYoutubeCopy();
        return $campaignTypeYoutubeCopy->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeYoutubeCopy = new campaignTypeYoutubeCopy();
        return $campaignTypeYoutubeCopy->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeYoutubeCopy::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeYoutubeCopy = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeYoutubeCopy);

            return $campaignTypeYoutubeCopy;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeYoutubeCopy = campaignTypeYoutubeCopy::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeYoutubeCopy) {
            $campaignTypeYoutubeCopy->update($params);

            return $campaignTypeYoutubeCopy;
        });
    }

    public function delete($id)
    {
        $campaignTypeYoutubeCopy  = CampaignTypeYoutubeCopy::findOrFail($id);

        return $campaignTypeYoutubeCopy->delete();
    }
}
