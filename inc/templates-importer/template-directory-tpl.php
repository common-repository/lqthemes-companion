<?php

$preview_url = add_query_arg( 'lqthemes_templates', '', home_url() );

$html = '';
$menu = '';
$filter_items = array();
$templage_items = '';

if ( is_array( $templates_array ) ) {
	$html .= '<div class="lqthemes-template-dir wrap">';
	$html .= '<h1 class="wp-heading-inline">' . __( 'LQThemes Templates Directory', 'lqthemes-companion' ) . '</h1>';
	
	
	$templage_items .= '<div class="lqthemes-template-browser">';
	
	foreach ( $templates_array as $template => $properties ) {
		
		$tags = array();
		if( isset( $properties['tags'] ) && $properties['tags'] != '' ){
			
			$tags_array = explode(',', trim($properties['tags']) );
						
			if(is_array( $tags_array )){
			  foreach( $tags_array as $item ){
				  $item_id = strtolower(str_replace(' ','-',trim($item)));
				  $filter_items[$item_id] = $item;
				  $tags[] = $item_id ;
				  }
			}
		}
		
		
		$templage_items .= '<div class="lqthemes-template '.esc_attr( implode( ' ', $tags ) ).'">';
		$templage_items .= '<div class="more-details lqthemes-preview-template" data-demo-url="' . esc_url( $properties['demo_url'] ) . '" data-template-slug="' . esc_attr( $template ) . '" ><span>' . __( 'More Details', 'lqthemes-companion' ) . '</span></div>';
		$templage_items .= '<div class="lqthemes-template-screenshot">';
		$templage_items .= '<img src="' . esc_url( $properties['screenshot'] ) . '" alt="' . esc_html( $properties['title'] ) . '" >';
		$templage_items .= '</div>'; // .lqthemes-template-screenshot
		$templage_items .= '<h2 class="template-name template-header">' . esc_html( $properties['title'] ) . (isset($properties['pro'] )&&$properties['pro']=='1'? apply_filters('lqthemes_after_template_title','<span class="pro-template">Pro</span>'):'').'</h2>';
		$templage_items .= '<div class="lqthemes-template-actions">';

		if ( ! empty( $properties['demo_url'] ) ) {
			$templage_items .= '<a class="button lqthemes-preview-template" data-demo-url="' . esc_url( $properties['demo_url'] ) . '" data-template-slug="' . esc_attr( $template ) . '" >' . __( 'Preview', 'lqthemes-companion' ) . '</a>';
		}
		$templage_items .= '</div>'; // .lqthemes-template-actions
		$templage_items .= '</div>'; // .lqthemes-template
	}
	
	$templage_items .= '</div>'; // .lqthemes-template-browser
	
	$html .= '<div class="templates-nav-wrap"><ul class="templates-nav filters">';

	if(is_array( $filter_items ) && !empty($filter_items) ){
		$html .= '<li class="active" data-filter="*">' . __( 'All', 'lqthemes-companion' ) . '</li>';
		foreach( $filter_items as $key => $value ){
			$html .= '<li data-filter=".'.esc_attr($key).'">'.esc_attr(ucwords(str_replace('-',' ',$value))).'</li>';
			}
	}
	
	$html .= '</ul></div>';

	$html .= $templage_items;
	
	$html .= '</div>'; // .lqthemes-template-dir
	$html .= '<div class="wp-clearfix clearfix"></div>';
}// End if().



echo $html;
?>

<div class="lqthemes-template-preview theme-install-overlay wp-full-overlay expanded" style="display: none;">
	<div class="wp-full-overlay-sidebar">
		<div class="wp-full-overlay-header">
			<button class="close-full-overlay"><span class="screen-reader-text"><?php _e( 'Close', 'lqthemes-companion' );?></span></button>
			<div class="lqthemes-next-prev">
				<button class="previous-theme"><span class="screen-reader-text"><?php _e( 'Previous', 'lqthemes-companion' );?></span></button>
				<button class="next-theme"><span class="screen-reader-text"><?php _e( 'Next', 'lqthemes-companion' );?></span></button>
			</div>
            
			<span class="lqthemes-import-template button button-primary"><?php _e( 'Import', 'lqthemes-companion' );?></span>
       
           
            <a target="_blank" class="lqthemes-buy-now" href="<?php echo esc_url('https://lqthemes.com/');?>"><span class="button orange"><?php _e( 'Buy Now', 'lqthemes-companion' );?></span></a>
            
		</div>
		<div class="wp-full-overlay-sidebar-content">
			<?php
			foreach ( $templates_array as $template => $properties ) {
			?>
				<div class="install-theme-info lqthemes-theme-info <?php echo esc_attr( $template ); ?>"
					 data-demo-url="<?php echo esc_url( $properties['demo_url'] ); ?>"
					 data-template-file="<?php echo esc_url( $properties['import_file'] ); ?>"
					 data-template-title="<?php echo esc_attr( $properties['title'] ); ?>" 
                     data-template-slug="<?php echo esc_attr( $template ); ?>" 
                     data-purchase-url="<?php echo isset($properties['purchase_url'])?esc_url( $properties['purchase_url'] ):''; ?>"
                     data-button-text="<?php echo isset($properties['button_text'])?esc_attr( $properties['button_text'] ):''; ?>"
                     >
					<h3 class="theme-name"><?php echo esc_attr( $properties['title'] ); ?></h3>
					<img class="theme-screenshot" src="<?php echo esc_url( $properties['screenshot'] ); ?>" alt="<?php echo esc_attr( $properties['title'] ); ?>">
					<div class="theme-details">
						<?php
						 	echo wp_kses_post( $properties['description'] );
						 ?>
					</div>
					<?php
					if ( ! empty( $properties['required_plugins'] ) && is_array( $properties['required_plugins'] ) ) {
					?>
					<div class="lqthemes-required-plugins">
						<p><?php _e( 'Required Plugins', 'lqthemes-companion' );?></p>
						<?php
						foreach ( $properties['required_plugins'] as $plugin_slug => $details ) {
							$file_name = isset($details['init'])?$details['init']:'';
							$plugin_name = isset($details['name'])?$details['name']:'';
							
							if ( LQThemesTemplater::check_plugin_state( $plugin_slug,$file_name, $plugin_name ) === 'install' ) {
								echo '<div class="lqthemes-installable plugin-card-' . esc_attr( $plugin_slug ) . '">';
								echo '<span class="dashicons dashicons-no-alt"></span>';
								echo $plugin_name;
								echo LQThemesTemplater::get_button_html( $plugin_slug,$file_name, $plugin_name  );
								echo '</div>';
							} elseif ( LQThemesTemplater::check_plugin_state( $plugin_slug,$file_name, $plugin_name  ) === 'activate' ) {
								echo '<div class="lqthemes-activate plugin-card-' . esc_attr( $plugin_slug ) . '">';
								echo '<span class="dashicons dashicons-admin-plugins" style="color: #ffb227;"></span>';
								echo $plugin_name;
								echo LQThemesTemplater::get_button_html( $plugin_slug,$file_name, $plugin_name  );
								echo '</div>';
							} else {
								echo '<div class="lqthemes-installed plugin-card-' . esc_attr( $plugin_slug ) . '">';
								echo '<span class="dashicons dashicons-yes" style="color: #34a85e"></span>';
								echo $plugin_name;
								echo '</div>';
							}
						}
						?>
					</div>
					<?php
					}
					?>
				</div><!-- /.install-theme-info -->
			<?php } ?>
		</div>

		<div class="wp-full-overlay-footer">
			<button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="Collapse Sidebar">
				<span class="collapse-sidebar-arrow"></span>
				<span class="collapse-sidebar-label"><?php _e( 'Collapse', 'lqthemes-companion' ); ?></span>
			</button>
			<div class="devices-wrapper">
				<div class="devices lqthemes-responsive-preview">
					<button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop">
						<span class="screen-reader-text"><?php _e( 'Enter desktop preview mode', 'lqthemes-companion' ); ?></span>
					</button>
					<button type="button" class="preview-tablet" aria-pressed="false" data-device="tablet">
						<span class="screen-reader-text"><?php _e( 'Enter tablet preview mode', 'lqthemes-companion' ); ?></span>
					</button>
					<button type="button" class="preview-mobile" aria-pressed="false" data-device="mobile">
						<span class="screen-reader-text"><?php _e( 'Enter mobile preview mode', 'lqthemes-companion' ); ?></span>
					</button>
				</div>
			</div>

		</div>
	</div>
	<div class="wp-full-overlay-main lqthemes-main-preview">
		<iframe src="" title="Preview" class="lqthemes-template-frame"></iframe>
	</div>
</div>
