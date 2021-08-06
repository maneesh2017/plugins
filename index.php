<?php   
    /* 
    Plugin Name: custom plugin
    Plugin URI: http://www.wordpress.org 
    Description: Create plugin 
    Author: abc 
    Version: 1.1
    Author URI: http://www.xyz.com 
    */  

add_action( 'register_form', 'crf_registration_form' );
function crf_registration_form() {

	$name = ! empty( $_POST['year_of_birth'] ) ? intval( $_POST['year_of_birth'] ) : '';

	?>
	<p>
		<label for="year_of_birth"><?php esc_html_e( 'Name', 'crf' ) ?><br/>
			<input type="text"			      
			       step="1"
			       id="year_of_birth"
			       name="year_of_birth"
			       value="<?php echo esc_attr( $name ); ?>"
			       class="input"
			/>
		</label>
	</p>
	<?php
}


add_action( 'user_new_form', 'crf_admin_registration_form' );
function crf_admin_registration_form( $operation ) {
	if ( 'add-new-user' !== $operation ) {
		// $operation may also be 'add-existing-user'
		return;
	}

$new_year = ! empty( $_POST['email_of_birth'] ) ? intval( $_POST['email_of_birth'] ) : '';

	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="year_of_birth"><?php esc_html_e( 'New Email', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
			<td>
				<input type="text"			       
			       step="1"
			       id="email_of_birth"
			       name="email_of_birth"
			       value="<?php echo esc_attr( $new_year ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
	</table>
	<?php } 



add_action( 'user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3 );
function crf_user_profile_update_errors( $errors, $update, $user ) {
	if ( $update ) {
		return;
	}

	if ( empty( $_POST['email_of_birth'] ) ) {
		$errors->add( 'year_of_birth_error', __( '<strong>ERROR</strong>: Please enter your year of birth.', 'crf' ) );
	}

	
}

add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="year_of_birth"><?php esc_html_e( 'Email of birth', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'email_of_birth', $user->ID ) ); ?></td>
		</tr>
	</table>
	<?php
}

/* remove custom fields*/
add_action( 'do_meta_boxes', 'remove_default_custom_fields_meta_box', 1, 3 );
function remove_default_custom_fields_meta_box( $post_type, $context, $post ) {
    //remove_meta_box( 'email_of_birth', $post_type, $context );
}