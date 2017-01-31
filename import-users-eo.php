<?php
/*
Plugin Name: Import users from CSV with meta EO
Plugin URI: http://www.myenglishonline.ca
Description: This plugin is forked from Import users from CSV with meta by Codection allows to import users using CSV files to WP database automatically
Author: English Online forked from codection
Version: 1.0
Author URI: https://myenglishonline.ca
*/

$url_plugin = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__), "", plugin_basename(__FILE__));
$wp_users_fields = array("user_nicename", "user_url", "display_name", "nickname", "first_name", "last_name", "description", "jabber", "aim", "yim", "user_registered", "Password");
$wp_min_fields = array("Username", "Email");

function acui_init(){
        acui_activate();
}

function acui_activate(){
}

function acui_deactivate(){
       delete_option("acui_columns");
}

function acui_menu() {
        add_submenu_page( 'tools.php', 'Insert users massively (CSV)', 'Import users from CSV', 'manage_options', 'acui', 'acui_options' ); 
}

function acui_detect_delimiter($file){
       $handle = @fopen($file, "r");
       $sumComma = 0;
       $sumSemiColon = 0;
       $sumBar = 0; 

   if($handle){
       while (($data = fgets($handle, 4096)) !== FALSE):
               $sumComma += substr_count($data, ",");
               $sumSemiColon += substr_count($data, ";");
               $sumBar += substr_count($data, "|");
           endwhile;
  }
    fclose($handle);
   
   if(($sumComma > $sumSemiColon) && ($sumComma > $sumBar))
        return ",";
   else if(($sumSemiColon > $sumComma) && ($sumSemiColon > $sumBar))
        return ";";
    else 
       return "|";
}

function acui_string_conversion( $string ){
      if(!preg_match('%(?:
   [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
   |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
    |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
    |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
    |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
    |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
    |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
    )+%xs', $string)){
                return utf8_encode($string);
    }
        else
                return $string;
}

function acui_import_users( $file, $form_data, $attach_id ){?>
        <div class="wrap">
                <h2>Importing users</h2>       
                <?php
                       set_time_limit(0);
                       global $wpdb;
                        $headers = array();
                       $role = $form_data["role"];
                       $empty_cell_action = $form_data["empty_cell_action"];
                       
                        global $wp_users_fields;
                        global $wp_min_fields; 
       
                        echo "<h3>Ready to registers</h3>";
                        echo "<p>First row represents the form of sheet</p>";
                        $row = 0;

                        ini_set('auto_detect_line_endings',TRUE);

                        $delimiter = acui_detect_delimiter($file);

                        $manager = new SplFileObject($file);
                        while ( $data = $manager->fgetcsv($delimiter) ):
                                if( empty($data[0]) )
                                        continue;

                               if( count($data) == 1 )
                                       $data = $data[0];
                              
                                foreach ($data as $key => $value)   {
                                        $data[$key] = trim($value);
                               }

                                for($i = 0; $i < count($data); $i++){
                                        $data[$i] = acui_string_conversion($data[$i]);
                                }
                              
                               if($row == 0):
                                        // check min columns username - email
                                        if(count($data) < 2){
                                                echo "<div id='message' class='error'>File must contain at least 2 columns: username and email</div>";
                                                break;
                                       }

                                        $i = 0;
                                        $password_position = false;
                                        foreach($data as $element){
                                               $headers[] = $element;

                                                if(strtolower($element) == "password")
                                                        $password_position = $i;

                                                $i++;
                                        }

                                        foreach($data as $element)
                                               $headers[] = $element;

                                       $columns = count($data);

                                       $headers_filtered = array_diff($headers, $wp_users_fields);
                                        $headers_filtered = array_diff($headers_filtered, $wp_min_fields);
                                       update_option("acui_columns", $headers_filtered);
                                       ?>
                                       <h3>Inserting and updating data</h3>
                                       <table>
                                              <tr><th>Row</th><?php foreach($headers as $element) echo "<th>" . $element . "</th>"; ?></tr>
                                        <?php
                                        $row++;
                                else:
                                        if(count($data) != $columns): // if number of columns is not the same that columns in header
                                                echo '<script>alert("Row number: ' . $row . ' has no the same columns than header, we are going to skip");</script>';
                                                continue;
                                       endif;

                                       $username = $data[0];
                                        $email = $data[1];
                                       $user_id = 0;
                                        $displayname = $data[2];

                                        if($password_position === false)
                                               $password = wp_generate_password();
                                       else
                                               $password = $data[ $password_position ];

                                        if( username_exists($username) ){ // if user exists, we take his ID by login
                                                echo '<script>alert("Username: ' . $username . ' already in use, we are going to skip");</script>';
						                          continue;

                                                if( !empty($password) )
                                                       wp_set_password( $password, $user_id );
                                       }
                                       elseif( email_exists( $email ) ){ // if the email is registered, we take the user from this
                           echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
							continue;
                          

                            if( !empty($password) )
                                wp_set_password( $password, $user_id );
                                       }
                                       else{
                                               if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
                                                       $password = wp_generate_password();

                                                $user_id = wp_create_user($username, $password, $email);
                                        }
                                             
                                       if( is_wp_error($user_id) ){ // in case the user is generating errors after this checks
                                               echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
                                               continue;
                                       }

                                       if(!( in_array("administrator", acui_get_roles($user_id), FALSE) || is_multisite() && is_super_admin( $user_id ) ))
                                               wp_update_user(array ('ID' => $user_id, 'role' => $role)) ;
                                              
                                       if($columns > 2){
                                            wp_update_user(array ('ID' => $user_id, 'display_name' => $displayname)) ;
                                           wp_update_user(array ('ID' => $user_id, 'learndash_group_users_19109' => '19109')) ;
                                            update_user_meta(array ('ID' => $user_id, 'learndash_group_users_19109' => '19109')) ;
                                              for( $i=2 ; $i<$columns; $i++ ):
                                                       if( !empty( $data ) ){
                                                               if(strtolower( $headers[$i] ) == "password"){ // passwords -> continue
                                                                        continue;
                                                              }
                                                               else{
                                                                       if( in_array( $headers[$i], $wp_users_fields ) ){ // wp_user data
                                                                              
                                                                               if( empty( $data[ $i ] ) && $empty_cell_action == "leave" )
                                                                                       continue;
                                                                                else
                                                                                       wp_update_user( array( 'ID' => $user_id, $headers[$i] => $data[$i] ) );
                                                                              
                                                                        }
                                                                        else{ // wp_usermeta data
                                                                              
                                                                               if( empty( $data[ $i ] ) ){
                                                                                        if( $empty_cell_action == "delete" )
                                                                                                delete_post_meta( $user_id, $headers[$i] );
                                                                                       else
                                                                                               continue;       
                                                                               }
                                                                                else
                                                                                        update_user_meta( $user_id, $headers[$i], $data[$i] );

                                                                        }
                                                                }
                                                       }
                                               endfor;
                                       }

                                      echo "<tr><td>" . ($row - 1) . "</td>";
                                       foreach ($data as $element)
                                               echo "<td>$element</td>";

                                        echo "</tr>\n";

                                        flush();

                                                wp_new_user_notification( $user_id, $notify = '' );

                                            
                                endif;

                               $row++;                                         
                        endwhile;

	                        wp_delete_attachment( $attach_id );

                        ?>
                        </table>
                       <br/>
                        <p>Process finished you can go <a href="<?php echo get_admin_url() . '/users.php'; ?>">here to see results</a></p>
                        <?php
                        //fclose($manager);
                        ini_set('auto_detect_line_endings',FALSE);
                ?>
        </div>
<?php
}

function acui_get_roles($user_id){
       $roles = array();
        $user = new WP_User( $user_id );

        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
                foreach ( $user->roles as $role )
                        $roles[] = $role;
       }

       return $roles;
}

function acui_get_editable_roles() {
   global $wp_roles;

   $all_roles = $wp_roles->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);
   $list_editable_roles = array();

    foreach ($editable_roles as $key => $editable_role)
                $list_editable_roles[$key] = $editable_role["name"];
      
   return $list_editable_roles;
}
	
function acui_options() 
{
       global $url_plugin;

        if (!current_user_can('create_users')) 
       {
                wp_die(__('You are not allowed to see this content.'));
               $acui_action_url = admin_url('options-general.php?page=' . plugin_basename(__FILE__));
       }
        else if( isset( $_POST['uploadfile'] ) ){
                acui_fileupload_process( $_POST );
        }
        else
        {
              
        $args_old_csv = array( 'post_type'=> 'attachment', 'post_mime_type' => 'text/csv', 'post_status' => 'inherit', 'posts_per_page' => -1 );
        $old_csv_files = new WP_Query( $args_old_csv );
?>
        <script>       
        jQuery(document).ready(function($) {
                $('.postbox').children('h3, .handlediv').click(function(){ $(this).siblings('.inside').toggle();});
        });
        </script>

       <div class="wrap">     

                <?php if( $old_csv_files->found_posts > 0 ): ?>
               <div class="postbox">
                    <div title="Click to open/close" class="handlediv">
                     <br>
                    </div>

                   <h3 class="hndle"><span>&nbsp;Old CSV files uploaded</span></h3>

                   <div class="inside" style="display: block;">
                        <p>For security reasons you should delete this files, probably they would be visible in the Internet if a bot or someone discover the URL. You can delete each file or maybe you want delete all CSV files you have uploaded:</p>
                        <input type="button" value="Delete all CSV files uploaded" id="bulk_delete_attachment" style="float:right;"></input>
                       <ul>
                               <?php while($old_csv_files->have_posts()) : 
                                       $old_csv_files->the_post(); 

                                       if( get_the_date() == "" )
                                               $date = "undefined";
                                        else
                                               $date = get_the_date();
                                ?>
                                <li><a href="<?php echo wp_get_attachment_url( get_the_ID() ); ?>"><?php the_title(); ?></a> uploaded the <?php echo $date; ?> <input type="button" value="Delete" class="delete_attachment" attach_id="<?php the_ID(); ?>"></input></li>
                               <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                        </ul>
                       <div style="clear:both;"></div>
                    </div>
                </div>
                <?php endif; ?> 

               <div id='message' class='updated'>File should automatically come from the database with 5 columns in this order: username, email, first_name, last_name, learner. See below for more instructions.</div>
               
                <div style="float:left; width:80%;">
                        <h2>Import users from CSV</h2>
                </div>

                <div style="clear:both;"></div>

                <div style="width:100%;">
                       <form method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8" onsubmit="return check();">
                       <table class="form-table">
                                <tbody>
                                <tr class="form-field">
                                        <th scope="row"><label for="role">Role</label></th>
                                       <td>
                                        <select name="role" id="role">
                                                <?php 
                                                        $list_roles = acui_get_editable_roles(); 
                                                        foreach ($list_roles as $key => $value) {
                                                               if($key == "subscriber")
                                                                       echo "<option selected='selected' value='$key'>$value</option>";
                                                               else
                                                                       echo "<option value='$key'>$value</option>";
                                                        }
                                               ?>
                                       </select>
                                        </td>
                               </tr>
                                <tr class="form-field form-required">
                                       <th scope="row"><label>CSV file <span class="description">(required)</span></label></th>
                                       <td><input type="file" name="uploadfiles[]" id="uploadfiles" size="35" class="uploadfiles" /></td>
                               </tr>
                                <tr class="form-field form-required">
                                        <th scope="row"><label>What should do the plugin with empty cells?</label></th>
                                       <td>
                                               <select name="empty_cell_action">
                                                        <option value="delete">Delete the metadata</option>
                                                       <option value="leave" selected>Leave the old value for this metadata</option>
                                               </select>
                                       </td>
                               </tr>
                                </tbody>
                        </table>
                        <input class="button-primary" type="submit" name="uploadfile" id="uploadfile_btn" value="Start importing"/>
                        </form>
               </div>

               <div style="clear:both; width:100%;"></div>

                <?php 
               $headers = get_option("acui_columns"); 

                if(is_array($headers) && !empty($headers)):
                ?>

                <?php endif; ?>
                <h3>EO Instructions</h3>
              <table class="form-table">
                <tbody>
                        <tr valign="top">
                               <th scope="row">Have csv file from database ready to upload</th>
                               <td>If csv in the file extension is written in capitals like .CSV, you will have to edit the file name to be .csv or the plugin will not accept it.
                                </td>
                        </tr>
                        <tr valign="top">
                               <th scope="row">Steps and Options</th>
                               <td><ol>
                                       <li>Leave "Role" as "Subscriber".</li>
                                        <li>Select the csv file from your computer with the "Choose File" button.</li>
                                        <li>Leave "Leave the old value for this metadata" selected.</li>
                                        <li>Click the "Start Importing" button.</li></ol>
                                </td>
                        </tr>
                        <tr valign="top">
                               <th scope="row">After Uploading</th>
                               <td>After you click the upload button, you will be shown a list of the successfully uploaded learners. If there were problems with any of the entries, you will get an alert. Take note of their info and click OK. If there are any problems make sure to notify everyone involved in the registration process.
                                </td>
                        </tr>
                </tbody>
            </table>
               <h3>More Info</h3>
               <table class="form-table">
               <tbody>
                       <tr valign="top">
                               <th scope="row">Columns position</th>
                               <td>The csv file from the database should have the following columns:
                                        <ol>
                                               <li>username</li>
                                                <li>email</li>
                                                <li>first_name</li>
                                                <li>last_name</li>
                                                <li>learner</li>
                                       </ol>                                           
                                </td>
                       </tr>
                        <tr valign="top">
                                <th scope="row">Passwords</th>
                               <td>Password links are sent to the users in the 1/3 Welcome message. They will click these links and set their own passwords to be whatever they like.
                                </td>
                       </tr>

               </tbody></table>

       </div>
       <script type="text/javascript">
        function check(){
               if(document.getElementById("uploadfiles").value == "") {
                  alert("Please choose a file");
                   return false;
                }
        }

        function showMe (box) {
           var chboxs = document.getElementsByName("sends_email");
           var vis = "none";
            for(var i=0;i<chboxs.length;i++) {
               if(chboxs[i].checked){
                vis = "block";
                    break;
                }
            }
            document.getElementById(box).style.display = vis;
       }

       jQuery( document ).ready( function( $ ){
               $( ".delete_attachment" ).click( function(){
                        var answer = confirm( "Are you sure to delete this file?" );
                        if( answer ){
                                var data = {
                                       'action': 'acui_delete_attachment',
                                        'attach_id': $( this ).attr( "attach_id" )
                               };

                               $.post(ajaxurl, data, function(response) {
                                        if( response != 1 )
                                               alert( "There were problems deleting the file, please check file permissions" );
                                        else{
                                                alert( "File successfully deleted" );
                                               document.location.reload();
                                        }
                                });
                        }
                });

                $( "#bulk_delete_attachment" ).click( function(){
                       var answer = confirm( "Are you sure to delete ALL CSV files uploaded? There can be CSV files from other plugins." );
                       if( answer ){
                               var data = {
                                       'action': 'acui_bulk_delete_attachment',
                              };

                               $.post(ajaxurl, data, function(response) {
                                       if( response != 1 )
                                                alert( "There were problems deleting the files, please check files permissions" );
                                       else{
                                               alert( "Files successfully deleted" );
                                               document.location.reload();
                                      }
                               });
                      }
               });

       } );
        </script>
<?php
        }
}

/**
* Handle file uploads
 *
* @todo check nonces
* @todo check file size
*
* @return none
 */
function acui_fileupload_process( $form_data ) {
  $uploadfiles = $_FILES['uploadfiles'];
  $role = $form_data["role"]; 
 
  if ( is_array($uploadfiles) ) {

	        foreach ( $uploadfiles['name'] as $key => $value ) {

          // look only for uploded files
          if ($uploadfiles['error'][$key] == 0) {
                $filetmp = $uploadfiles['tmp_name'][$key];

                //clean filename and extract extension
                $filename = $uploadfiles['name'][$key];

                // get file info
                // @fixme: wp checks the file extension....
                $filetype = wp_check_filetype( basename( $filename ), array('csv' => 'text/csv') );
               $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
                $filename = $filetitle . '.' . $filetype['ext'];
                $upload_dir = wp_upload_dir();
              
               if ($filetype['ext'] != "csv") {
                 wp_die('File must be a CSV');
                 return;
               }

               /**
                * Check if the filename already exist in the directory and rename the
                 * file if necessary
                 */
             $i = 0;
             while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
               $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
               $i++;
             }
             $filedest = $upload_dir['path'] . '/' . $filename;

             /**
              * Check write permissions
              */
             if ( !is_writeable( $upload_dir['path'] ) ) {
               wp_die('Unable to write to directory. Is this directory writable by the server?');
               return;
             }

             /**
              * Save temporary file to uploads dir
              */
             if ( !@move_uploaded_file($filetmp, $filedest) ){
               wp_die("Error, the file $filetmp could not moved to : $filedest ");
               continue;
             }

             $attachment = array(
               'post_mime_type' => $filetype['type'],
               'post_title' => $filetitle,
               'post_content' => '',
               'post_status' => 'inherit'
             );

             $attach_id = wp_insert_attachment( $attachment, $filedest );
             require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
             $attach_data = wp_generate_attachment_metadata( $attach_id, $filedest );
             wp_update_attachment_metadata( $attach_id,  $attach_data );
            
             acui_import_users($filedest, $form_data, $attach_id);
       }
     }
  }
}

function acui_extra_user_profile_fields( $user ) {
     global $wp_users_fields;
     global $wp_min_fields;

     $headers = get_option("acui_columns");
     if( is_array($headers) && !empty($headers) ):
?>
     <?php
     endif;
}

function acui_save_extra_user_profile_fields( $user_id ){
     if (!current_user_can('create_users', $user_id)) { return false; }

     global $wp_users_fields;
     global $wp_min_fields;
     $headers = get_option("acui_columns");

        $post_filtered = filter_input_array( INPUT_POST );

        if( is_array($headers) && count($headers) > 0 ):
               foreach ($headers as $column){
                        if(in_array($column, $wp_min_fields) || in_array($column, $wp_users_fields))
                               continue;

                        $column_sanitized = str_replace(" ", "_", $column);
                        update_user_meta( $user_id, $column, $post_filtered[$column_sanitized] );
                }
        endif;
}

function acui_modify_user_edit_admin(){
        global $pagenow;

        if(in_array($pagenow, array("user-edit.php", "profile.php"))){
        $acui_columns = get_option("acui_columns");
       
        if(is_array($acui_columns) && !empty($acui_columns)){
                $new_columns = array();
                $core_fields = array(
                   'username',
                    'user_email',
                    'first_name',
                    'role',
                    'last_name',
                   'nickname',
                    'display_name',
                    'description',
                    'billing_first_name',
                    'billing_last_name',
                    'billing_company',
                    'billing_address_1',
                   'billing_address_2',
                   'billing_city',
                    'billing_postcode',
                   'billing_country',
                    'billing_state',
                    'billing_phone',
                    'billing_email',
                   'shipping_first_name',
                   'shipping_last_name',
                   'shipping_company',
                    'shipping_address_1',
                    'shipping_address_2',
                    'shipping_city',
                   'shipping_postcode',
                    'shipping_country',
                    'shipping_state'
                );
      
                foreach ($acui_columns as $key => $column) {
               
                if(in_array($column, $core_fields)) {
                        // error_log('removing column because core '.$column);
                        continue;
                }
               if(in_array($column, $new_columns)) {
                        // error_log('removing column because not unique '.$column);
                        continue;
                }
               
                array_push($new_columns, $column);
                }
               
                update_option("acui_columns", $new_columns);
                }
        }
}

function acui_delete_attachment() {
        $attach_id = intval( $_POST['attach_id'] );

       $result = wp_delete_attachment( $attach_id, true );

        if( $result === false )
               echo 0;
       else
               echo 1;

        wp_die();
}

function acui_bulk_delete_attachment(){
        $args_old_csv = array( 'post_type'=> 'attachment', 'post_mime_type' => 'text/csv', 'post_status' => 'inherit', 'posts_per_page' => -1 );
        $old_csv_files = new WP_Query( $args_old_csv );
       $result = 1;

        while($old_csv_files->have_posts()) : 
                $old_csv_files->the_post(); 

                if( wp_delete_attachment( get_the_ID(), true ) === false )
                        $result = 0;
        endwhile;
       
        wp_reset_postdata();

        echo $result;

        wp_die();
}
       
register_activation_hook(__FILE__,'acui_init'); 
register_deactivation_hook( __FILE__, 'acui_deactivate' );
add_action("plugins_loaded", "acui_init");
add_action("admin_menu", "acui_menu");
add_action('admin_init', 'acui_modify_user_edit_admin' );
add_action("show_user_profile", "acui_extra_user_profile_fields");
add_action("edit_user_profile", "acui_extra_user_profile_fields");
add_action("personal_options_update", "acui_save_extra_user_profile_fields");
add_action("edit_user_profile_update", "acui_save_extra_user_profile_fields");
add_action( 'wp_ajax_acui_delete_attachment', 'acui_delete_attachment' );
add_action( 'wp_ajax_acui_bulk_delete_attachment', 'acui_bulk_delete_attachment' );

// misc
if (!function_exists('str_getcsv')) { 
    function str_getcsv($input, $delimiter = ',', $enclosure = '"', $escape = '\\', $eol = '\n') { 
       if (is_string($input) && !empty($input)) { 
           $output = array(); 
           $tmp    = preg_split("/".$eol."/",$input); 
           if (is_array($tmp) && !empty($tmp)) { 
               while (list($line_num, $line) = each($tmp)) { 
                   if (preg_match("/".$escape.$enclosure."/",$line)) { 
                       while ($strlen = strlen($line)) { 
                           $pos_delimiter       = strpos($line,$delimiter); 
                           $pos_enclosure_start = strpos($line,$enclosure); 
                           if ( 
                               is_int($pos_delimiter) && is_int($pos_enclosure_start) 
                               && ($pos_enclosure_start < $pos_delimiter) 
                               ) { 
                               $enclosed_str = substr($line,1); 
                               $pos_enclosure_end = strpos($enclosed_str,$enclosure); 
                               $enclosed_str = substr($enclosed_str,0,$pos_enclosure_end); 
                               $output[$line_num][] = $enclosed_str; 
                               $offset = $pos_enclosure_end+3; 
                           } else { 
                              if (empty($pos_delimiter) && empty($pos_enclosure_start)) { 
                                   $output[$line_num][] = substr($line,0); 
                                   $offset = strlen($line); 
                               } else { 
                                   $output[$line_num][] = substr($line,0,$pos_delimiter); 
                                   $offset = ( 
                                               !empty($pos_enclosure_start) 
                                               && ($pos_enclosure_start < $pos_delimiter) 
                                              ) 
                                              ?$pos_enclosure_start 
                                               :$pos_delimiter+1; 
                               } 
                           } 
                           $line = substr($line,$offset); 
                      } 
                  } else { 
                       $line = preg_split("/".$delimiter."/",$line); 

                      /*
                       * Validating against pesky extra line breaks creating false rows.
                       */ 
                     if (is_array($line) && !empty($line[0])) { 
                          $output[$line_num] = $line; 
                      } 
                  } 
             } 
              return $output; 
          } else { 
               return false; 
           } 
       } else { 
           return false; 
       } 
   } 
} 

if (!function_exists('set_html_content_type')) { 
        function set_html_content_type() {
               return 'text/html';
       }
}