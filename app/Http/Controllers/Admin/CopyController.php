<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\NotifyController;
use App\Http\Requests\Admin\CopyRequest; //
use App\Mail\AssetMessage;
use App\Mail\CopyTicketMessage; // 
use App\Models\CopyNotes;
use App\Repositories\Admin\CopyFileAttachmentsRepository; // 
use App\Repositories\Admin\CopyNotesRepository; // 
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\CopyFileAttachments; //
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\CampaignBrandsRepository;
use App\Repositories\Admin\CampaignAssetIndexRepository;
use App\Repositories\Admin\CopyRepository;  // 

use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as Download;

class CopyController extends Controller
{
    private $copyRepository;  // 
    private $campaignBrandsRepository;
    private $campaignAssetIndexRepository;
    private $fileAttachmentsRepository;
    private $copyNotesRepository;
    private $userRepository;


    public function __construct(
        CopyRepository $copyRepository, // 
        CampaignBrandsRepository $campaignBrandsRepository,
        CampaignAssetIndexRepository $campaignAssetIndexRepository,
        CopyFileAttachmentsRepository $fileAttachmentsRepository,
        CopyNotesRepository $copyNotesRepository,
        UserRepository $userRepository) // 
    {
        parent::__construct();

        $this->copyRepository = $copyRepository;  // 
        $this->campaignBrandsRepository = $campaignBrandsRepository;
        $this->campaignAssetIndexRepository = $campaignAssetIndexRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->copyNotesRepository = $copyNotesRepository;  // 
        $this->userRepository = $userRepository;

        $this->data['currentAdminMenu'] = 'copy';  // 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['tasks'] = $this->copyRepository->findAll();

        return view('admin.copy.form', $this->data);  // !! 
    }

    public function copy_approval(Request $request)
    {
        $this->data['currentAdminMenu'] = 'copy_approval';
        $params = $request->all();
        $this->data['asset_list'] = $this->campaignAssetIndexRepository->get_request_assets_list_copy('','','','');
        $this->data['copy_list'] = $this->copyRepository->get_copy_approval_list(); // !! 
        $this->data['filter'] = $params;

        return view('admin.copy.approval_list', $this->data);  // 
    }

    public function copy_archives(Request $request)
    {
        $this->data['currentAdminMenu'] = 'copy_archives'; // 
        $params = $request->all();

        $this->data['copy_list'] = $this->copyRepository->get_copy_archives_list(); // !! 
        $this->data['filter'] = $params;

        return view('admin.copy.archives_list', $this->data);  // !! 
    }

    public function copy_jira(Request $request)
    {
        $param = $request->all();
        $this->data['currentAdminMenu'] = 'copy_jira'; // !! check here !!

        $this->data['copywriters'] = $this->userRepository->getCopyTicketAssignee(); // !! 
        if(isset($_GET['copywriter'])){
            $copywriter = $param['copywriter'];
        }else{
            $copywriter = !empty($param['copywriter']) ? $param['copywriter'] : '';
        }
        $this->data['copywriter'] = $copywriter; // !! 

        $this->data['priorities'] = [ // !! 
          "High",
          "Normal"
        ];
        if(isset($_GET['priority'])){
            $priority = $param['priority'];
        }else{
            $priority = !empty($param['priority']) ? $param['priority'] : '';
        }
        $this->data['priority'] = $priority;

        $this->data['filter'] = $param;



        // !! check here this block!!
        $this->data['copy_requested_list'] = $this->copyRepository->get_jira_copy_requested($priority, $copywriter);
        $this->data['copy_to_do_list'] = $this->copyRepository->get_jira_copy_to_do($priority, $copywriter);
        $this->data['copy_in_progress_list'] = $this->copyRepository->get_jira_copy_in_progress($priority, $copywriter);
        $this->data['copy_review_list'] = $this->copyRepository->get_jira_copy_review($priority, $copywriter);
        $this->data['copy_done_list'] = $this->copyRepository->get_jira_copy_done($priority, $copywriter);

        return view('admin.copy.jira', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
        $this->data['domains'] = [
            'KISS',
            'imPRESS',
            'Falscara',
            'Colors & Care',
            'Joah Beauty',
            'KISS INTL',
            'MeAmore',
            'The Farrah',
        ];
        $this->data['types'] = [
            'Paid Media Ads' => 'Targeted promotional content for paid advertising channels.',
            'Package/Insert Copy' => 'Content for product packaging or promotional inserts.',
            'Display/Retail Signage' => 'Copy for in-store displays or retail signage.',
            'PR/Mailer Copy' => "Content for press releases or direct mail marketing.",
            'Sales Copy' => "Persuasive content to drive sales and conversions.",
            'Beautify Editorial Requests' => "Enhance editorial content for aesthetic appeal.",
            'Sweepstakes/Contest Copy' => "Copy for contests or sweepstakes promotions.",
            'YouTube Copy' => "Copy for YouTube video content.",
            'Podcast/Video Script' => "Copy for podcast or video productions.",
            'Cop/General Marketing Copy' => "Versatile copy for various marketing materials.",
            'Other' => "Additional request types not listed above.",
        ];
        $this->data['priorities'] = [
            'Normal' => "Normal (7 days)",
            'High' => "High (5 days)"
        ];

        $this->data['domain'] = null;
        $this->data['type'] = null;
        $this->data['priority'] = null;
        $this->data['copy'] = null; // !! 
        $this->data['copy_status'] = null; // !! 
        $this->data['kiss_users'] = $this->userRepository->getKissUsers();

        return view('admin.copy.form', $this->data); // !! check here !!
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CopyRequest $request) // !! 
    {
        $param = $request->validated();

//        $param = $request->all();
        $param['request_by'] = auth()->user()->id;
        $param['status'] = 'copy_requested'; // !! 

        if(!isset($param['domain'])){
            return redirect('admin/copy/create') // !! 
                ->with('error', 'Please fill out Domain field.');
        }
 
        if($param['description'] == null){
            return redirect('admin/copy/create') // !! 
                ->with('error', 'Please fill out Description field.');
        }


        if (isset($param['domain'])) {
//            $param['disabled_days'] = json_encode($param['disabled_days']);
            $param['domain'] = implode(',', $param['domain']);
        } else {
            $param['domain'] = '';
        }
        $copy = $this->copyRepository->create($param); // !!
        if ($copy) { // !! 
            $files = $request->file('c_attachment');
            if ($files) {
                foreach ($files as $file) {
                    $fileAttachments = new CopyFileAttachments(); // !! 
                    $originalName = $file->getClientOriginalName();
                    $fileName = $this->file_exist_check($file, $copy->id, 0); // !! 
                    $fileAttachments['copy_id'] = $copy->id;
                    $fileAttachments['type'] = 'attachment_file_' . $file->getMimeType();
                    $fileAttachments['author_id'] = $param['request_by'];
                    $fileAttachments['attachment'] = '/' . $fileName;
                    $fileAttachments['file_ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
                    $fileAttachments['file_type'] = $file->getMimeType();
                    $fileAttachments['file_size'] = $file->getSize();
                    $fileAttachments['date_created'] = Carbon::now();
                    $fileAttachments->save();
                }
            }

            $copy_note = new CopyNotes(); // !! 
            $copy_note['user_id'] = $param['request_by'];
            $copy_note['copy_id'] = $copy->id;
            $copy_note['type'] = 'copy';
            $copy_note['note'] = auth()->user()->first_name . " created a new copy ticket request";
            $copy_note['created_at'] = Carbon::now();

            $copy_note->save();

            // send notification to Copywriters manager
            $notify = new NotifyController();
            $notify->copyticket_request($copy); // !! 

            return redirect('admin/copy/'.$copy->id.'/edit') 
                ->with('success', 'Success to create Copy Ticket');
        }else{
            return redirect('admin/copy/create')
                ->with('error', 'Fail to create new Copy Ticket');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = $this->userRepository->findById($id);

        return view('admin.users.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['copy'] = $copy = $this->copyRepository->findById($id); // !! check here !!
        $this->data['copy_status'] = $copy->status; // !! check here !!

        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
        $this->data['domains'] = [
            'KISS',
            'imPRESS',
            'Falscara',
            'Colors & Care',
            'Joah Beauty',
            'KISS INTL',
            'MeAmore',
            'The Farrah',
        ];
        $this->data['types'] = [
            'Paid Media Ads' => 'Targeted promotional content for paid advertising channels.',
            'Package/Insert Copy' => 'Content for product packaging or promotional inserts.',
            'Display/Retail Signage' => 'Copy for in-store displays or retail signage.',
            'PR/Mailer Copy' => "Content for press releases or direct mail marketing.",
            'Sales Copy' => "Persuasive content to drive sales and conversions.",
            'Beautify Editorial Requests' => "Enhance editorial content for aesthetic appeal.",
            'Sweepstakes/Contest Copy' => "Copy for contests or sweepstakes promotions.",
            'YouTube Copy' => "Copy for YouTube video content.",
            'Podcast/Video Script' => "Copy for podcast or video productions.",
            'Cop/General Marketing Copy' => "Versatile copy for various marketing materials.",
            'Other' => "Additional request types not listed above.",
        ];
        $this->data['priorities'] = [
            'Normal' => "Normal (7 days)",
            'High' => "High (5 days)"
        ];

        $this->data['copywriters'] = $this->userRepository->getCopywriterAssignee(); // !! check here !!
        $this->data['domain'] = $copy->domain; // !! check here !!
        $this->data['copy_submission'] = $copy->copy_submission; 
        $this->data['type'] = $copy->type; // !! check here !!
        $this->data['priority'] = $copy->priority; // !! check here !!
        $this->data['kiss_users'] = $this->userRepository->getKissUsers();

        // Campaign_type_asset_attachments
        $options = [
            'id' => $id,
            'order' => [
                'date_created' => 'desc',
            ]
        ];
        $this->data['attach_files'] = $this->fileAttachmentsRepository->findAll($options);

        // Campaign_notes
        $options = [
            'id' => $id,
            'order' => [
                'created_at' => 'desc',
            ]
        ];

        $correspondences = $this->copyNotesRepository->findAll($options); // !! 
        $this->data['correspondences'] = $correspondences;

        return view('admin.copy.form', $this->data); // !! 
    }

    public function copy_add_note(Request $request) // !! 
    {
        $param = $request->all(); 
        $user = auth()->user(); 

        $c_id = $param['c_id'];
        $c_title = $param['c_title'];
        $email_list = $param['email_list'];

        $copy_note = new CopyNotes(); // !!
        $copy_note['user_id'] = $user->id;
        $copy_note['copy_id'] = $c_id; // !! 
        $copy_note['type'] = 'copy_note'; // !! 
        $copy_note['note'] = $param['create_note']; 
        $copy_note['created_at'] = Carbon::now();
        $copy_note->save();

        $new_note = preg_replace("/<p[^>]*?>/", "", $param['create_note']);
        $new_note = str_replace("</p>", "\r\n", $new_note);
        $new_note = html_entity_decode($new_note);

        if($email_list){
            $details = [
                'who' => $user->first_name,
                'c_id' => $c_id, // !! 
                'c_title' => $c_title, // !! 
                'message' => $new_note, // !! 
                'url' => '/admin/copy/'.$c_id.'/edit', // !! 
            ];
            //send to receivers
            $receiver_list = explode(',', $email_list);

            //check admin group//
            if( in_array('admingroup@kissusa.com', $receiver_list)){

                // add all admins to receiver
                $user_obj = new UserRepository();

                $adminGroup_rs = $user_obj->getAdminGroup(); // !! 
                foreach ($adminGroup_rs as $user) {
                    if ('admingroup@kissusa.com' != $user['email']) {
                        $receiver_list[] = $user['email'];
                    }
                }
            }

            Mail::to($receiver_list)->send(new CopyTicketMessage($details)); // !! 
        }

        //$this->data['currentAdminMenu'] = 'campaign'; 

        return redirect('admin/copy/'.$c_id.'/edit') // !! 
            ->with('success', __('Data has been Updated.'));
    }

    public function copy_assign(request $request)
    {
        $param = $request->all();
        $params['assign_to'] = $param['copywriter'];
        $params['status'] = 'copy_to_do';
        $params['updated_at'] = Carbon::now();

        $copy = $this->copyRepository->update($param['c_id'], $params);
        $stmt = " has assigned a ticket to ";

        if($copy){
            $this->add_copy_assign_correspondence($param['c_id'], $params['assign_to'], $stmt);
        }

        // send notification to developer
        $notify = new NotifyController();
        $notify->copyticket_to_do($param['c_id'],$copy->assign_to);

        return redirect('admin/copy/'.$param['c_id'].'/edit')
            ->with('success', 'The task has been assigned.');

    }

    public function copy_in_progress($id) // !! 
    {
        $params['status'] = 'copy_in_progress'; // !! 
        $params['updated_at'] = Carbon::now();

        $copy = $this->copyRepository->update($id, $params); 

        if($copy){ // !! 
            $stmt = " updated the status to Copy In Progress "; // !! 
            $this->add_copy_status_correspondence($id, $stmt); // !! 

            echo '/admin/copy/'.$id.'/edit'; // !! 
        }else{
            echo 'fail';
        }
    }

    public function copy_review($id) // !! 
    {
        $params['status'] = 'copy_review'; // !! 
        $params['updated_at'] = Carbon::now();
        $copy = $this->copyRepository->update($id, $params);
        if($copy){ // !! 
            $stmt = " updated the status to Copy Review "; // !! 
            $this->add_copy_status_correspondence($id, $stmt); // !! 

             // send notification to requester
             $notify = new NotifyController();
             $notify->copyticket_review($id, $copy->request_by);

            echo '/admin/copy/'.$id.'/edit'; // !! 
        }else{
            echo 'fail';
        }
    }

    public function copy_decline(Request $request) // !! 
    {   
       if($request->ajax()){
        $request = $request->all();

        $user = auth()->user();
        
       
        $id = $request['id'];
        $params['updated_at'] = Carbon::now();

        $copy_repo = new CopyRepository();
        $copy_array = $copy_repo->findById($id);

        
        $user_repo = new UserRepository();

        
        if($copy_array->status=="copy_requested" ){ 
            $params['status'] = 'copy_requested'; 
        }else{
            $params['status'] = 'copy_to_do';     
        }
        
        
        $copy = $this->copyRepository->update($id, $params);

        if($copy){ // !! 
            

            $stmt = " has been declined to the copy. <br/> <b style='background-color: #ff7373;
            color: white;'> <u>Decline Reason:</u> ".$request['decline_reason']."</b>"; // !! 
            $this->add_copy_status_correspondence($id, $stmt); // !! 
            
            
            if($copy_array->status=="copy_requested" ){ 
            // copywriter decline
            $user_array = $user_repo->findById($copy_array->request_by);  //if copy team decline send mail requester  
            $details = [
                'who' => 'Copy Team',
                'c_id' => $id, // !! 
                'c_title' => $copy_array['title'], // !! 
                'message' => 'The copy request has been declined. Please check to below link for more information.', // !! 
                'url' => '/admin/copy/'.$id.'/edit', // !! 
            ];
            Mail::to($user_array['email'])->send(new CopyTicketMessage($details));

            }else{ // requestor decline 
            $user_array = $user_repo->findById($copy_array->assign_to);
            $who_array = $user_repo->findById($copy_array->request_by);  //if copy team decline send mail requester  
            $details = [
                'who' => $who_array['first_name'],
                'c_id' => $id, // !! 
                'c_title' => $copy_array['title'], // !! 
                'message' => 'The copy work has been declined from ticket owner. Please check to below link for more information.', // !! 
                'url' => '/admin/copy/'.$id.'/edit', // !! 
            ];
            Mail::to($user_array['email'])->send(new CopyTicketMessage($details));

            }

            
            

            $response = array(
                'id' => $id,
                'status' => 'success',
                'url' => '/admin/copy/'.$id.'/edit'
            );

        }else{

            $response = array(
                'id' => $id,
                'status' => 'fail',
            );
        }

        return response()->json($response); 
        }
    }

    public function copy_done($id)
    {
        $params['status'] = 'copy_done';
        $params['updated_at'] = Carbon::now();
        $copy = $this->copyRepository->update($id, $params);
        if($copy){
            $stmt = " updated the status to Copy Done ";
            $this->add_copy_status_correspondence($id, $stmt);

            echo '/admin/copy/'.$id.'/edit';
        }else{
            echo 'fail';
        }
    }

    public function add_copy_status_correspondence($copy_id, $stmt) // !! 
    { // !! check here !!
        // Insert into campaign note for correspondence
        $user = auth()->user();

        $change_line  = "<p>$user->first_name". $stmt . "</p>";

        $copy_note = new CopyNotes();
        $copy_note['user_id'] = $user->id;
        $copy_note['copy_id'] = $copy_id;
        $copy_note['type'] = 'copy_note';
        $copy_note['note'] = $change_line;
        $copy_note['created_at'] = Carbon::now();
        $copy_note->save();
    }

    public function add_copy_assign_correspondence($copy_id, $copywriter, $stmt) // !! check here !! allpart
    {
        // Insert into campaign note for correspondence
        $user = auth()->user();
        $copywriter_obj = $this->userRepository->findById($copywriter);

        $change_line  = "<p>$user->first_name". $stmt . $copywriter_obj->first_name."</p>";

        $copy_note = new CopyNotes();
        $copy_note['user_id'] = $user->id;
        $copy_note['copy_id'] = $copy_id;
        $copy_note['type'] = 'copy_note';
        $copy_note['note'] = $change_line;
        $copy_note['created_at'] = Carbon::now();
        $copy_note->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        $param = $request->all();
        $user = auth()->user();
        //$param['request_by'] = $user->id;

        if (isset($param['domain'])) {
            $param['domain'] = implode(',', $param['domain']);
        } else {
            $param['domain'] = '';
        }

        $data = $request->request->all();
        $copy = $this->copyRepository->findById($id);
        $new = array(
            'title'             => $data['title'],
            'type'              => $data['type'],
            'domain'            => $param['domain'],
            'description'       => $data['description'],
            'copy_submission'   => $data['copy_submission']
        );
//        ddd(htmlspecialchars_decode($data['description']));
        $origin = $copy->toArray();
        foreach ($new as $key => $value) {
            if (array_key_exists($key, $origin)) {
                if (html_entity_decode($new[$key]) != html_entity_decode($origin[$key])) {
                    $changed[$key]['new'] = $new[$key];
                    $changed[$key]['original'] = $origin[$key];
                }
            }
        }
        $change_line  = "<p>$user->first_name made a change to a Task</p>";
        if(!empty($changed)){
            foreach ($changed as $label => $change) {

                $label = ucwords(str_replace('_', ' ', $label));
                $from  = trim($change['original']); // Remove strip tags
                $to    = trim($change['new']);      // Remove strip tags

                $change_line .= "<div class='change_label'><p>$label:</p></div>"
                    . "<div class='change_to'><p>$to</p></div>"
                    . "<div class='change_from'><del><p>$from</p></del></div>";
            }
            $copy_note = new copyNotes();
            $copy_note['copy_id'] = $copy->id;
            $copy_note['user_id'] = $user->id;
            $copy_note['type'] = 'copy';
            $copy_note['note'] = $change_line;
            $copy_note['created_at'] = Carbon::now();
            $copy_note->save();
        }


        if ($this->copyRepository->update($id, $param)) {

            $files = $request->file('c_attachment');
            if ($files) {
                foreach ($files as $file) {
                    $fileAttachments = new CopyFileAttachments();
                    // file check if exist.
                    $originalName = $file->getClientOriginalName();
                    $fileName = $this->file_exist_check($file, $id, 0); 
                    $fileAttachments['copy_id'] = $id;
                    $fileAttachments['type'] = 'attachment_file_' . $file->getMimeType();
                    $fileAttachments['author_id'] = $param['request_by'];
                    $fileAttachments['attachment'] = '/' . $fileName;
                    $fileAttachments['file_ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
                    $fileAttachments['file_type'] = $file->getMimeType();
                    $fileAttachments['file_size'] = $file->getSize();
                    $fileAttachments['date_created'] = Carbon::now();
                    $fileAttachments->save();

                    // insert file attachment correspondence
                    $this->add_file_correspondence($copy, $user, $file->getMimeType(), $originalName);

                }
            }

            return redirect('admin/copy/'.$id.'/edit')
                ->with('success', 'Success to update Copy Ticket');
        }

        return redirect('admin/copy/'.$id.'/edit')
                ->with('error', 'Fail to update Copy Ticket');
    }

    public function add_file_correspondence($copy, $user, $file_type, $originalName)
    {
        // Insert into campaign note for correspondence (attachment file)
        $change_line  = "<p>$user->first_name add a file $originalName ($file_type) to task</p>";

        $copy_note = new CopyNotes();
        $copy_note['user_id'] = $user->id;
        $copy_note['copy_id'] = $copy->id;
        $copy_note['type'] = 'copy';
        $copy_note['note'] = $change_line;
        $copy_note['created_at'] = Carbon::now();
        $copy_note->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) // 
    {
        $user = $this->userRepository->findById($id);

        if ($user->id == auth()->user()->id) {
            return redirect('admin/users')
                ->with('error', 'Could not delete yourself.');
        }

        if ($this->userRepository->delete($id)) {
            return redirect('admin/users')
                ->with('success', __('users.success_deleted_message', ['first_name' => $user->first_name]));
        }
        return redirect('admin/users')
                ->with('error', __('users.fail_to_delete_message', ['first_name' => $user->first_name]));
    }

    public function file_exist_check($file, $project_id, $asset_id) // !! 
    {
        $originalName = $file->getClientOriginalName();

        if($asset_id==0){
            $destinationFolder = 'copy/'.$project_id.'/'.$originalName;
        }else{
            $destinationFolder = 'copy/'.$project_id.'/'.$asset_id.'/'.$originalName;
        }
        

        // If exist same name file, add numberning for version control
        if(Storage::exists($destinationFolder)){
            if ($pos = strrpos($originalName, '.')) {
                $new_name = substr($originalName, 0, $pos);
                $ext = substr($originalName, $pos);
            }

            if($asset_id==0){
                $newpath = 'copy/'.$project_id.'/'.$originalName;
            }else{
                $newpath = 'copy/'.$project_id.'/'.$asset_id.'/'.$originalName;
            }

            $uniq_no = 1;
            while (Storage::exists($newpath)) {
                $tmp_name = $new_name .'_'. $uniq_no . $ext;
                if($asset_id==0){
                    $newpath = 'copy/'.$project_id.'/'.$tmp_name;
                }else{
                    $newpath = 'copy/'.$project_id.'/'.$asset_id.'/'.$tmp_name;
                }
                $uniq_no++;
            }
            $file_name = $tmp_name;
        }else{
            $file_name = $originalName;
        }

        if($asset_id==0){
            $fileName =$file->storeAs('copy/'.$project_id, $file_name);
        }else{
            $fileName =$file->storeAs('copy/'.$project_id.'/'.$asset_id, $file_name);
        }

       

        return $fileName;
    }

    public function fileRemove($id) // !! check here !!
    {
        $fileAttachment = $this->fileAttachmentsRepository->findById($id);

        $file_type = $fileAttachment->file_type;
        $campaign_id = $fileAttachment->id;
        $asset_id = $fileAttachment->asset_id;
        $filedelete=ltrim($fileAttachment->attachment,'/'); 

        $delete_s3_file = Storage::disk('s3')->delete(''.$fileAttachment->attachment.'');



        $user = auth()->user();

        if($fileAttachment->delete()){

//            if($asset_id != 0){
//
//                $assetIndex = $this->fileAttachment->findById($asset_id);
//                $asset_type =  ucwords(str_replace('_', ' ', $assetIndex->type));
//
//                $change_line = "<p>$user->first_name removed a attachment ($file_type) on $asset_type (#$asset_id)</p>";
//                $campaign_note['type'] = $assetIndex->type;
//            }else {
//                $change_line = "<p>$user->first_name removed a attachment ($file_type) on campaign</p>";
//                $campaign_note['type'] = 'campaign';
//            }

//            $campaign_note = new CampaignNotes();
//            $campaign_note['id'] = $campaign_id;
//            $campaign_note['user_id'] = $user->id;
//            $campaign_note['asset_id'] = $asset_id;
//            $campaign_note['note'] = $change_line;
//            $campaign_note['date_created'] = Carbon::now();
//            $campaign_note->save();
//
            echo 'success';
        }else{
            
            echo 'fail';
        }
    }


}
