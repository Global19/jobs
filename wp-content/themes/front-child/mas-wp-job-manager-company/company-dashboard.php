<?php
/**
 * Template for the company dashboard (`[mas_company_dashboard]`) shortcode.
 *
 * This template can be overridden by copying it to yourtheme/mas-wp-job-manager-company/company-dashboard.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     MAS WP Job Manager Company
 * @category    Template
 * @version     1.13.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$submission_limit           = get_option( 'job_manager_company_submission_limit' );
$submit_company_form_page_id = get_option( 'job_manager_submit_company_form_page_id' );
?>
<div class="row">
    <div class="col-12 col-md-3 mb-5"><?php cosmos_header_user_account_submenu(); ?></div>
    <div class="col-12 col-md-9">
        <div id="job-manager-company-dashboard" class="table-responsive-md">
            <p><?php echo esc_html( _n( 'Your project can be viewed, edited or removed below.', 'Your projects can be viewed, edited or removed below.', mas_wpjmc_company_manager_count_user_companies(), 'front' ) ); ?></p>
            <table class="job-manager-companies table">
                <thead>
                    <tr>
                        <?php foreach ( $company_dashboard_columns as $key => $column ) : ?>
                            <th class="<?php echo esc_attr( $key ); ?> text-nowrap"><?php echo esc_html( $column ); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( ! $companies ) : ?>
                        <tr>
                            <td colspan="<?php echo sizeof( $company_dashboard_columns ); ?>"><?php esc_html_e( 'You do not have any active company listings.', 'front' ); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ( $companies as $company ) : ?>
                            <tr>
                                <?php foreach ( $company_dashboard_columns as $key => $column ) : ?>
                                    <td class="<?php echo esc_attr( $key ); ?> text-nowrap">
                                        <?php if ( 'company-title' === $key ) : ?>
                                            <?php if ( $company->post_status == 'publish' ) : ?>
                                                <a class="text-body" href="<?php echo get_permalink( $company->ID ); ?>"><?php echo esc_html( $company->post_title ); ?></a>
                                            <?php else : ?>
                                                <?php echo esc_html( $company->post_title ); ?>
                                            <?php endif; ?>
                                            <ul class="company-dashboard-actions d-flex list-inline mb-0 align-items-md-center">
                                                <?php
                                                    $actions = array();

                                                    switch ( $company->post_status ) {
                                                        case 'publish' :
                                                            $actions['edit'] = array( 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false );
                                                            $actions['hide'] = array( 'label' => esc_html__( 'Hide', 'front' ), 'nonce' => true );
                                                        break;
                                                        case 'private' :
                                                            $actions['publish'] = array( 'label' => esc_html__( 'Publish', 'front' ), 'nonce' => true );
                                                        break;
                                                        case 'hidden' :
                                                            $actions['edit'] = array( 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false );
                                                            $actions['publish'] = array( 'label' => esc_html__( 'Publish', 'front' ), 'nonce' => true );
                                                        break;
                                                        case 'expired' :
                                                            if ( get_option( 'job_manager_manager_submit_company_form_page_id' ) ) {
                                                                $actions['relist'] = array( 'label' => esc_html__( 'Relist', 'front' ), 'nonce' => true );
                                                            }
                                                        break;
                                                    }

                                                    $actions['delete'] = array( 'label' => esc_html__( 'Delete', 'front' ), 'nonce' => true );

                                                    $actions = apply_filters( 'mas_job_manager_company_my_company_actions', $actions, $company );

                                                    foreach ( $actions as $action => $value ) {
                                                        $action_url = add_query_arg( array( 'action' => $action, 'company_id' => $company->ID ) );
                                                        if ( $value['nonce'] )
                                                            $action_url = wp_nonce_url( $action_url, 'mas_job_manager_company_my_company_actions' );
                                                        echo '<li class="list-inline-item"><a href="' . $action_url . '" class="company-dashboard-action-' . $action . ' ' . esc_attr( $action === "delete" ? "text-danger" : "text-secondary" ) . ' small">' . $value['label'] . '</a></li>';
                                                    }
                                                ?>
                                            </ul>
                                        <?php elseif ( 'status' === $key ) : ?>
                                            <?php mas_wpjmc_the_company_status( $company ); ?>
                                        <?php elseif ( 'date' === $key ) : ?>
                                            <?php echo date_i18n( get_option( 'date_format' ), strtotime( $company->post_date ) ); ?>
                                        <?php else : ?>
                                            <?php do_action( 'mas_job_manager_company_dashboard_column_' . $key, $company ); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if ( $submit_company_form_page_id && ( mas_wpjmc_company_manager_count_user_companies() < $submission_limit || ! $submission_limit ) ) : ?>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo sizeof( $company_dashboard_columns ); ?>">
                                <a class="btn btn-sm btn-primary" href="<?php echo esc_url( get_permalink( $submit_company_form_page_id ) ); ?>"><?php esc_html_e( 'Add Project', 'front' ); ?></a>
                            </td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
            <?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
        </div>
    </div>
</div>
