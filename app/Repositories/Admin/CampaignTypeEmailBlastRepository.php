<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeEmailBlastRepositoryInterface;

use App\Models\CampaignTypeEmailBlast;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeEmailBlastRepository implements CampaignTypeEmailBlastRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeEmailBlast = new CampaignTypeEmailBlast();

        if ($id) {
            $campaignTypeEmailBlast = $campaignTypeEmailBlast
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeEmailBlast = $campaignTypeEmailBlast->get();

        return $campaignTypeEmailBlast;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeEmailBlast = new campaignTypeEmailBlast();
        return $campaignTypeEmailBlast->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeEmailBlast = new campaignTypeEmailBlast();
        $obj = $campaignTypeEmailBlast->where('asset_id', $asset_id)->delete();
        return $obj;
    }

    public function findById($id)
    {
        return campaignTypeEmailBlast::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeEmailBlast = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeEmailBlast);

            return $campaignTypeEmailBlast;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeEmailBlast = CampaignTypeEmailBlast::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeEmailBlast) {
            $campaignTypeEmailBlast->update($params);

            return $campaignTypeEmailBlast;
        });
    }

    public function delete($id)
    {
        $campaignTypeEmailBlast  = CampaignTypeEmailBlast::findOrFail($id);

        return $campaignTypeEmailBlast->delete();
    }
}
