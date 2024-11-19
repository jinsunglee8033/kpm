<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeImageRequestRepositoryInterface;

use App\Models\CampaignTypeImageRequest;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeImageRequestRepository implements CampaignTypeImageRequestRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeImageRequest = new CampaignTypeImageRequest();

        if ($id) {
            $campaignTypeImageRequest = $campaignTypeImageRequest
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeImageRequest = $campaignTypeImageRequest->get();

        return $campaignTypeImageRequest;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeImageRequest = new campaignTypeImageRequest();
        return $campaignTypeImageRequest->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeImageRequest = new campaignTypeImageRequest();
        return $campaignTypeImageRequest->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeImageRequest::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeImageRequest = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeImageRequest);

            return $campaignTypeImageRequest;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeImageRequest = campaignTypeImageRequest::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeImageRequest) {
            $campaignTypeImageRequest->update($params);

            return $campaignTypeImageRequest;
        });
    }

    public function delete($id)
    {
        $campaignTypeImageRequest  = CampaignTypeImageRequest::findOrFail($id);

        return $campaignTypeImageRequest->delete();
    }
}
