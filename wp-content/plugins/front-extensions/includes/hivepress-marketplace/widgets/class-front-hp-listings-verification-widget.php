<?php
/**
 * Listings Verification widget
 *
 * @package Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Widget Listings Verification class.
 */
class Front_HP_Listings_Verification_Widget extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $widget_ops = array( 'description' => esc_html__( 'Add HP listings verification filter widgets to your sidebar.', 'front-extensions' ) );
        parent::__construct( 'front_hp_listings_verification', esc_html__( 'Front Filter HP Listings Verification', 'front-extensions' ), $widget_ops );
    }

    /**
     * Updates a particular instance of a widget.
     *
     * @see WP_Widget->update
     *
     * @param array $new_instance New Instance.
     * @param array $old_instance Old Instance.
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        return $instance;
    }

    /**
     * Outputs the settings update form.
     *
     * @see WP_Widget->form
     *
     * @param array $instance Instance.
     */
    public function form( $instance ) {
        global $wp_registered_sidebars;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Verification', 'front-extensions' );

        // If no sidebars exists.
        if ( ! $wp_registered_sidebars ) {
            echo '<p>'. esc_html__('No sidebars are available.', 'front-extensions' ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'front-extensions' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget( $args, $instance ) {
        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        $this->output();

        echo wp_kses_post( $args['after_widget'] );

        echo ob_get_clean();
    }

    /**
     * Return the available filter values.
     *
     * @return string
     */
    protected function get_available_filters() {
        $args = apply_filters( 'front_hp_listings_verification_widget_avilable_filter_options', array(
            'verified'  => esc_html__( 'Verified', 'front-extensions' ),
            'unverified'=> esc_html__( 'Unverified', 'front-extensions' ),
        ) );
        return $args;
    }

    /**
     * Show verifcation list html.
     *
     * @param  array  $terms Terms.
     * @param  string $taxonomy Taxonomy.
     * @param  string $query_type Query Type.
     * @return bool   Will nav display?
     */
    protected function output() {
        if ( function_exists( 'front_hp_is_listing_taxonomy' ) && front_hp_is_listing_taxonomy() ) {
            $queried_object = get_queried_object();
            $current_url = get_term_link( $queried_object->slug, $queried_object->taxonomy );
        } else {
            $current_url = get_post_type_archive_link( 'hp_listing' );
        }

        $avilable_filter_options = $this->get_available_filters();

        if( isset( $_GET ) ) {
            foreach( $_GET as $key => $value ) {
                if( $key !== 'pagename' && ! empty( $value ) ) {
                    $current_url = add_query_arg( $key, $value, $current_url );
                }
            }
        }

        $current_filter = isset( $_GET['varication'] ) ? front_clean( wp_unslash( $_GET['varication'] ) ) : '';

        echo '<ul class="front-hp-listings-verification-widget list-group list-group-flush list-group-borderless mb-0">';
        foreach ( $avilable_filter_options as $value => $name ) {
            $active_class = '';
            if( ! empty( $current_filter ) ) {
                $link = remove_query_arg( 'varication', $current_url );

                if( $current_filter === $value ) {
                    $active_class = ' active';
                } else {
                    $link = add_query_arg( 'varication', $value, $link );
                }
            } else {
                $link = add_query_arg( 'varication', $value, $current_url );
            }

            $link = str_replace( '%2C', ',', $link );

            ?><li><a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $link ); ?>"><?php
                echo esc_html( $name );
            ?></a></li><?php
        }
        echo '</ul>';
    }
}
