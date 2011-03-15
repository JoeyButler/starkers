<?php
if ( !class_exists('CustomFields') ) {

	class CustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = '';
		/**
		* @var  array  $postTypes  An array of public custom post types, plus the standard "post" and "page" - add the custom types you want to include here
		*/
		var $postTypes;
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields;
		/**
		* PHP 4 Compatible Constructor
		*/
		function CustomFields($customFields) { $this->__construct(); }
		/**
		* PHP 5 Constructor
		*/
		function __construct($customFields) {
			$this->customFields = $customFields;
			$this->postTypes = $this->findUniquePostTypes($customFields);
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
			// Comment this line out if you want to keep default custom fields meta box
			add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
			wp_register_style( 'custom_fields', get_bloginfo('template_url') . '/css/custom_fields.css' );
			wp_enqueue_style( 'custom_fields' );
		}
		
		function findUniquePostTypes($customFields)
		{
			$postTypes = array();
			for( $i=0; $i < count($customFields); $i++ )
			{
				if( isset($customFields[$i]['scope']) )
					$postTypes []= $customFields[$i]['scope'];
			}
			return array_unique( $this->array_flatten($postTypes) );
		}
		
		/**
		* Remove the default Custom Fields meta box
		*/
		function removeDefaultCustomFields( $type, $context, $post ) {
			foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
				foreach ( $this->postTypes as $postType ) {
					remove_meta_box( 'postcustom', $postType, $context );
				}
			}
		}
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			if ( function_exists( 'add_meta_box' ) ) {
				foreach ( $this->postTypes as $postType ) {
					add_meta_box( 'my-custom-fields', 'Custom Fields', array( &$this, 'displayCustomFields' ), $postType, 'normal', 'high' );
				}
			}
		}
		
		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post;
			?>
			<div class="form-wrap">
				<?php
				wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
				foreach ( $this->customFields as $customField ) {
					// Check scope
					$scope = $customField[ 'scope' ];
					$output = false;
					foreach ( $scope as $scopeItem ) {
						switch ( $scopeItem ) {
							default: {
								if ( $post->post_type == $scopeItem )
									$output = true;
								break;
							}
						}
						if ( $output ) break;
					}
					// Check capability
					if ( !current_user_can( $customField['capability'], $post->ID ) )
						$output = false;
					// Output if allowed
					if ( $output ) { ?>
						<div class="form-field form-required">
							<?php
							switch ( $customField[ 'type' ] ) {
								case "checkbox": {
									// Checkbox
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&nbsp;&nbsp;';
									echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
									if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
										echo ' checked="checked"';
									echo '" style="width: auto;" />';
									break;
								}
								case "boolean": { ?>
									<?php $field_value = get_post_meta( $post->ID, $this->prefix . $customField['name'], true ); ?>
									<?php $is_yes = ( $field_value == "yes" ); ?>
									<?php $is_no = ( empty($field_value) || $field_value == "no" ); ?>
									<p><strong><?php echo $customField[ 'title' ] ?></strong></p>
									<ul class="boolean">
										<li>
											<input type="radio" name="<?php echo $this->prefix . $customField[ 'name' ] ?>" id="<?php echo $this->prefix . $customField['name'] ?>_yes" value="yes" <?php if($is_yes): ?> checked="checked"<?php endif ?> />
											<label for="<?php echo $this->prefix . $customField[ 'name' ] ?>">Yes</label>
										</li>
										<li>
											<input type="radio" name="<?php echo $this->prefix . $customField[ 'name' ] ?>" id="<?php echo $this->prefix . $customField['name'] ?>_no" value="no" <?php if($is_no): ?> checked="checked"<?php endif ?> />
											<label for="<?php echo $this->prefix . $customField[ 'name' ] ?>">No</label>
										</li>
										<div class="clear">&nbsp;</div>
									</ul>
								<?php
									break;
								}
								case "textarea":
								case "wysiwyg": {
									// Text area
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
									// WYSIWYG
									if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
										<script type="text/javascript">
											jQuery( document ).ready( function() {
												jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
												if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
													tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
												}
											});
										</script>
									<?php }
									break;
								}
								default: {
									// Plain text field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									break;
								}
							}
							?>
							<?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
						</div>
					<?php
					}
				} ?>
			</div>
			<?php
		}
		/**
		* Save the new Custom Fields values
		*/
		function saveCustomFields( $post_id, $post ) {
			if ( !isset( $_POST[ 'my-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			if ( ! in_array( $post->post_type, $this->postTypes ) )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) ) {
					if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
						$value = $_POST[ $this->prefix . $customField['name'] ];
						// Auto-paragraphs for any WYSIWYG
						if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
					} else {
						delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
					}
				}
			}
		}
		
		function array_flatten($a, $f = array())
		{
			if( !$a || !is_array($a) ) return '';
			foreach($a as $k => $v)
			{
				if( is_array($v) ) $f = $this->array_flatten($v, $f);
				else $f[$k] = $v;
			}
			return $f;
		}

	} // End Class

} // End if class exists statement

?>