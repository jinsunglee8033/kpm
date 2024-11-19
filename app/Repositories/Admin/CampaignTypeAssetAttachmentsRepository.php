<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeAssetAttachmentsRepositoryInterface;

use App\Models\CampaignTypeAssetAttachments;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeAssetAttachmentsRepository implements CampaignTypeAssetAttachmentsRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeAssetAttachments = new CampaignTypeAssetAttachments();

        if ($id) {
            $campaignTypeAssetAttachments = $campaignTypeAssetAttachments
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeAssetAttachments = $campaignTypeAssetAttachments->get();

        return $campaignTypeAssetAttachments;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeAssetAttachments = new CampaignTypeAssetAttachments();
        return $campaignTypeAssetAttachments->where('asset_id', $asset_id)->orderBy('attachment', 'desc')->get();
    }

    public function findAllQrCode()
    {
        $campaignTypeAssetAttachments = new CampaignTypeAssetAttachments();
        return $campaignTypeAssetAttachments->where('type', 'qr_code')->orderBy('created_at', 'desc')->get();
    }

    public function findQrCodeById($qr_code_id)
    {
        $campaignTypeAssetAttachments = new CampaignTypeAssetAttachments();
        return $campaignTypeAssetAttachments->where('type', 'qr_code')->where('id', $qr_code_id)->orderBy('attachment', 'desc')->get();
    }

    public function findById($id)
    {
        return campaignTypeAssetAttachments::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeAttachments = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeAttachments);

            return $campaignTypeAttachments;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeAttachments = Campaign::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeAttachments) {
            $campaignTypeAttachments->update($params);

            return $campaignTypeAttachments;
        });
    }

    public function delete($id)
    {
        $campaignTypeAssetAttachments  = CampaignTypeAssetAttachments::findOrFail($id);

        return $campaignTypeAssetAttachments->delete();
    }
}
