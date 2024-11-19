<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeLandingPageRepositoryInterface;

use App\Models\CampaignTypeLandingPage;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeLandingPageRepository implements CampaignTypeLandingPageRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeLandingPage = new CampaignTypeLandingPage();

        if ($id) {
            $campaignTypeLandingPage = $campaignTypeLandingPage
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeLandingPage = $campaignTypeLandingPage->get();

        return $campaignTypeLandingPage;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeLandingPage = new campaignTypeLandingPage();
        return $campaignTypeLandingPage->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeLandingPage = new campaignTypeLandingPage();
        return $campaignTypeLandingPage->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeLandingPage::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeLandingPage = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeLandingPage);

            return $campaignTypeLandingPage;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeLandingPage = CampaignTypeLandingPage::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeLandingPage) {
            $campaignTypeLandingPage->update($params);

            return $campaignTypeLandingPage;
        });
    }

    public function delete($id)
    {
        $campaignTypeLandingPage  = CampaignTypeLandingPage::findOrFail($id);

        return $campaignTypeLandingPage->delete();
    }
}
