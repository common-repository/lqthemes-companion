<?php

$preview_url = add_query_arg( 'lqthemes_sites', '', home_url() );

$html = '';
$menu = '';
$filter_items = array();
$templage_items = '';

if ( is_array( $sites_array ) ) {
	$html .= '<div class="lqthemes-template-dir wrap">';
	$html .= '<h1 class="wp-heading-inline">' . __( 'LQThemes Sites Directory', 'lqthemes-companion' ) . '</h1>';
	
	$templage_items .= '<div class="lqthemes-template-browser">';
	
	foreach ( $sites_array as $site => $properties ) {
		
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
		$templage_items .= '<div class="more-details lqthemes-preview-site" data-demo-url="' . esc_url( $properties['demo'] ) . '" data-site-slug="' . esc_attr( $site ) . '" data-template-slug="' . esc_attr( $site ) . '" ><span>' . __( 'More Details', 'lqthemes-companion' ) . '</span></div>';
		$templage_items .= '<div class="lqthemes-template-screenshot">';
		$templage_items .= '<img src="' . esc_url( $properties['screenshot'] ) . '" alt="' . esc_html( $properties['title'] ) . '" >';
		$templage_items .= '</div>'; // .lqthemes-template-screenshot
		$templage_items .= '<h2 class="template-name template-header">' . esc_html( $properties['title'] ) . (isset($properties['pro'] )&&$properties['pro']=='1'? apply_filters('lqthemes_after_template_title','<span class="pro-template">Pro</span>'):'').'</h2>';
		$templage_items .= '<div class="lqthemes-template-actions">';

		if ( ! empty( $properties['demo'] ) ) {
			$templage_items .= '<a class="button lqthemes-preview-template" data-demo-url="' . esc_url( $properties['demo'] ) . '" data-site-slug="' . esc_attr( $site ) . '" >' . __( 'Preview', 'lqthemes-companion' ) . '</a>';
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
            
			<span class="lqthemes-import-button lqthemes-import-site button button-primary"><?php _e( 'Import Site', 'lqthemes-companion' );?></span>
  
           
            <a target="_blank" class="lqthemes-buy-now" href="<?php echo esc_url('https://lqthemes.com/cactus-pro-theme/');?>"><span class="button orange"><?php _e( 'Buy Now', 'lqthemes-companion' );?></span></a>
            
		</div>
		<div class="wp-full-overlay-sidebar-content">
			<?php
			foreach ( $sites_array as $site => $properties ) {
			?>
				<div class="install-theme-info lqthemes-theme-info <?php echo esc_attr( $site ); ?>"
					 data-demo-url="<?php echo esc_url( $properties['demo'] ); ?>"
					 data-site-wxr="<?php echo esc_url( $properties['wxr'] ); ?>"
					 data-site-title="<?php echo esc_attr( $properties['title'] ); ?>" 
                     data-site-slug="<?php echo esc_attr( $site ); ?>" 
                     data-template-slug="<?php echo esc_attr( $site ); ?>" 
                     data-site-options="<?php echo esc_html( $properties['options'] ); ?>" 
                     data-site-widgets="<?php echo esc_html( $properties['widgets'] ); ?>" 
                     data-site-customizer="<?php echo esc_html( $properties['customizer'] ); ?>" 
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
						foreach ( $properties['required_plugins'] as $details ) {
							$file_name = isset($details['init'])?$details['init']:'';
							
							if ( LQThemesTemplater::check_plugin_state( $details['slug'],$file_name ) === 'install' ) {
								echo '<div class="lqthemes-installable plugin-card-' . esc_attr( $details['slug'] ) . '">';
								echo '<span class="dashicons dashicons-no-alt"></span>';
								echo $details['name'];
								echo LQThemesTemplater::get_button_html( $details['slug'],$file_name );
								echo '</div>';
							} elseif ( LQThemesTemplater::check_plugin_state( $details['slug'],$file_name ) === 'activate' ) {
								echo '<div class="lqthemes-activate plugin-card-' . esc_attr( $details['slug'] ) . '">';
								echo '<span class="dashicons dashicons-admin-plugins" style="color: #ffb227;"></span>';
								echo $details['name'];
								echo LQThemesTemplater::get_button_html( $details['slug'],$file_name );
								echo '</div>';
							} else {
								echo '<div class="lqthemes-installed plugin-card-' . esc_attr( $details['slug'] ) . '">';
								echo '<span class="dashicons dashicons-yes" style="color: #34a85e"></span>';
								echo $details['name'];
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
