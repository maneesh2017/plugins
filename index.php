<?php   
    /**
    * Plugin Name: custom register plugin
    * Plugin URI: http://www.wordpress.org 
    * Description: Create  a custom plugin and save into database table
    * Author: abc 
    * Version: 1.1
    * Author URI: http://www.xyz.com 
    */
function register_my_custom_menu_page()
{
  
  add_menu_page('My Register Page', 'My Register Page', 'manage_options', 'my-top-level-slug');
  add_submenu_page('my-top-level-slug', 'My Register Page', 'My Register Page',
       'manage_options', 'my-top-level-slug','My_first_page_function');
 

}
add_action('admin_menu','register_my_custom_menu_page');
function my_plugin_activate() 
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'register';
   $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,     
      name tinytext NOT NULL,      
      email varchar(100) DEFAULT '' NOT NULL,
      PRIMARY KEY  (id)
   );";
   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
   update_option( "jal_db_version", $jal_db_version );

}
register_activation_hook( __FILE__, 'my_plugin_activate' );

function My_first_page_function()
{
?>
	<div class='content'>
	<h3 class="top_header"><?php _e('Register New Account');?></h3>		
 
		<form id="registration_form" class="reg_form" action="" method="POST" >
			<fieldset>
				<p>
					<label for="user_Login"><?php _e('Username');?></label>
					<input name="user_name" id="user_name" class="required"  type="text"/>
				</p>
				<p>
					<label for="user_email"><?php _e('Email');?></label>
					<input name="user_email" id="user_email" class="required" type="email" required="required" />
				</p>
				
				<p>

					<input type="submit" name='reg_sub' value="submit" id="submitDemo22"/>
				</p>
			</fieldset>
		</form>
		<?php submit_post_data(); ?>
		<?php display_data(); ?>
	</div>
<?php
}
add_shortcode( 'user_reg', 'My_first_page_function' );


function submit_post_data()
{
	if ( isset( $_POST['reg_sub'] ) )
     {
        
        global $wpdb;
        $tablename=$wpdb->prefix.'register';
        if(!isset($_POST['user_name']) || empty($_POST['user_name'])) 
        {
        	echo "username is empty or not set";
        	exit;
        } 
         if(!isset($_POST['user_email']) || empty($_POST['user_email'])) 
        {
        	echo "useremail is empty or not set";
        	exit;
        }         

        $data=array(
            'name' => $_POST['user_name'], 
            'email' => $_POST['user_email']            
            );  

        $success=$wpdb->insert($tablename,$data);

        if($success)
        {
                  
             echo $res= "data saved";     
                  
        }
        else
        {
            echo $res= "No data saved";
        }
    }
}

function display_data()
{
	            global $wpdb;
        $tablename=$wpdb->prefix.'register';
				$results = $wpdb->get_results( "SELECT * FROM $tablename"); // Query to fetch data from database table and storing in $results
						if(!empty($results))                        // Checking if $results have some values or not
						{    
						    echo "<table width='100%' border='0'>"; // Adding <table> and <tbody> tag outside foreach loop so that it wont create again and again
						    echo "<tbody>";  
						    echo "<tr>";                           // Adding rows of table inside foreach loop
						    echo "<th>ID</th>" ;
						    echo "<th>User name</th>";
						    echo "<th>Email</th>";
						    echo "</tr>";    
						    foreach($results as $row){   
						                  
						    
						     
						    echo "<tr>";                           // Adding rows of table inside foreach loop
						    echo "<td>" . $row->id . "</td>";
						    echo "<td>" . $row->name . "</td>";
						    echo "<td>" . $row->email . "</td>";
						    echo "</tr>";
						
						    }
						    echo "</tbody>";
						    echo "</table>"; 
						    

						}
}

function myprefix_scripts() 
{

    wp_enqueue_style('name-of-style-css', plugin_dir_path(__FILE__) . '/css/ccsfilename.css');
}

add_action( 'wp_enqueue_scripts', 'myprefix_scripts' );

?>





