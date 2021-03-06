<?php
	if( ! function_exists( 'front_single_job_listing_company' ) ) {
	    function front_single_job_listing_company() {
	        ?>
	        <div class="mb-4">
	            <?php
			    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
			    		if (isset(get_post_meta(cosmos_get_post_id())['_company_name'][0])) {
			    			$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
			    		}
			    		if (isset(get_post_meta($company_id, '_company_logo')[0])) {
			    			$company_image = get_post_meta($company_id, '_company_logo')[0];
			    		}
								if (!empty($company_image)) {
									$image = $company_image;
								}else{
									$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
								}
	            if( !empty( $company_excerpt = front_get_the_job_listing_company_excerpt() ) ) :
	                if( ( $pos = strrpos( $company_excerpt , '<p>' ) ) !== false ) {
	                    $search_length  = strlen( '<p>' );
	                    $company_excerpt = substr_replace( $company_excerpt , '<p class="mb-0">' , $pos , $search_length );
	                }
	                ?>
	            		<img class="u-clients mb-4" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
	                <h4 class="h6"><?php esc_html_e( 'About', 'front' ); ?></h4>
	                <div class="font-size-1 text-secondary text-lh-md"><?php echo wp_kses_post( $company_excerpt ); ?></div>
	                <?php
	            endif;
	            if( !empty( $company = front_get_the_job_listing_company() ) ) :
	                ?>
	                    <a class="font-size-1 btn btn-primary mt-3" href="<?php the_permalink( $company ); ?>"><?php esc_html_e( 'View project profile', 'front' ); ?></a>
	                <?php
	            endif;
	            ?>
	        </div>
	        <?php

	    }
	}

	if( ! function_exists( 'front_single_job_listing_summary' ) ) {
	    function front_single_job_listing_summary() {
	        ?>
	        <div class="card border-0 shadow-sm mb-3">
	            <header id="SVGwave1BottomShapeID1" class="card-header border-bottom-0 bg-primary text-white p-0 pb-2 mb-4">
	                <div class="pt-5 px-5">
	                    <h3 class="h5"><?php esc_html_e( 'Job Summary', 'front' ) ?></h3>
	                </div>
	               <!--  TAS <figure class="ie-wave-1-bottom mt-n5">
	                    <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-1-bottom.svg' ?>" alt="wave-1-bottom" data-parent="#SVGwave1BottomShapeID1">
	                </figure> -->
	            </header>
	            <div class="card-body pt-1 px-5 pb-5">
	                <?php
	                if( ! empty( $website = front_get_the_job_listing_company_meta_data( '_company_website' ) ) ) :
	                    if( substr( $website, 0, 7 ) === "http://" ) {
	                        $website_trimed = str_replace( 'http://', '', $website);
	                    } elseif( substr( $website, 0, 8 ) === "https://" ) {
	                        $website_trimed = str_replace( 'https://', '', $website);
	                    } else {
	                        $website_trimed = $website;
	                    }

	                    ?>
	                    <div class="media mb-3">
	                        <div class="min-width-4 text-center text-primary mt-1 mr-3">
	                            <span class="fas fa-globe"></span>
	                        </div>
	                        <div class="media-body">
	                            <a class="font-weight-medium" href="<?php echo esc_url( $website ); ?>"><?php echo esc_html( $website_trimed ); ?></a>
	                            <small class="d-block text-secondary"><?php esc_html_e( 'Website', 'front' ); ?></small>
	                        </div>
	                    </div>
	                    <?php
	                endif;
	                front_single_job_listing_summary_icon_block_elements();
	                ?>
	            </div>
	        </div>
	        <?php
	    }
	}

if( ! function_exists( 'front_single_job_listing_summary_icon_block_elements' ) ) {
    function front_single_job_listing_summary_icon_block_elements() {
        $args = apply_filters( 'front_single_job_listing_summary_icon_block_elements_args', array(
            'job_location' => array(
                'text_1' => get_the_job_location(),
                'text_2' => esc_html__( 'Location', 'front' ),
                'icon' => 'fas fa-map-marked-alt',
            ),
            'job_type' => array(
                'text_1' => front_get_taxomony_data( 'job_listing_type' ),
                'text_2' => esc_html__( 'Job Type', 'front' ),
                'icon' => 'fas fa-clock',
            ),
            'project_length' => array(
                'text_1' => front_get_taxomony_data( 'job_listing_project_length' ),
                'text_2' => esc_html__( 'Project length', 'front' ),
                'icon' => 'fas fa-business-time',
            ),
            'job_salary' => array(
                'text_1' => esc_html__( 'Salary', 'front' ),
                'text_2' => front_get_taxomony_data( 'job_listing_salary' ),
                'icon' => 'fas fa-money-bill-alt',
            ),
            'entry_level' => array(
                'text_1' => esc_html__( 'Entry level', 'front' ),
                'text_2' => front_get_the_meta_data( '_job_qualification' ),
                'icon' => 'fas fa-briefcase',
            ),
        ) );

        if( is_array( $args ) && count( $args ) > 0 ) {
            foreach( $args as $key => $arg) {
                if( isset( $arg['text_1'], $arg['text_2'], $arg['icon'] ) && !empty( $arg['text_1'] && $arg['text_2'] && $arg['icon'] ) ) :
                    ?>
                    <div class="media mb-3">
                        <div class="min-width-4 text-center text-primary mt-1 mr-3">
                            <span class="<?php echo esc_attr( $arg['icon'] ); ?>"></span>
                        </div>
                        <div class="media-body">
                            <span class="d-block font-weight-medium"><?php echo wp_kses_post( $arg['text_1'] ); ?></span>
                            <small class="d-block text-secondary"><?php echo wp_kses_post( $arg['text_2'] ); ?></small>
                        </div>
                    </div>
                    <?php
                endif;
              	if (empty( $arg['text_1']) && $arg['text_2'] == 'Location') :
              			?>
                    <div class="media mb-3">
                        <div class="min-width-4 text-center text-primary mt-1 mr-3">
                            <span class="<?php echo esc_attr( $arg['icon'] ); ?>"></span>
                        </div>
                        <div class="media-body">
                            <span class="d-block font-weight-medium"><?php echo 'Remote'; ?></span>
                            <small class="d-block text-secondary"><?php echo wp_kses_post( $arg['text_2'] ); ?></small>
                        </div>
                    </div>
                  	<?php
                endif;
            }
        }
    }
}

	// Shows the correct project logo
	add_action( 'single_job_listing_job_header', 'cosmos_single_job_listing_job_header_job_data', 10 );
	add_action( 'after_setup_theme', 'cosmos_remove_single_job_listing_job_header_job_data');
	function cosmos_remove_single_job_listing_job_header_job_data() {
	  remove_action( 'single_job_listing_job_header', 'front_single_job_listing_job_header_job_data', 10 );
	}

	if( ! function_exists( 'cosmos_single_job_listing_job_header_job_data' ) ) {
	    function cosmos_single_job_listing_job_header_job_data() {
	    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
	    		if (isset(get_post_meta(cosmos_get_post_id())['_company_name'][0])) {
	    			$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
	    		}
	    		if (isset(get_post_meta($company_id, '_company_logo')[0])) {
		    		$company_image = get_post_meta($company_id, '_company_logo')[0];
		    	}
						if (!empty($company_image)) {
							$image = $company_image;
						}else{
							$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
						}
	        ?>
	        <div class="media align-items-center mb-5">
	            <div class="u-lg-avatar mr-4 position-relative">
	            		<img class="img-fluid rounded-circle" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
	                <?php front_the_job_status(); ?>
	            </div>
	            <div class="media-body">
	                <div class="row">
	                    <?php do_action( 'single_job_listing_job_header_job_data' ); ?>
	                </div>
	            </div>
	        </div>
	        <?php
	    }
	}

	// Shows the correct project logo on  the find jobs page
	add_action( 'job_listing_list', 'cosmos_job_listing_list_card_body_content', 10 );
	add_action( 'after_setup_theme', 'cosmos_remove_job_listing_list_card_body_content');
	function cosmos_remove_job_listing_list_card_body_content() {
		remove_action( 'job_listing_list', 'front_job_listing_list_card_body_content', 10 );
	}
	if( ! function_exists( 'cosmos_job_listing_list_card_body_content' ) ) {
	    function cosmos_job_listing_list_card_body_content() {
	    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
	    		$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
	    		$company_image = get_post_meta($company_id, '_company_logo')[0];
						if (!empty($company_image)) {
							$image = $company_image;
						}else{
							$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
						}
	        ?>
	        <div class="media d-block d-sm-flex">
	            <div class="u-avatar mb-3 mb-sm-0 mr-4 position-relative">
	                <img class="img-fluid" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
	                <?php front_the_job_status(); ?>
	            </div>
	            <div class="media-body">
	                <div class="media mb-2">
	                    <div class="media-body mb-2">
	                        <h1 class="h5 mb-1">
	                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                        </h1>
	                        <?php front_job_listing_body_content_meta( true ); ?>
	                    </div>
	                    <div class="d-flex ml-auto">
	                        <?php do_action( 'job_listing_list_card_body_content_additional', 'list' ) ?>
	                    </div>
	                </div>
	                <?php if( !empty( get_the_excerpt() ) ) : ?>
	                    <div class="mb-5"><?php the_excerpt(); ?></div>
	                <?php elseif( !empty( front_get_the_meta_data( '_job_about' ) ) ) : ?>
	                    <div class="mb-5"><?php echo '<p>' . front_get_the_meta_data( '_job_about' ) . '</p>'; ?></div>
	                <?php endif; ?>
	                <div class="d-md-flex align-items-md-center">
	                    <?php
	                        front_job_listing_list_card_body_content_bottom();
	                        if( !empty( front_get_taxomony_data( 'job_listing_type' ) ) ) :
	                            ?>
	                            <div class="ml-md-auto">
	                                <span class="btn btn-xs btn-soft-danger btn-pill"><?php echo front_get_taxomony_data( 'job_listing_type' ); ?></span>
	                            </div>
	                            <?php
	                        endif;
	                    ?>
	                </div>
	            </div>
	        </div>
	        <?php
	    }
	}

	// Shows the correct project logo on the single job page (other jobs)
	add_action( 'job_listing_grid', 'cosmos_job_listing_grid_card_body_content', 10 );
	add_action( 'after_setup_theme', 'cosmos_remove_job_listing_grid_card_body_content');
	function cosmos_remove_job_listing_grid_card_body_content() {
		remove_action( 'job_listing_grid', 'front_job_listing_grid_card_body_content', 10 );
	}
	if( ! function_exists( 'cosmos_job_listing_grid_card_body_content' ) ) {
	    function cosmos_job_listing_grid_card_body_content() {
	    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
	    		$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
	    		$company_image = get_post_meta($company_id, '_company_logo')[0];
						if (!empty($company_image)) {
							$image = $company_image;
						}else{
							$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
						}
	        ?>
	        <div class="text-center">
	            <div class="u-lg-avatar mx-auto mb-3 position-relative">
	                <img class="img-fluid" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
	                <?php front_the_job_status(); ?>
	            </div>
	            <div class="mb-4">
	                <h1 class="h5 mb-1">
	                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                </h1>
	                <?php front_job_listing_body_content_meta( false ); ?>
	            </div>
	            <?php
	                if( !empty( front_get_the_meta_data( '_job_about' ) ) ) :
	                    echo '<p>' . front_get_the_meta_data( '_job_about' ) . '</p>';
	                elseif( !empty( front_get_the_meta_data( '_job_about' ) ) ) :
	                    the_excerpt();
	                endif;
	            ?>
	        </div>
	        <?php
	    }
	}







