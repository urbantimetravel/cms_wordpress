<?php
$dbhandler = new PM_DBhandler;
$pmrequests = new PM_request;
$textdomain = $this->profile_magic;
$path = plugin_dir_url(__FILE__);
$gid = filter_input(INPUT_GET, 'gid');
$identifier = 'FIELDS';
$groups = $dbhandler->get_all_result('GROUPS', array('id','group_name'));
$sections = $dbhandler->get_all_result('SECTION', array('id','section_name'), array('gid' => $gid), 'results', 0, false, $sort_by = 'ordering');
$fields = $dbhandler->get_all_result($identifier, $column = '*', array('associate_group' => $gid), 'results', 0, false, $sort_by = 'ordering');
$lastrow = $dbhandler->get_all_result('SECTION', 'id', 1, 'var', 0, 1, 'id', 'DESC');
$section_ordering = $lastrow + 1;
?>

<div class="pm-group-fields-modal" id="pm-group-fields-popup" style="display: none;">
 <div class="pm-group-fields-popup-overlay pm-group-fields-popup-overlay-fade-in"></div>
 <div class="pm-group-fields-popup-wrap pm-group-fields-popup-out">
    <div class="pm-popup-header">
        <div class="pm-popup-title">
            <?php _e('Choose a field type','profilegrid-user-profiles-groups-and-communities'); ?>
        </div>
        <span class="pm-group-fields-popup-close"><img class="" src="<?php echo $path; ?>images/close-pm.png"></span>
        <span class="pg-fields-help"><a href="https://profilegrid.co/documentation/new-field/" target="_blank"><?php _e('Help','profilegrid-user-profiles-groups-and-communities');?></a></span>

    </div>
   
        <div class="pm-field-selection">
        <div class="pm-popup-field-box" onClick="add_pm_field('first_name', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?php _e('First Name','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("This field is connected directly to WordPress’ User Profile First Name field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('last_name', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?php _e('Last Name','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("This field is connected directly to WordPress’ User Profile Last Name field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('user_name', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?php _e('Username','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("If you want members to login using Username instead of email.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('nickname', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?php _e('Nickname','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("This field is connected directly to WordPress’ User Profile Nickname field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>    
            
        <?php
        $check = $pmrequests->pm_check_field_exist($gid, 'user_email', true);
        if ($check === false):
            ?>
            <div class="pm-popup-field-box" onClick="add_pm_field('user_email', '<?php echo $gid; ?>')">
                <div class="pm-popup-field-name">
                    <?php _e('User Email','profilegrid-user-profiles-groups-and-communities'); ?>
                </div>
                <div class="pm-popup-field-details"><?php _e("Member's email. Only use <u>once</u> for each profile. For secondary email, use <i>Email</i> field type.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
            </div>
        <?php endif; ?>
        <div class="pm-popup-field-box" onClick="add_pm_field('user_url', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-globe" aria-hidden="true"></i>
                <?php _e('User URL','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows members to add website address to their profiles.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('user_pass', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name" >
                <i class="fa fa-key" aria-hidden="true"></i>
                <?php _e('Password','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows members to define their own password during registration.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('confirm_pass', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-key" aria-hidden="true"></i>
                <?php _e('Confirm Password','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("To be used in conjunction with <i>Password</i> field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('description', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <?php _e('Biographical Info','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows members to enter long text.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('user_avatar', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-camera-retro" aria-hidden="true"></i>
                <?php _e('Profile Image','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows members to upload their Profile image during registration. This can be changed or removed later.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('text', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-text-width" aria-hidden="true"></i>
                <?php _e('Text','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("The common text field allowing user a single line of text.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('select', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                <?php _e('DropDown','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A dropdown with selection of predefined options. Members can only select one option.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('radio', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <?php _e('Radio','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A radiobox selection with predefined options. Members can only select one option.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('textarea', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <?php _e('Text Area','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A text area box with ability to add multiple lines of plain text.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('checkbox', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                <?php _e('Checkbox','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A checkbox selection with predefined options. Members can select multiple options.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('heading', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-header" aria-hidden="true"></i>
                <?php _e('Heading','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Large size read only text, useful for creating custom headings.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('paragraph', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-paragraph" aria-hidden="true"></i>
                <?php _e('Paragraph','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("This is a read only field which can be used to display formatted content inside the form.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('DatePicker', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <?php _e('Date','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows users to pick a date from dropdown calendar or type it manually.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('email', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <?php _e('Email','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A secondary email field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('number', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>
                <?php _e('Number','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows user to input value in numbers.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('country', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-flag" aria-hidden="true"></i>
                <?php _e('Country','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A drop down list of all countries appears to the user for selection.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('timezone', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <?php _e('Timezone','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A drop down list of all time-zones appears to the user for selection.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('term_checkbox', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-check" aria-hidden="true"></i>
                <?php _e('T&C Checkbox','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Useful for adding terms and conditions to the form. User must select the check box to continue with submission if you select “Is Required” below.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('file', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-files-o" aria-hidden="true"></i>
                <?php _e('File','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Display a field to the user for attaching files from his/ her computer.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('repeatable_text', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <?php _e('Repeatable Text','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows user to add extra text field boxes to the form for submitting different values. Useful where a field requires multiple user input values.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
        <div class="pm-popup-field-box" onClick="add_pm_field('mobile_number', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-mobile" aria-hidden="true"></i>
                <?php _e('Mobile Number','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Adds a Mobile number field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('phone_number', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <?php _e('Phone Number','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Adds a phone number field.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('gender', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-venus-mars" aria-hidden="true"></i>
                <?php _e('Gender','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Gender/ Sex selection radio box.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('language', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-language" aria-hidden="true"></i>
                <?php _e('Language','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Adds a drop down language selection field with common languages as options.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <?php /*<div class="pm-popup-field-box">
            <div class="pm-popup-field-name" onClick="add_pm_field('birth_date', '<?php echo $gid; ?>')">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <?php _e('Birth Date','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Allows user to add extra text field boxes to the form for submitting different values. Useful where a field requires multiple user input values.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>*/ ?>

        <div class="pm-popup-field-box" onClick="add_pm_field('divider', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-minus" aria-hidden="true"></i>
                <?php _e('Divider','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Divider for separating fields.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('spacing', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-minus" aria-hidden="true"></i>
                <?php _e('Spacing','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Useful for adding space between fields.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('multi_dropdown', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                <?php _e('Multi Dropdown','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A dropdown field with a twist. Users can now select more than one option.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('facebook', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                <?php _e('Facebook','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking Facebook Profile page.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('twitter', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                <?php _e('Twitter','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking Twitter Profile page.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>


        <div class="pm-popup-field-box" onClick="add_pm_field('google', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-google-plus" aria-hidden="true"></i>
                <?php _e('Google+','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking Google+ Profile page.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>


        <div class="pm-popup-field-box" onClick="add_pm_field('linked_in', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
                <?php _e('Linked In','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking Linkedin Profile page.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>


        <div class="pm-popup-field-box" onClick="add_pm_field('youtube', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-youtube" aria-hidden="true"></i>
                <?php _e('Youtube','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking Video page.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

         <div class="pm-popup-field-box" onClick="add_pm_field('mixcloud', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-mixcloud" aria-hidden="true"></i>
                <?php _e('MixCloud','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking MixCloud audio link.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
            
        <div class="pm-popup-field-box" onClick="add_pm_field('soundcloud', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
             <i class="fa fa-soundcloud" aria-hidden="true"></i>
                <?php _e('SoundCloud','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("A speciality URL field for asking SoundCloud audio link.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>

        <div class="pm-popup-field-box" onClick="add_pm_field('instagram', '<?php echo $gid; ?>')">
            <div class="pm-popup-field-name">
                <i class="fa fa-instagram   " aria-hidden="true"></i>
                <?php _e('Instagram','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="pm-popup-field-details"><?php _e("Asks User his/ her Instagram Profile.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
        </div>
            
            <?php do_action('pg_add_field_in_popup',$gid);?>
            
           <!-- <div class="pg-uim-notice-wrap"> <div class="pg-uim-notice"><?php _e("Note: More fields and registration options available through free RegistrationMagic integration.",'profilegrid-user-profiles-groups-and-communities'); ?></div></div> -->
    </div>
    </div>
 </div>


    <div class="pmagic"> 

        <!-----Operationsbar Starts----->

        <div class="operationsbar">
            <div class="pmtitle">
                <?php _e('Profile Fields Manager','profilegrid-user-profiles-groups-and-communities'); ?>
            </div>
            <div class="icons"><a href="admin.php?page=pm_add_group&id=<?php echo $gid; ?>"><img src="<?php echo $path; ?>images/global-settings.png"></a></div>
            <div class="nav">
                <ul>
                    
                    <li><a href="#new_section" onclick="pm_open_tab('new_section')">
                            <?php _e('New Section','profilegrid-user-profiles-groups-and-communities'); ?>
                        </a></li>
                        <li><a href="#" id="pg-field-selection-popup" onclick="CallFieldSelectionModal(this)">
                            <?php _e('New Field','profilegrid-user-profiles-groups-and-communities'); ?>
                        </a></li>
                        <li><a href="https://profilegrid.co/documentation/fields-manager/" target="_blank"><?php _e('Help','profilegrid-user-profiles-groups-and-communities');?></a></li>
                    <li class="pm-form-toggle">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <?php _e('Filter by','profilegrid-user-profiles-groups-and-communities'); ?>
                        <select name="associate_group" id="associate_group" onChange="redirectpmform(this.value, 'pm_profile_fields')">
                            <option value="">
                                <?php _e('Select A Group','profilegrid-user-profiles-groups-and-communities'); ?>
                            </option>
                            <?php
                            foreach ($groups as $group) {
                                ?>
                                <option value="<?php echo $group->id; ?>" <?php if (!empty($gid)) selected($gid, $group->id); ?>><?php echo $group->group_name; ?></option>
                            <?php }
                            ?>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        <!--------Operationsbar Ends-----> 

        <!----Slab View---->

        <div class="pm-field-creator" id="sections">
            <ul class="pm-page-tabs-sidebar field-tabs pm_sortable_tabs">
                <?php
                if (isset($sections)):
                    foreach ($sections as $section):
                        ?>
                        <li class="pm-page-tab field-tabs-row" id="<?php echo $section->id; ?>">
                            <div class="pm-slab-drag-handle">&nbsp;</div>
                            <a href="#<?php echo sanitize_key('profile_section_'.$section->id); ?>" onclick="pm_open_tab('<?php echo sanitize_key('profile_section_'.$section->id); ?>')">
                        <?php _e($section->section_name,'profilegrid-user-profiles-groups-and-communities'); ?>
                            </a> </li>
    <?php endforeach;
endif; ?>
                <li><a href="#new_section"></a></li>
            </ul>
            <div class="pm-custom-fields-page">
                    <?php if (isset($sections)): foreach ($sections as $section): ?>
                        <div id="<?php echo sanitize_key('profile_section_'.$section->id); ?>" class="field-selector-pills">
                                <?php $fields = $dbhandler->get_all_result($identifier, $column = '*', array('associate_group' => $gid, 'associate_section' => $section->id), 'results', 0, false, $sort_by = 'ordering'); ?>
                            <div class="pmrow"> <a href="admin.php?page=pm_add_section&id=<?php echo $section->id; ?>#<?php echo sanitize_key('profile_section_'.$section->id); ?>"><?php _e('Edit Section','profilegrid-user-profiles-groups-and-communities');?></a> <a href="admin.php?page=pm_add_section&action=delete&id=<?php echo $section->id; ?>&gid=<?php echo $gid; ?>"><?php _e('Delete Section','profilegrid-user-profiles-groups-and-communities');?></a> </div>
                            <ul class="pm_sortable_fields">
                                <?php
                                if (!empty($fields)):
                                    foreach ($fields as $field):
                                        ?>
                                        <li id="<?php echo $field->field_id; ?>">
                                            <div class="pm-custom-field-page-slab">
                                                <div class="pm-slab-drag-handle">&nbsp;</div>
                                                <div class="pm-slab-info"><?php echo $field->field_name; ?> <sup><?php echo $field->field_type; ?></sup></div>
                                                <div class="pm-slab-buttons"><a href="admin.php?page=pm_add_field&id=<?php echo $field->field_id; ?>#<?php echo sanitize_key($section->section_name); ?>"><?php _e('Edit','profilegrid-user-profiles-groups-and-communities');?></a><a href="admin.php?page=pm_add_field&id=<?php echo $field->field_id; ?>&action=delete#<?php echo sanitize_key('profile_section_'.$section->id); ?>"><?php _e('Delete','profilegrid-user-profiles-groups-and-communities');?></a></div>
                                            </div>
                                        </li>
            <?php
            endforeach;
        else:
            ?>
                                    <li>
                                        <div class="pg-uim-notice pg-uim-error"><?php _e("You haven't created any Profile Fields for this Section yet.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
                                    </li>
                        <?php
                        endif;
                        ?>
                            </ul>
                        </div>
    <?php endforeach;
endif; ?>
                <div id="new_section" class="field-selector-pills">
                    <div class="uimagic pm-section-form">
                        <form name="pm_add_section" id="pm_add_section" method="post" action="admin.php?page=pm_add_section">
                            <!-----Dialogue Box Starts----->
                            <div class="content">
                                <div class="uimrow">
                                    <div class="uimfield">
<?php _e('Section Name','profilegrid-user-profiles-groups-and-communities'); ?>
                                        <sup>*</sup></div>
                                    <div class="uiminput pm_required">
                                        <input type="text" name="section_name" id="section_name" value="<?php if (!empty($row)) echo esc_attr($row->section_name); ?>" />
                                        <div class="errortext"></div>
                                    </div>
                                    <div class="uimnote"><?php _e("Enter a name for this Profile Section.",'profilegrid-user-profiles-groups-and-communities'); ?></div>
                                </div>
                                <div class="uimrow">
                                    <div class="uimfield"> </div>
                                    <div class="uiminput">
                                        <input type="hidden" name="gid" id="gid" value="<?php echo $gid; ?>" />
                                        <input type="hidden" name="section_id" id="section_id" value="0" />
                                        <input type="hidden" name="ordering" id="ordering" value="<?php echo $section_ordering; ?>" />
<?php wp_nonce_field('save_pm_add_section'); ?>
                                        <input type="submit" value="<?php _e('Save','profilegrid-user-profiles-groups-and-communities'); ?>" name="submit_section" id="submit_section" onClick="return add_section_validation()"  />
                                        <div class="all_error_text" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($pmrequests->pm_check_field_exist($gid, 'user_pass', true) == false): ?>
    <div class="pg-uim-notice-wrap">
        <div class="pg-uim-notice"><?php _e('There’s no password field in your sign up form. You can auto-generated and email password to registering users. To do that please add password field to Account Activation email template associated with this Group.','profilegrid-user-profiles-groups-and-communities'); ?></div>
    </div>
<?php endif; ?>

    
<!-- Wrap PopUP Field Box  -->
<script>
jQuery(document).ready(function($) {
    var a = jQuery('.pm-group-fields-modal .pm-field-selection .pm-popup-field-box');
for( var i = 0; i < a.length; i+=2 ) {
    a.slice(i, i+2).wrapAll('<div class="pm-popup-field-box-wrap"></div>');
}
});


 
   function  CallFieldSelectionModal(ele) {
    jQuery("#pm-group-fields-popup").toggle();
    jQuery('.pm-group-fields-popup-wrap').removeClass('pm-group-fields-popup-out');
    jQuery('.pm-group-fields-popup-wrap').addClass('pm-group-fields-popup-in');
    jQuery('.pm-group-fields-popup-overlay').removeClass('pm-group-fields-popup-overlay-fade-out');
    jQuery('.pm-group-fields-popup-overlay').addClass('pm-group-fields-popup-overlay-fade-in');
       
}


    
    
       jQuery(document).ready(function () {
        jQuery('.pm-group-fields-popup-close, .pm-group-fields-popup-overlay').click(function () {
            setTimeout(function () {
                //jQuery(this).parents('.rm-modal-view').hide();
                jQuery('#pm-group-fields-popup').hide();
            }, 400);
                    });
            jQuery('.pm-group-fields-popup-close, .pm-group-fields-popup-overlay').on('click', function () {
            jQuery('.pm-group-fields-popup-wrap').removeClass('pm-group-fields-popup-in');
            jQuery('.pm-group-fields-popup-wrap').addClass('pm-group-fields-popup-out');

            jQuery('.pm-group-fields-popup-overlay').removeClass('pm-group-fields-popup-overlay-fade-in');
            jQuery('.pm-group-fields-popup-overlay').addClass('pm-group-fields-popup-overlay-fade-out');
        });





       
    });

 
 

</script>
