<?php
/**
 * Shows the `tag-input` form field on job listing forms.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/form-fields/tag-input-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

wp_enqueue_script( 'bootstrap-tagsinput' );

?>
<div class="u-tagsinput">
    <input type="text" class="input-tag" data-role="tagsinput" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"<?php if ( isset( $field['autocomplete'] ) && false === $field['autocomplete'] ) { echo ' autocomplete="off"'; } ?> id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>" value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>" maxlength="<?php echo esc_attr( ! empty( $field['maxlength'] ) ? $field['maxlength'] : '99' ); ?>" <?php if ( ! empty( $field['required'] ) ) echo 'required'; ?> />
</div>
<?php if ( ! empty( $field['description'] ) ) : ?><small class="description"><?php echo wp_kses_post( $field['description'] ); ?></small><?php endif; ?>
    <!-- Tags Input -->
