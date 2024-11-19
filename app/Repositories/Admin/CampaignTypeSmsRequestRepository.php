<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\Interfaces\CampaignTypeSmsRequestRepositoryInterface;
use DB;

use App\Models\CampaignTypeSmsRequest;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeSmsRequestRepository implements CampaignTypeSmsRequestRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeSmsRequest = new CampaignTypeSmsRequest();

        if ($id) {
            $campaignTypeSmsRequest = $campaignTypeSmsRequest
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeSmsRequest = $campaignTypeSmsRequest->get();

        return $campaignTypeSmsRequest;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeSmsRequest = new CampaignTypeSmsRequest();
        return $campaignTypeSmsRequest->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeSmsRequest = new CampaignTypeSmsRequest();
        return $campaignTypeSmsRequest->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return CampaignTypeSmsRequest::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeSmsRequest = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeSmsRequest);

            return $campaignTypeSmsRequest;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeSmsRequest = CampaignTypeSmsRequest::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeSmsRequest) {
            $campaignTypeSmsRequest->update($params);

            return $campaignTypeSmsRequest;
        });
    }

    public function delete($id)
    {
        $campaignTypeSmsRequest  = CampaignTypeSmsRequest::findOrFail($id);

        return $campaignTypeSmsRequest->delete();
    }
}
