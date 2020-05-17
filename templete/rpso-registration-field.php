<?php 
	#------------------
	# Customize registration form
	#------------------

	
	######################### Add an extra field in reg form ##########################

	class RPSO_Registration_field
	{
		function __construct()
		{
			add_action( 'register_form', array($this, 'rpso_registration_form' ));
			add_filter( 'registration_errors', array($this, 'rpso_registration_sanitiz'), 10, 3 );
			add_action( 'user_register', array($this, 'rpso_save_data' ) );
		}
	
		public function rpso_registration_form() {
			global $plugin_slug;
			?>
			<p>
				<label for="rpso_phone_number">
					<?php esc_html_e( 'Phone Number', $plugin_slug ); ?> <br/>
					<input type="text" class="regular_text" name="rpso_phone_number" autocomplete="off" />
				</label>
			</p>

			<?php
		}


		######################### Validate form field ##########################

		public function rpso_registration_sanitiz( $errors, $sanitized_user_login, $user_email ) {

			global $plugin_slug;
			if ( empty( $_POST['rpso_phone_number'] ) ) {
				$errors->add( $plugin_slug, __( '<strong>ERROR</strong>: Phone number is missing.', 'rpso' ) );
			}
			else if(!is_numeric($_POST['rpso_phone_number']))
			{
				$errors->add( $plugin_slug, __( '<strong>ERROR</strong>: Phone number isn’t correct.', 'rpso' ) );
			}

			return $errors;
		}


		######################### Save data to meta data ##########################

		public function rpso_save_data( $user_id ) {
			if ( isset($_POST['rpso_phone_number']) && is_numeric($_POST['rpso_phone_number']) && $_POST['rpso_phone_number'] != "" ) {
				update_user_meta( $user_id, 'rpso_phone_number', trim( sanitize_textarea_field($_POST['rpso_phone_number']) ) ) ;		
			}
		}

	}

	new RPSO_Registration_field;