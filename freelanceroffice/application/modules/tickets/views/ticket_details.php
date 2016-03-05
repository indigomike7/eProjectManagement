<!--Start -->
<section id="content">
    <section class="hbox stretch">
        <aside class="aside-md bg-white b-r hidden-print" id="subNav">
            <header class="dk header b-b">
                <a href="<?=base_url()?>tickets/add" data-original-title="<?=lang('create_ticket')?>" data-toggle="tooltip" data-placement="top" class="btn btn-icon btn-<?=config_item('theme_color')?> btn-sm pull-right"><i class="fa fa-plus"></i></a>
                <p class="h4"><?=lang('all_tickets')?></p>
            </header>
            <section class="vbox">
                <section class="scrollable w-f">
                    <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                        <?=$this->load->view('sidebar/tickets',$tickets)?>
                    </div>
                    </section>
                </section>
            </aside>
            <aside>
                <section class="vbox">
                    <?php
                    if (!empty($ticket_details)) {
                    foreach ($ticket_details as $key => $t) { ?>
                    <header class="header bg-white b-b clearfix hidden-print">

                        <div class="row m-t-sm">
                            <div class="col-sm-8 m-b-xs">
                                <a href="#t_info" class="btn btn-primary btn-sm" id="info_btn" data-toggle="class:hide">
                                <i class="fa fa-caret-left"></i></a>
                                <?php if ($role != '2') { ?>
                                <a href="<?=base_url()?>tickets/edit/<?=$t->id?>" class="btn btn-sm btn-dark">
                                <i class="fa fa-pencil"></i> <?=lang('edit_ticket')?></a>
                                <?php } ?>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-<?=config_item('theme_color')?> dropdown-toggle" data-toggle="dropdown">
                                    <?=lang('change_status')?>
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <?php
                                        $statuses = $this -> db -> get('status') -> result();
                                        if (!empty($statuses)) {
                                        foreach ($statuses as $key => $s) { ?>
                                        <li><a href="<?=base_url()?>tickets/status/<?=$t->id?>/?status=<?=$s->status?>"><?=ucfirst($s->status)?></a></li>
                                        <?php } } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php if ($role == '1') { ?>
                            <div class="col-sm-4 m-b-xs">
                                <a href="<?=base_url()?>tickets/delete/<?=$t->id?>" class="btn btn-sm btn-danger pull-right" data-toggle="ajaxModal">
                                <i class="fa fa-trash-o"></i> <?=lang('delete_ticket')?></a>
                            </div>
                            <?php } ?>
                        </div>
                    </header>
                    <section class="scrollable wrapper">


                    <?php
                    $rep = $this->db->where('ticketid',$t->id)->get('ticketreplies')->num_rows();
                    if($rep == 0 AND $t->status != 'closed'){ ?>

                <div class="alert alert-success hidden-print">
                        <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                        <?= lang('ticket_not_replied') ?>
                    </div>
                <?php } ?>


                        <!-- Start ticket Details -->
                        <div class="row">
                            <section class="">
                                <div class="col-lg-4" id="t_info">
                                    <ul class="list-group no-radius small">
                                        <?php
                                        if($t->status == 'open'){ $s_label = 'danger'; }elseif($t->status=='closed'){ $s_label = 'success'; }else{ $s_label = 'default';}
                                        ?>
                                        <li class="list-group-item"><span class="pull-right"><?=$t->ticket_code?></span><?=lang('ticket_code')?></li>
                                        <li class="list-group-item">
                                            <?=lang('reporter')?>
                                            <span class="pull-right">
                                                <?php if($t->reporter != NULL){ ?>
                                                <a class="thumb-xs avatar pull-left">
                                                    <?php if(config_item('use_gravatar') == 'TRUE' AND Applib::get_table_field(Applib::$profile_table,array('user_id'=>$t->reporter),'use_gravatar') == 'Y'){
                                                    $user_email = Applib::login_info($t->reporter)->email; ?>
                                                    <img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
                                                    <?php }else{ ?>
                                                    <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($t->reporter)->avatar?>" class="img-circle">
                                                    <?php } ?>
                                                    <?=Applib::displayName($t->reporter)?>
                                                </a>
                                                <?php } else{ echo "NULL"; } ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right">
                                                <?=Applib::get_table_field(Applib::$departments_table,array('deptid'=>$t->department),'deptname')?>
                                            </span><?=lang('department')?>
                                        </li>
                                    <li class="list-group-item">
                                    <?php
                                    switch ($t->status) {
                                        case 'open':
                                            $status_lang = 'open';
                                            break;
                                        case 'closed':
                                            $status_lang = 'closed';
                                            break;
                                        case 'in progress':
                                            $status_lang = 'in_progress';
                                            break;
                                        case 'answered':
                                            $status_lang = 'answered';
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }?>
                                            <span class="pull-right"><label class="label label-<?=$s_label?>">
                                            <?=ucfirst(lang($status_lang))?></label>
                                        </span><?=lang('status')?>
                                    </li>


                                    <li class="list-group-item"><span class="pull-right"><?=$t->priority?></span><?=lang('priority')?></li>

                                    <li class="list-group-item">
                                    <span class="pull-right label label-success" data-toggle="tooltip" data-title="<?=$t->created?>" data-placement="left">

                                    <?php
                                                $ts = $t->created;
                                                $convertedTime = (Applib::convert_datetime($ts));
                                                $when = (Applib::makeAgo($convertedTime));
                                                echo $when;
                                                ?>

                                    </span><?=lang('created')?>
                                    </li>


                                    <?php
                                    $additional = json_decode($t->additional, true);
                                    if (is_array($additional))
                                    foreach ($additional as $key => $value)
                                    {
                                    $result = $this -> db -> where('uniqid', $key) -> get(Applib::$custom_fields_table);
                                    $row = $result -> row_array();
                                    echo '<li class="list-group-item"><span class="pull-right">' .$this -> encrypt -> decode($value).'</span>'.$row['name'] .'</li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                            <!-- End ticket details-->




                            <div class="col-sm-8 ticket_body">
                                <strong><?=$t->subject?></strong>
                                <div class="line line-dashed line-lg pull-in"></div>
                                <?=nl2br_except_pre($t->body)?>

                                <?php if($t->attachment != NULL){
                                echo '<div class="line line-dashed line-lg pull-in"></div>';
                                $files = '';
                                if (json_decode($t->attachment)) {
                                $files = json_decode($t->attachment);
                                foreach ($files as $f) { ?>
                                <a class="label bg-info" href="<?=base_url()?>resource/attachments/<?=$f?>" target="_blank"><?=$f?></a><br>
                                <?php }
                                }else{ ?>
                                <a class="label bg-info" href="<?=base_url()?>resource/attachments/<?=$t->attachment?>" target="_blank"><?=$t->attachment?></a><br>
                                <?php } ?>

                                <?php } ?>
                                <div class="line line-dashed line-lg pull-in"></div>
                                <?php
                                $user = $this->tank_auth->get_user_id();
                                ?>
                                <section class="comment-list block">
                                    <!-- ticket replies -->
                                    <?php
                                    if (!empty($ticket_replies)) {
                                    foreach ($ticket_replies as $key => $r) {
                                    $role_id = Applib::login_info($r->replierid)->role_id;
                                    $user_role = $this->tank_auth->user_role($role_id);
                                    $username = Applib::displayName($r->replierid);
                                    if($user_role == 'admin'){ $role_label = 'danger'; }else{ $role_label = 'info';}
                                    ?>
                                    <article id="comment-id-1" class="comment-item">
                                        <a class="pull-left thumb-sm avatar">
                                            <?php
                                            if(config_item('use_gravatar') == 'TRUE' AND
                                            Applib::get_table_field(Applib::$profile_table,
                                            array('user_id'=>$r->replierid),'use_gravatar') == 'Y'){
                                            $user_email = Applib::login_info($r->replierid)->email; ?>
                                            <img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
                                            <?php }else{ ?>
                                            <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($r->replierid)->avatar?>" class="img-circle">
                                            <?php } ?>
                                        </a>
                                        <span class="arrow left"></span>
                                        <section class="comment-body panel panel-default">
                                            <header class="panel-heading bg-white">
                                                <a href="#"><?=ucfirst($username)?></a>
                                                <label class="label bg-<?=$role_label?> m-l-xs"><?=ucfirst($user_role)?></label>
                                                <span class="text-muted m-l-sm pull-right">
                                                    <i class="fa fa-clock-o"></i>

                                                <?php
                                                $ts = $r->time;
                                                $convertedTime = (Applib::convert_datetime($ts));
                                                $when = (Applib::makeAgo($convertedTime));
                                                echo $when;
                                                ?>
                                                </span>
                                            </header>
                                            <div class="panel-body">
                                                <div class="small m-t-sm">
                                                <?=$r->body?>
                                                </div>

                                                <?php if($r->attachment != NULL){
                                                echo '<div class="line line-dashed line-lg pull-in"></div>';
                                                $replyfiles = '';
                                                if (json_decode($r->attachment)) {
                                                $replyfiles = json_decode($r->attachment);
                                                foreach ($replyfiles as $rf) { ?>
                                                <a class="label bg-info" href="<?=base_url()?>resource/attachments/<?=$rf?>" target="_blank"><?=$rf?></a><br>
                                                <?php }
                                                }else{ ?>
                                                <a href="<?=base_url()?>resource/attachments/<?=$r->attachment?>" target="_blank"><?=$r->attachment?></a><br>
                                                <?php } ?>

                                                <?php } ?>
                                            </div>
                                        </section>
                                    </article>
                                    <?php } }else{ ?>
                                    <article id="comment-id-1" class="comment-item">
                                        <section class="comment-body panel panel-default">
                                            <div class="panel-body">
                                                <p><?=lang('no_ticket_replies')?></p>
                                            </div>
                                        </section>
                                    </article>
                                    <?php } ?>
                                    <!-- comment form -->
                                    <article class="comment-item media" id="comment-form">
                                        <a class="pull-left thumb-sm avatar">
                                            <?php if(config_item('use_gravatar') == 'TRUE' AND Applib::get_table_field(Applib::$profile_table,array('user_id'=>$user),'use_gravatar') == 'Y'){
                                            $user_email = Applib::login_info($user)->email; ?>
                                            <img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
                                            <?php }else{ ?>
                                            <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($user)->avatar?>" class="img-circle">
                                            <?php } ?>
                                        </a>
                                        <section class="media-body">
                                            <section class="panel panel-default foeditor-noborder">
                                                <?php
                                                $attributes = 'class="m-b-none"';
                                                echo form_open_multipart(base_url().'tickets/reply',$attributes); ?>
                                                <input type="hidden" name="ticketid" value="<?=$t->id?>">
                                                <input type="hidden" name="ticket_code" value="<?=$t->ticket_code?>">
                                                <input type="hidden" name="replierid" value="<?=$user?>">
                                                <textarea required="required" class="form-control foeditor" name="reply" rows="3" placeholder="<?=lang('ticket')?> <?=$t->ticket_code?> <?=lang('reply')?>">
                                                </textarea>

                                                <footer class="panel-footer bg-light lter">
                                                    <div id="file_container">
                                                        <input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="ticketfiles[]">
                                                    </div>
                                                    <div class="line line-dashed line-lg pull-in"></div>
                                                    <a href="#" class="btn btn-default btn-xs" id="add-new-file"><?=lang('upload_another_file')?></a>
                                                    <a href="#" class="btn btn-default btn-xs" id="clear-files" style="margin-left:6px;"><?=lang('clear_files')?></a>
                                                    <div class="line line-dashed line-lg pull-in"></div>
                                                    <button class="btn btn-<?=config_item('theme_color');?> pull-right btn-sm" type="submit"><?=lang('reply_ticket')?></button>
                                                    <ul class="nav nav-pills nav-sm">
                                                    </ul>
                                                </footer>
                                            </form>
                                        </section>
                                    </section>
                                </article>

                                <!-- End ticket replies -->
                            </section>
                        </div>
                        <!-- End details -->
                    </section>
                </div>
                <!-- End display details -->
            </section>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
            <script type="text/javascript">
            $('#clear-files').click(function(){
            $('#file_container').html(
            "<input type='file' class='filestyle' data-buttonText='<?=lang('choose_file')?>' data-icon='false' data-classButton='btn btn-default' data-classInput='form-control inline input-s' name='ticketfiles[]'>"
            );
            });
            $('#add-new-file').click(function(){
            $('#file_container').append(
            "<input type='file' class='filestyle' data-buttonText='<?=lang('choose_file')?>' data-icon='false' data-classButton='btn btn-default' data-classInput='form-control inline input-s' name='ticketfiles[]'>"
            );
            });
            $('#info_btn').click(function(){
                var st = $( ".ticket_body" ).attr( "class" );

                if (st == 'col-sm-8 ticket_body' || st == 'ticket_body col-sm-8') {
                    $('.ticket_body').removeClass("col-sm-8");
                    $('.ticket_body').addClass("col-sm-12");
                }else{
                    $('.ticket_body').addClass("col-sm-8");
                    $('.ticket_body').removeClass("col-sm-12");
                };

            });
            </script>
            <?php } } ?>
            </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
            <!-- end
