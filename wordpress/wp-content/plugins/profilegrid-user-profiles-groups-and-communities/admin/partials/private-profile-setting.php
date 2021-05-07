<?php
$dbhandler = new PM_DBhandler;
$pmrequests = new PM_request;
$textdomain = $this->profile_magic;
$path =  plugin_dir_url(__FILE__);
$identifier = 'SETTINGS';
if(filter_input(INPUT_POST,'submit_settings'))
{
	$retrieved_nonce = filter_input(INPUT_POST,'_wpnonce');
	if (!wp_verify_nonce($retrieved_nonce, 'save_private_profile_settings' ) ) die( __('Failed security check','profilegrid-user-profiles-groups-and-communities') );
	$exclude = array("_wpnonce","_wp_http_referer","submit_settings");
	$post = $pmrequests->sanitize_request($_POST,$identifier,$exclude);
	if($post!=false)
	{
		if(!isset($post['pm_enable_private_profile'])) $post['pm_enable_private_profile'] = 0;
		if(!isset($post['pm_show_user_profile_on_group_page'])) $post['pm_show_user_profile_on_group_page'] = 0;
		
                foreach($post as $key=>$value)
		{
			$dbhandler->update_global_option_value($key,$value);
		}
	}
	
	wp_redirect( esc_url_raw('admin.php?page=pm_settings') );exit;
}
?>

<div class="uimagic">
    <form name="pm_private_profile_settings" id="pm_private_profile_settings" method="post" onsubmit="return add_section_validation()">
    <!-----Dialogue Box Starts----->
    <div class="content">
      <div class="uimheader">
        <?php _e( 'Private Profile','profilegrid-user-profiles-groups-and-communities' ); ?>
      </div>
     
      <div class="uimsubheader">
        <?php
		//Show subheadings or message or notice
		?>
      </div>
      
      <div class="uimrow">
        <div class="uimfield">
          <?php _e( 'Enable Private Profile Mode','profilegrid-user-profiles-groups-and-communities' ); ?>
        </div>
        <div class="uiminput">
           <input name="pm_enable_private_profile" id="pm_enable_private_profile" type="checkbox" <?php checked($dbhandler->get_global_option_value('pm_enable_private_profile'),'1'); ?> class="pm_toggle" value="1" style="display:none;"  onClick="pm_show_hide(this,'enable_private_profile_html')" />
          <label for="pm_enable_private_profile"></label>
        </div>
        <div class="uimnote"><?php _e("Make all user profiles private. Only profile owners can view respective profile pages.",'profilegrid-user-profiles-groups-and-communities');?></div>
      </div>
      <div class="childfieldsrow" id="enable_private_profile_html" style=" <?php if($dbhandler->get_global_option_value('pm_enable_private_profile',0)==1){echo 'display:block;';} else { echo 'display:none;';} ?>">
     
          <div class="uimrow">
        <div class="uimfield">
          <?php _e('Notice for Other Users','profilegrid-user-profiles-groups-and-communities');?>
        </div>
        <div class="uiminput">
            <textarea name="pm_private_profile_message" id="pm_private_profile_message"><?php echo $dbhandler->get_global_option_value('pm_private_profile_message',__('You are not authorized to view contents of this page.','profilegrid-user-profiles-groups-and-communities'));?></textarea>
          <div class="errortext"></div>
        </div>
        <div class="uimnote"><?php _e('This notice will be visible to users who directly reach individual profile page of other users through a link.','profilegrid-user-profiles-groups-and-communities');?></div>
      </div>
          
          <div class="uimrow">
        <div class="uimfield">
          <?php _e( 'Display Profile Cards on Group Pages','profilegrid-user-profiles-groups-and-communities' ); ?>
        </div>
        <div class="uiminput">
           <input name="pm_show_user_profile_on_group_page" id="pm_show_user_profile_on_group_page" type="checkbox" <?php checked($dbhandler->get_global_option_value('pm_show_user_profile_on_group_page','0'),'1'); ?> class="pm_toggle" value="1" style="display:none;" />
          <label for="pm_show_user_profile_on_group_page"></label>
        </div>
        <div class="uimnote"><?php _e("Decide wether you wish to continue displaying user profile cards on Group pages or not. If you chose to display, the cards will no longer link to their respective user profile pages.",'profilegrid-user-profiles-groups-and-communities');?></div>
      </div>
          
      </div>
     
      
     
     
        
      <div class="buttonarea"> <a href="admin.php?page=pm_settings">
        <div class="cancel">&#8592; &nbsp;
          <?php _e('Cancel','profilegrid-user-profiles-groups-and-communities');?>
        </div>
        </a>
        <?php wp_nonce_field('save_private_profile_settings'); ?>
        <input type="submit" value="<?php _e('Save','profilegrid-user-profiles-groups-and-communities');?>" name="submit_settings" id="submit_settings" />
        <div class="all_error_text" style="display:none;"></div>
      </div>
    </div>
  </form>
</div>
