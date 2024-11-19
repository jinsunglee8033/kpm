<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeWebsiteBannersRepositoryInterface;

use App\Models\CampaignTypeWebsiteBanners;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeWebsiteBannersRepository implements CampaignTypeWebsiteBannersRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeWebsiteBanners = new CampaignTypeWebsiteBanners();

        if ($id) {
            $campaignTypeWebsiteBanners = $campaignTypeWebsiteBanners
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeWebsiteBanners = $campaignTypeWebsiteBanners->get();

        return $campaignTypeWebsiteBanners;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeWebsiteBanners = new campaignTypeWebsiteBanners();
        return $campaignTypeWebsiteBanners->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeWebsiteBanners = new campaignTypeWebsiteBanners();
        return $campaignTypeWebsiteBanners->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeWebsiteBanners::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeWebsiteBanners = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeWebsiteBanners);

            return $campaignTypeWebsiteBanners;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeWebsiteBanners = campaignTypeWebsiteBanners::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeWebsiteBanners) {
            $campaignTypeWebsiteBanners->update($params);

            return $campaignTypeWebsiteBanners;
        });
    }

    public function delete($id)
    {
        $campaignTypeWebsiteBanners  = CampaignTypeWebsiteBanners::findOrFail($id);

        return $campaignTypeWebsiteBanners->delete();
    }
}
