<?php
$dbhandler = new PM_DBhandler;
//$textdomain = $this->profile_magic;
$path =  plugin_dir_url(__FILE__);
$pmrequests = new PM_request;
$html_creator = new PM_HTML_Creator('profilegrid-user-profiles-groups-and-communities','1');
$register_link = $pmrequests->profile_magic_get_frontend_url('pm_show_register_link','0');
$registration_url  = $pmrequests->profile_magic_get_frontend_url('pm_registration_page','');
$forget_password_url = $pmrequests->profile_magic_get_frontend_url('pm_forget_password_page',site_url('/wp-login.php?action=lostpassword'));
// Retrieve possible errors from request parameters
$attributes['errors'] = array();
if ( isset( $_REQUEST['errors'] ) ) {
    $error_codes = explode( ',', $_REQUEST['errors'] );
    foreach ( $error_codes as $error_code ) {
        $attributes['errors'][]=  $pmrequests->profile_magic_get_error_message($error_code,'profilegrid-user-profiles-groups-and-communities');
    }
}
// Check if the user just requested a new password 
$pm_error = '';
$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';
$attributes['user_activated'] = isset( $_REQUEST['activated'] ) && $_REQUEST['activated'] == 'success';
$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';
if ( $attributes['lost_password_sent'] ) $pm_error .= '<span class="pm_info">'.__( 'Check your email for a link to reset your password.','profilegrid-user-profiles-groups-and-communities' ).'</span>';
if ( $attributes['password_updated'] ) $pm_error .= '<span class="pm_info">'.__( 'Your password has been changed. You can sign in now.','profilegrid-user-profiles-groups-and-communities' ).'</span>';
if ( $attributes['user_activated'] ) $pm_error .= '<span class="pm_info">'.__( 'Your account has been successfully activated.','profilegrid-user-profiles-groups-and-communities' ).'</span>';

if ( count( $attributes['errors'] ) > 0 )
{
	foreach ( $attributes['errors'] as $error )
	{
		$pm_error .= '<span>'.$error.'</span>';
	}
}

if(isset($_POST['login_form_submit']))
{
	if($pmrequests->profile_magic_show_captcha('pm_enable_recaptcha_in_login'))
	{
		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
		$remote_ip = $_SERVER["REMOTE_ADDR"];
		$check_captcha = $pmrequests->profile_magic_captcha_verification($response,$remote_ip);
	}
	else
	{
		$check_captcha=true;
	}
	
	if($check_captcha==true)
	{
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'pm_login_form' ) ) die( __('Failed security check','profilegrid-user-profiles-groups-and-communities') );
		$username = $_POST['user_login'];
   		$password = $_POST['user_pass'];
		$secure_cookie = is_ssl();
    
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) 
		{ //Invalid Email
			$user = get_user_by('email', $username);
		} 
		else 
		{
			$user = get_user_by('login', $username);
		}
    
		if ($user) 
		{
			if(wp_check_password( $password, $user->data->user_pass, $user->ID))
			{
				$creds = array('user_login' => $user->data->user_login, 'user_password' => $password);
				$user = wp_signon( $creds, $secure_cookie );
				//wp_redirect('/members/'.$user->data->user_login.'/courses');
				$pm_redirect_after_login = $dbhandler->get_global_option_value('pm_redirect_after_login','0');
				if($pm_redirect_after_login==0)
				{
					$url = home_url('wp-admin');
				}
				else
				{
					$url = get_permalink($pm_redirect_after_login);	
				}
				
				wp_redirect( esc_url_raw($url) );exit;
			}
			else
			{
				$redirect_url = $pmrequests->profile_magic_get_frontend_url('pm_user_login_page',site_url('/wp-login.php'));
				$redirect_url = add_query_arg( 'errors','incorrect_password', $redirect_url );
				wp_redirect( esc_url_raw( $redirect_url ) );exit;
			}
		}
		else
		{
			$redirect_url = $pmrequests->profile_magic_get_frontend_url('pm_user_login_page',site_url('/wp-login.php'));
			$redirect_url = add_query_arg( 'errors','invalid_username', $redirect_url );
			wp_redirect( esc_url_raw( $redirect_url ) );exit;
		}
	}
	else
	{
		$pm_error .= '<p class="pm_error">'.__( 'Captcha Failed','profilegrid-user-profiles-groups-and-communities' ).'</p>';	
	}
}

?>
<div class="pmagic">  
 <div class="pm-widget-login-box pm-dbfl"> 
 <?php if(isset($pm_error) && $pm_error!='' && !is_user_logged_in()):?>
 <div class="pm-login-box-error pm-dbfl pm-pad10 pm-border-bt"><?php echo $pm_error;?></div>
 <?php endif;?>
<?php 
if ( is_user_logged_in()) : 
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;
    $user_info = get_userdata($current_user->ID);
    $gids = maybe_unserialize($pmrequests->profile_magic_get_user_field_value($uid,'pm_group'));
    $gid = $pmrequests->pg_filter_users_group_ids($gids);
    $group_page_link = $pmrequests->profile_magic_get_frontend_url('pm_group_page','');
    if(!empty($gid))
    {
        $group_page_link = $pmrequests->profile_magic_get_frontend_url('pm_group_page','',$gid[0]);
        $primary_gid = $pmrequests->pg_get_primary_group_id($gid);
        $group_page_link = add_query_arg( 'gid',$gid[0],$group_page_link );
        $groupinfo = $dbhandler->get_row('GROUPS',$gid[0]);
        $group_leader = maybe_unserialize($groupinfo->group_leaders);
    }
    else
    {
        $gid='';
        $primary_gid = '';
    }
    ?>
 <div class="pg-user-content pm-dbfl">
     <div class="pg-user-content-img pm-difl">
         <?php if(isset($pg_show_dp) && $pg_show_dp=="1"):?>
        <div id="pm-show-profile-image" class="pm-profile-image pm-difl pm-pad10"> <?php echo get_avatar($user_info->user_email,50,'',false,array('class'=>'pm-user','force_display'=>true));?>
        
        </div>
         <?php endif;?>
     </div>
     <div class="pg-loggedin-user-info pm-difl">
          <div class="pm-profile-title pm-difl pm-pad10">
          <div class="pm-user-name pm-dbfl pm-clip"><?php echo $pmrequests->pm_get_display_name($uid,true);?></div>
           <?php if(!empty($gid) && isset($pg_show_group_name) && $pg_show_group_name=='1'):?>
          <div class="pm-user-group-name pm-dbfl pm-clip">
              <a href='<?php echo esc_url($group_page_link ); ?>'>
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <?php echo $groupinfo->group_name;?>
              </a>
               <?php $total_assign_group = count(array_unique($gid));if(!empty($gid) && is_array($gid) && $total_assign_group >1):?>
              <?php if($total_assign_group>2){ $group_count_String = __('more groups','profilegrid-user-profiles-groups-and-communities');}else{$group_count_String = __('more group','profilegrid-user-profiles-groups-and-communities');} ?>
              <div class="pg-more-groups"><a onclick="pg_open_group_tab()">+<?php echo count(array_unique($gid))-1 .' '.$group_count_String; ?> </a></div>
               <?php endif;?>
               <a></a> 
               
          </div>
          <?php endif;?>
           <?php do_action('profile_magic_show_additional_header_info',$uid);?>
        </div>
         
     </div>
     <div class="pm-group-icon pm-widget-user-group pm-difr pm-pad10">
              
        <?php if(!empty($gid) && isset($pg_show_group_icon) && $pg_show_group_icon=='1'):?>
            <div id="pg-group-badge">
                <div id="pg-group-badge-dock">
                 <?php $pmrequests->pg_get_user_groups_badge_slider($uid);?>
                </div>
            </div> 
        <?php endif;?>    
              

          </div>
 </div>
<?php
else:
?>
		
 
<!-----Form Starts----->
  <form class="pmagic-form pm-dbfl pm-bg-lt" method="post" action="" id="pm_widget-login_form" name="pm_login_form">
  <?php wp_nonce_field('pm_login_form'); ?>
      <div class="pm_widget-login-row pm-difl">
          <label for="<?php echo esc_attr('user_login');?>" class="pm-dbfl"><?php _e('Email or Username','profilegrid-user-profiles-groups-and-communities');?></label>
        <input type="text" name="<?php echo esc_attr('user_login');?>" id="<?php echo esc_attr('user_login');?>" placeholder="<?php _e('Email or Username','profilegrid-user-profiles-groups-and-communities');?>" required="required">
         </div>
            <div class="pm_widget-login-row pm-difl">
        <label for="<?php echo esc_attr('user_pass');?>" class="pm-dbfl"><?php _e('Password','profilegrid-user-profiles-groups-and-communities');?></label>
        <input type="password" name="<?php echo esc_attr('user_pass');?>" id="<?php echo esc_attr('user_pass');?>" placeholder="<?php _e('Password','profilegrid-user-profiles-groups-and-communities');?>" required="required">
            </div>
            <div class="pm-login-box-bottom-container pm-dbfl">
                <input type="submit" value="<?php _e('Login','profilegrid-user-profiles-groups-and-communities');?>" name="login_form_submit" class="">
                <?php if($register_link):?>
                <a href="<?php echo $registration_url;?>" class="pm-difl pg-registration-button"><?php _e('Register','profilegrid-user-profiles-groups-and-communities');?> </a> 
                <?php endif; ?>
                <div class="pm-login-links-box pm-dbfl">
                <a href="<?php echo $forget_password_url;?>"><?php _e('Forgot Password?','profilegrid-user-profiles-groups-and-communities');?></a>
                </div>
            </div>
   <?php
  /* $fields = array('username','password','remember_me');
   $html_creator->get_custom_login_form_html($fields,1);*/
   
  /*if($pmrequests->profile_magic_show_captcha('pm_enable_recaptcha_in_login'))
  $html_creator->pm_get_captcha_html();*/
  ?>
  </form>
  <?php endif;?>
   </div>
</div>

