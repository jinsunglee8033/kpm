<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CampaignController as AdminCampaign;
use App\Http\Controllers\Admin\ArchivesController as AdminArchives;
use App\Http\Controllers\Admin\DeletedController as AdminDeleted;
use App\Http\Controllers\Admin\AssetController as AdminAsset;
use App\Http\Controllers\Admin\RoleController as AdminRole;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\BrandController as AdminBrand;
use App\Http\Controllers\Admin\FormController as AdminForm;
use App\Http\Controllers\Admin\DevController as AdminDev;
use App\Http\Controllers\Admin\CopyController as AdminCopy;
use App\Http\Controllers\Admin\AssetOwnerController as AdminAssetOwner;
use App\Http\Controllers\Admin\AssetLeadTimeController as AdminAssetLeadTime;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\NotifyController as NotifyController;
use App\Http\Controllers\Auth\ForgotPasswordController as ForgotPasswordController;
use App\Mail\SendMail as SendMail;
use App\Mail\MyDemoMail as MyDemoMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

//Route for mailing
Route::get('/email', function() {
    Mail::to('jinsunglee.8033@gmail.com')->send(new SendMail());
    return new SendMail();
});

Route::get('/email_test', [SendMail::class, 'email_send'])->name('email_send');
//Route::get('/my_demo_mail',[MyDemoMail::class, 'myDemoMail'])->name('my_demo_mail');

Route::get('/email_copy_request', [NotifyController::class, 'copy_request']);
Route::get('/email_copy_review', [NotifyController::class, 'copy_review']);

Route::get('/notification/reminder_email', [NotifyController::class, 'reminder_email']);
Route::get('/notification/clean_up_projects', [NotifyController::class, 'clean_up_projects']);
Route::get('/notification/test', [NotifyController::class, 'test']);

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/test', [AdminDashboard::class, 'test'])->name('dashboard.test');

    Route::get('roles/reload-permissions/{id}', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::get('roles/reload-permissions', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::resource('roles', AdminRole::class);

    Route::resource('users', AdminUser::class);
    Route::resource('brands', AdminBrand::class);
    Route::resource('asset_lead_time', AdminAssetLeadTime::class);
    Route::resource('asset_owners', AdminAssetOwner::class);
//    Route::resource('form', AdminForm::class);

    Route::get('create_qr_code', [AdminForm::class, 'create_qr_code'])->name('form.create_qr_code');
    Route::get('index_qr_code', [AdminForm::class, 'index_qr_code'])->name('form.index_qr_code');
    Route::get('edit_qr_code/{id}', [AdminForm::class, 'edit_qr_code'])->name('form.edit_qr_code');
    Route::post('update_qr_code/{id}', [AdminForm::class, 'update_qr_code'])->name('form.update_qr_code');

    Route::resource('dev', AdminDev::class);
    Route::get('dev/create', [AdminDev::class, 'create'])->name('dev.create');
    Route::get('dev_jira', [AdminDev::class, 'dev_jira'])->name('dev.dev_jira');
    Route::get('campaign/fileRemove/{id}', [AdminCampaign::class, 'fileRemove'])->name('campaign.fileRemove');
    Route::get('dev/fileRemove/{id}', [AdminDev::class, 'fileRemove'])->name('dev.fileRemove');
    Route::get('dev_approval', [AdminDev::class, 'dev_approval'])->name('dev.approval');
    Route::get('dev_archives', [AdminDev::class, 'dev_archives'])->name('dev.archives');
    Route::post('dev/dev_add_note', [AdminDev::class, 'dev_add_note'])->name('dev.dev_add_note');
    Route::post('dev/assign', [AdminDev::class, 'dev_assign'])->name('dev.assign');
    Route::get('dev/dev_in_progress/{id}', [AdminDev::class, 'dev_in_progress'])->name('dev.dev_in_progress');
    Route::get('dev/dev_review/{id}', [AdminDev::class, 'dev_review'])->name('dev.dev_review');
    Route::get('dev/dev_done/{id}', [AdminDev::class, 'dev_done'])->name('dev.dev_done');


    Route::resource('copy', AdminCopy::class);
    Route::get('copy/create', [AdminCopy::class, 'create'])->name('copy.create');
    Route::get('copy_jira', [AdminCopy::class, 'copy_jira'])->name('copy.copy_jira');
    //Route::get('campaign/fileRemove/{id}', [AdminCampaign::class, 'fileRemove'])->name('campaign.fileRemove');
    Route::get('copy/fileRemove/{id}', [AdminCopy::class, 'fileRemove'])->name('copy.fileRemove');
    Route::get('copy_approval', [AdminCopy::class, 'copy_approval'])->name('copy.approval');
    Route::get('copy_archives', [AdminCopy::class, 'copy_archives'])->name('copy.archives');
    Route::post('copy/copy_add_note', [AdminCopy::class, 'copy_add_note'])->name('copy.copy_add_note');
    Route::post('copy/assign', [AdminCopy::class, 'copy_assign'])->name('copy.assign');
    Route::get('copy/copy_in_progress/{id}', [AdminCopy::class, 'copy_in_progress'])->name('copy.copy_in_progress');
    Route::get('copy/copy_review/{id}', [AdminCopy::class, 'copy_review'])->name('copy.copy_review');
    Route::get('copy/copy_done/{id}', [AdminCopy::class, 'copy_done'])->name('copy.copy_done');
    Route::get('copy/copy_decline/{id}', [AdminCopy::class, 'copy_decline'])->name('copy.copy_decline');

    //------------------



    Route::post('store_qr_code', [AdminForm::class, 'store_qr_code'])->name('form.store_qr_code');

    Route::get('settings/remove/{id}', [AdminSetting::class, 'remove'])->name('settings.update');

    Route::get('settings', [AdminSetting::class, 'index'])->name('settings.update');
    Route::post('settings', [AdminSetting::class, 'update'])->name('settings.update');

    Route::get('campaign', [AdminCampaign::class, 'index'])->name('campaign.index');
    Route::get('campaign/duplicate/{id}',[AdminCampaign::class, 'duplicate'])->name('campaign.duplicate');
    Route::post('campaign/duplicate/{id}','CampaignController@duplicate');
    Route::resource('campaign', AdminCampaign::class);
    Route::get('campaign/archives', [AdminCampaign::class, 'archives'])->name('campaign.archives');

    Route::get('campaign/send_archive/{id}', [AdminCampaign::class, 'sendArchive'])->name('campaign.sendArchive');
    Route::get('campaign/send_active/{id}', [AdminCampaign::class, 'sendActive'])->name('campaign.sendActive');

    Route::get('archives', [AdminArchives::class, 'index'])->name('archives.index');
    Route::resource('archives', AdminArchives::class);

    Route::get('deleted', [AdminDeleted::class, 'index'])->name('deleted.index');
    Route::resource('deleted', AdminDeleted::class);

    Route::get('asset_approval', [AdminAsset::class, 'asset_approval'])->name('asset.approval');
    Route::get('asset_kpi_copy', [AdminAsset::class, 'asset_kpi_copy'])->name('asset.kpi_copy');
    Route::get('asset_kpi', [AdminAsset::class, 'asset_kpi'])->name('asset.kpi');
    Route::get('asset_kpi_content', [AdminAsset::class, 'asset_kpi_content'])->name('asset.kpi_content');
    Route::get('asset_kpi_web', [AdminAsset::class, 'asset_kpi_web'])->name('asset.kpi_web');
    Route::get('asset_approval_copy', [AdminAsset::class, 'asset_approval_copy'])->name('asset.approval_copy');
    Route::get('asset_approval_content', [AdminAsset::class, 'asset_approval_content'])->name('asset.approval_content');
    Route::get('asset_approval_web', [AdminAsset::class, 'asset_approval_web'])->name('asset.approval_web');
    Route::get('asset_assign', [AdminAsset::class, 'asset_assign'])->name('asset.assign');
    Route::get('asset_jira', [AdminAsset::class, 'asset_jira'])->name('asset.jira');
    Route::get('asset_jira_content', [AdminAsset::class, 'asset_jira_content'])->name('asset.jira_content');
    Route::get('asset_jira_web', [AdminAsset::class, 'asset_jira_web'])->name('asset.jira_web');
    Route::get('asset_jira_kec', [AdminAsset::class, 'asset_jira_kec'])->name('asset.jira_kec');
    Route::get('asset_jira_copywriter', [AdminAsset::class, 'asset_jira_copywriter'])->name('asset.jira_copywriter');
    Route::get('asset/{a_id}/{c_id}/{a_type}/detail', [AdminAsset::class, 'asset_detail'])->name('asset.detail');
    Route::get('asset/{a_id}/{c_id}/{a_type}/{brand}/detail_copy', [AdminAsset::class, 'asset_detail_copy'])->name('asset.detail_copy');

    Route::post('asset/team_change', [AdminAsset::class, 'asset_team_change'])->name('asset.team_change');
    Route::post('asset/assign', [AdminAsset::class, 'asset_assign'])->name('asset.assign');
    Route::post('asset/assign_copy', [AdminAsset::class, 'asset_assign_copy'])->name('asset.assign_copy');
    Route::post('asset/assign_change', [AdminAsset::class, 'asset_assign_change'])->name('asset.assign_change');
    Route::post('asset/copy_writer_change', [AdminAsset::class, 'asset_copy_writer_change'])->name('asset.copy_writer_change');
    Route::post('asset/decline_copy', [AdminAsset::class, 'asset_decline_copy'])->name('asset.decline_copy');
    Route::post('asset/decline_creative', [AdminAsset::class, 'asset_decline_creative'])->name('asset.decline_creative');
    Route::post('asset/decline_kec', [AdminAsset::class, 'asset_decline_kec'])->name('asset.decline_kec');

    Route::post('asset/asset_notification_user', [AdminAsset::class, 'asset_notification_user'])->name('asset.asset_notification_user');
    Route::post('asset/asset_owner_change', [AdminAsset::class, 'asset_owner_change'])->name('asset.asset_owner_change');
    Route::post('asset/asset_owner_change_mapping', [AdminAsset::class, 'asset_owner_change_mapping'])->name('asset.asset_owner_change_mapping');
    Route::post('asset/asset_add_note', [AdminAsset::class, 'asset_add_note'])->name('asset.asset_add_note');

    Route::get('asset/copyReview/{id}', [AdminAsset::class, 'copyReview'])->name('campaign.copyReview');
    Route::get('asset/copyComplete/{id}', [AdminAsset::class, 'copyComplete'])->name('campaign.copyComplete');
    Route::get('asset/copyInProgress/{id}', [AdminAsset::class, 'copyInProgress'])->name('campaign.copyInProgress');
    Route::get('asset/inProgress/{id}', [AdminAsset::class, 'inProgress'])->name('campaign.inProgress');
    Route::get('asset/done/{id}', [AdminAsset::class, 'done'])->name('campaign.done');
    Route::get('asset/finalApproval/{id}', [AdminAsset::class, 'finalApproval'])->name('campaign.finalApproval');

    Route::get('campaign/fileRemove/{id}', [AdminCampaign::class, 'fileRemove'])->name('campaign.fileRemove');

    Route::get('campaign/assetRemove/{a_id}/{type}', [AdminCampaign::class, 'assetRemove'])->name('campaign.assetRemove');
    Route::get('campaign/campaignRemove/{c_id}', [AdminCampaign::class, 'campaignRemove'])->name('campaign.campaignRemove');

    Route::post('campaign/add_email_blast', [AdminCampaign::class, 'add_email_blast'])->name('campaign.add_email_blast');
    Route::post('campaign/add_social_ad', [AdminCampaign::class, 'add_social_ad'])->name('campaign.add_social_ad');
    Route::post('campaign/add_website_banners', [AdminCampaign::class, 'add_website_banners'])->name('campaign.add_website_banners');
    Route::post('campaign/add_website_changes', [AdminCampaign::class, 'add_website_changes'])->name('campaign.add_website_changes');
    Route::post('campaign/add_landing_page', [AdminCampaign::class, 'add_landing_page'])->name('campaign.add_landing_page');
    Route::post('campaign/add_misc', [AdminCampaign::class, 'add_misc'])->name('campaign.add_misc');
    Route::post('campaign/add_sms_request', [AdminCampaign::class, 'add_sms_request'])->name('campaign.add_sms_request');
    Route::post('campaign/add_topcategories_copy', [AdminCampaign::class, 'add_topcategories_copy'])->name('campaign.add_topcategories_copy');
    Route::post('campaign/add_programmatic_banners', [AdminCampaign::class, 'add_programmatic_banners'])->name('campaign.add_programmatic_banners');
    Route::post('campaign/add_image_request', [AdminCampaign::class, 'add_image_request'])->name('campaign.add_image_request');
    Route::post('campaign/add_roll_over', [AdminCampaign::class, 'add_roll_over'])->name('campaign.add_roll_over');
    Route::post('campaign/add_store_front', [AdminCampaign::class, 'add_store_front'])->name('campaign.add_store_front');
    Route::post('campaign/add_a_content', [AdminCampaign::class, 'add_a_content'])->name('campaign.add_a_content');
    Route::post('campaign/add_youtube_copy', [AdminCampaign::class, 'add_youtube_copy'])->name('campaign.add_youtube_copy');
    Route::post('campaign/add_info_graphic', [AdminCampaign::class, 'add_info_graphic'])->name('campaign.add_info_graphic');

    Route::post('campaign/edit_email_blast/{asset_id}', [AdminCampaign::class, 'edit_email_blast'])->name('campaign.edit_email_blast');
    Route::post('campaign/edit_social_ad/{asset_id}', [AdminCampaign::class, 'edit_social_ad'])->name('campaign.edit_social_ad');
    Route::post('campaign/edit_website_banners/{asset_id}', [AdminCampaign::class, 'edit_website_banners'])->name('campaign.edit_website_banners');
    Route::post('campaign/edit_website_changes/{asset_id}', [AdminCampaign::class, 'edit_website_changes'])->name('campaign.edit_website_changes');
    Route::post('campaign/edit_landing_page/{asset_id}', [AdminCampaign::class, 'edit_landing_page'])->name('campaign.edit_landing_page');
    Route::post('campaign/edit_misc/{asset_id}', [AdminCampaign::class, 'edit_misc'])->name('campaign.edit_misc');
    Route::post('campaign/edit_sms_request/{asset_id}', [AdminCampaign::class, 'edit_sms_request'])->name('campaign.edit_sms_request');
    Route::post('campaign/edit_topcategories_copy/{asset_id}', [AdminCampaign::class, 'edit_topcategories_copy'])->name('campaign.edit_topcategories_copy');
    Route::post('campaign/edit_programmatic_banners/{asset_id}', [AdminCampaign::class, 'edit_programmatic_banners'])->name('campaign.edit_programmatic_banners');
    Route::post('campaign/edit_image_request/{asset_id}', [AdminCampaign::class, 'edit_image_request'])->name('campaign.edit_image_request');
    Route::post('campaign/edit_roll_over/{asset_id}', [AdminCampaign::class, 'edit_roll_over'])->name('campaign.edit_roll_over');
    Route::post('campaign/edit_store_front/{asset_id}', [AdminCampaign::class, 'edit_store_front'])->name('campaign.edit_store_front');
    Route::post('campaign/edit_a_content/{asset_id}', [AdminCampaign::class, 'edit_a_content'])->name('campaign.edit_a_content');
    Route::post('campaign/edit_youtube_copy/{asset_id}', [AdminCampaign::class, 'edit_youtube_copy'])->name('campaign.edit_youtube_copy');
    Route::post('campaign/edit_info_graphic/{asset_id}', [AdminCampaign::class, 'edit_info_graphic'])->name('campaign.edit_info_graphic');

});
