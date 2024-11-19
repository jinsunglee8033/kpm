<?php

namespace App\Repositories\Admin;

use DB;

use App\Repositories\Admin\Interfaces\CampaignTypeProgrammaticBannersRepositoryInterface;

use App\Models\CampaignTypeProgrammaticBanners;
use Illuminate\Database\Eloquent\Model;

class CampaignTypeProgrammaticBannersRepository implements CampaignTypeProgrammaticBannersRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];
        $id = $options['id'] ?? [];

        $campaignTypeProgrammaticBanners = new CampaignTypeProgrammaticBanners();

        if ($id) {
            $campaignTypeProgrammaticBanners = $campaignTypeProgrammaticBanners
                ->where('id', $id)->where('asset_id', 0);
        }

        $campaignTypeProgrammaticBanners = $campaignTypeProgrammaticBanners->get();

        return $campaignTypeProgrammaticBanners;
    }

    public function findAllByAssetId($asset_id)
    {
        $campaignTypeProgrammaticBanners = new campaignTypeProgrammaticBanners();
        return $campaignTypeProgrammaticBanners->where('asset_id', $asset_id)->get();
    }

    public function deleteByAssetId($asset_id)
    {
        $campaignTypeProgrammaticBanners = new campaignTypeProgrammaticBanners();
        return $campaignTypeProgrammaticBanners->where('asset_id', $asset_id)->delete();
    }

    public function findById($id)
    {
        return campaignTypeProgrammaticBanners::findOrFail($id);
    }

    public function create($params = [])
    {
        return DB::transaction(function () use ($params) {
            $campaignTypeProgrammaticBanners = campaignTypeAssetAttachments::create($params);
            $this->syncRolesAndPermissions($params, $campaignTypeProgrammaticBanners);

            return $campaignTypeProgrammaticBanners;
        });
    }

    public function update($id, $params = [])
    {
        $campaignTypeProgrammaticBanners = campaignTypeProgrammaticBanners::findOrFail($id);

        return DB::transaction(function () use ($params, $campaignTypeProgrammaticBanners) {
            $campaignTypeProgrammaticBanners->update($params);

            return $campaignTypeProgrammaticBanners;
        });
    }

    public function delete($id)
    {
        $campaignTypeProgrammaticBanners  = CampaignTypeProgrammaticBanners::findOrFail($id);

        return $campaignTypeProgrammaticBanners->delete();
    }
}
