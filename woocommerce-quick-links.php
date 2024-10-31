<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Quick Links
 * Plugin URI:        https://wpruby.com
 * Description:       Add all the important WooCommerce links in a dashboard widget.
 * Version:           1.0.1
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * Text Domain:       woocommerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


if(wql_is_woocommerce_active()){

	add_action('admin_bar_menu', 'wc_quicklinks_add_toolbar_items',100);

	function wc_quicklinks_add_toolbar_items($admin_bar){
		//In case the user has no capabilities
		if(!current_user_can('manage_options')) return;

		// Prepare payment gateways & shipping methods
		$gateways = new WC_Payment_Gateways();
		$available_gateways = $gateways->payment_gateways();
		$shipping_methods = WC()->shipping->load_shipping_methods();

		//The main menu element
		$admin_bar->add_menu( array(
			'id'    => 'wql_quick_links_menu',
			'title' => 'WooCommerce',
			'href'  => '#',
		));
		//Products
		$admin_bar->add_menu( array(
			'id'    => 'wql_products_menu',
			'title' => __('Products','woocommerce'),
			'href'  => admin_url('edit.php?post_type=product'),
			'parent'=> 'wql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_product_new_menu',
			'title' => __('Add Product','woocommerce'),
			'href'  => admin_url('post-new.php?post_type=product'),
			'parent'=> 'wql_products_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_product_categories_menu',
			'title' => __('Categories','woocommerce'),
			'href'  => admin_url('edit-tags.php?taxonomy=product_cat&post_type=product'),
			'parent'=> 'wql_products_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_product_tags_menu',
			'title' => __('Tags','woocommerce'),
			'href'  => admin_url('edit-tags.php?taxonomy=product_tag&post_type=product'),
			'parent'=> 'wql_products_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_product_shipping_classes_menu',
			'title' => __('Shipping Classes','woocommerce'),
			'href'  => admin_url('edit-tags.php?taxonomy=product_shipping_class&post_type=product'),
			'parent'=> 'wql_products_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_product_attributes_menu',
			'title' => __('Attributes','woocommerce'),
			'href'  => admin_url('edit.php?post_type=product&page=product_attributes'),
			'parent'=> 'wql_products_menu'
		));						
		//Orders
		$admin_bar->add_menu( array(
			'id'    => 'wql_orders_menu',
			'title' => __('Orders','woocommerce'),
			'href'  => admin_url('edit.php?post_type=shop_order'),
			'parent'=> 'wql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_new_order_menu',
			'title' => __('Add New Order','woocommerce'),
			'href'  => admin_url('post-new.php?post_type=shop_order'),
			'parent'=> 'wql_orders_menu'
		));
		//Coupons
		$admin_bar->add_menu( array(
			'id'    => 'wql_coupons_menu',
			'title' => __('Coupons','woocommerce'),
			'href'  => admin_url('edit.php?post_type=shop_coupon'),
			'parent'=> 'wql_quick_links_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_new_coupon_menu',
			'title' => __('Add New Coupon','woocommerce'),
			'href'  => admin_url('post-new.php?post_type=shop_coupon'),
			'parent'=> 'wql_coupons_menu'
		));
		// Reports
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_menu',
			'title' => __('Reports','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports'),
			'parent'=> 'wql_quick_links_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_orders_menu',
			'title' => __('Orders','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=orders'),
			'parent'=> 'wql_reports_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_orders_salesbydate_menu',
			'title' => __('Sales by date','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=orders&report=sales_by_date'),
			'parent'=> 'wql_reports_orders_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_orders_salesbyproduct_menu',
			'title' => __('Sales by product','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=orders&report=sales_by_product'),
			'parent'=> 'wql_reports_orders_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_orders_salesbycategory_menu',
			'title' => __('Sales by category','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=orders&report=sales_by_category'),
			'parent'=> 'wql_reports_orders_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_orders_coupon_usage_menu',
			'title' => __('Coupons by date','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=orders&report=coupon_usage'),
			'parent'=> 'wql_reports_orders_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_customers_menu',
			'title' => __('Customers','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=customers'),
			'parent'=> 'wql_reports_menu'
		));				
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_customers_vs_guests_menu',
			'title' => __('Customers vs. Guests','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=customers&report=customers'),
			'parent'=> 'wql_reports_customers_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_customer_list_menu',
			'title' => __('Customer List','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=customers&report=customer_list'),
			'parent'=> 'wql_reports_customers_menu'
		));			
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_stock_menu',
			'title' => __('Stock','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=stock'),
			'parent'=> 'wql_reports_menu'
		));		
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_low_in_stock_menu',
			'title' => __('Low in Stock','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=stock&report=low_in_stock'),
			'parent'=> 'wql_reports_stock_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_out_of_stock_menu',
			'title' => __('Out of Stock','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=stock&report=out_of_stock'),
			'parent'=> 'wql_reports_stock_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_reports_most_stocked_menu',
			'title' => __('Most Stocked','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-reports&tab=stock&report=most_stocked'),
			'parent'=> 'wql_reports_stock_menu'
		));		
				

		//Settings
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_menu',
			'title' => __('Settings','woocommerce'),
			'href'  => '#',
			'parent'=> 'wql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_general_menu',
			'title' => __('General','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=general'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_products_menu',
			'title' => __('Products','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=products&section'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_products_general_menu',
			'title' => __('General','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=products&section'),
			'parent'=> 'wql_settings_products_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_products_display_menu',
			'title' => __('Display','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=products&section=display'),
			'parent'=> 'wql_settings_products_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_products_inventory_menu',
			'title' => __('Inventory','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=products&section=inventory'),
			'parent'=> 'wql_settings_products_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_products_downloadable_menu',
			'title' => __('Downloadable Products','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=products&section=downloadable'),
			'parent'=> 'wql_settings_products_menu'
		));					
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_tax_menu',
			'title' => __('Tax','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=tax&section'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_tax_options_menu',
			'title' => __('Tax Options','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=tax&section'),
			'parent'=> 'wql_settings_tax_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_tax_standard_rates_menu',
			'title' => __('Standard Rates','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=tax&section=standard'),
			'parent'=> 'wql_settings_tax_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_checkout_menu',
			'title' => __('Checkout','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=checkout&section'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_checkout_process_menu',
			'title' => __('Checkout Process','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=checkout&section'),
			'parent'=> 'wql_settings_checkout_menu'
		));
		foreach($available_gateways as $key => $gateway):
			$admin_bar->add_menu( array(
				'id'    => 'wql_settings_checkout_'. strtolower(get_class($gateway)) .'_menu',
				'title' => $gateway->method_title,
				'href'  => admin_url('admin.php?page=wc-settings&tab=checkout&section=' . strtolower(get_class($gateway))),
				'parent'=> 'wql_settings_checkout_menu'
			));	
		endforeach;

		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_shipping_menu',
			'title' => __('Shipping','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=shipping&section'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_shipping_options_menu',
			'title' => __('Shipping Options','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=shipping&section'),
			'parent'=> 'wql_settings_shipping_menu'
		));
		foreach($shipping_methods as $key => $shipping_method):
			$admin_bar->add_menu( array(
				'id'    => 'wql_settings_shipping_'. strtolower(get_class($shipping_method)) .'_menu',
				'title' => $shipping_method->method_title,
				'href'  => admin_url('admin.php?page=wc-settings&tab=shipping&section=' . strtolower(get_class($shipping_method))),
				'parent'=> 'wql_settings_shipping_menu'
			));	
		endforeach;

		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_accounts_menu',
			'title' => __('Accounts','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=account'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_emails_menu',
			'title' => __('Emails','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=email'),
			'parent'=> 'wql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_settings_api_menu',
			'title' => __('API','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=api'),
			'parent'=> 'wql_settings_menu'
		));			
		$admin_bar->add_menu( array(
			'id'    => 'wql_api_general_menu',
			'title' => __('General Options','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=api&section'),
			'parent'=> 'wql_settings_api_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_api_key_apps_menu',
			'title' => __('Keys/Apps','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=api&section=keys'),
			'parent'=> 'wql_settings_api_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_api_webhooks_menu',
			'title' => __('Webhooks','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-settings&tab=api&section=webhooks'),
			'parent'=> 'wql_settings_api_menu'
		));			
		// System Status
		$admin_bar->add_menu( array(
			'id'    => 'wql_system_status_menu',
			'title' => __('System Status','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-status'),
			'parent'=> 'wql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_system_status_tools_menu',
			'title' => __('Tools','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-status&tab=tools'),
			'parent'=> 'wql_system_status_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'wql_system_status_logs_menu',
			'title' => __('Logs','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-status&tab=logs'),
			'parent'=> 'wql_system_status_menu'
		));			
		// Add-ons
		$admin_bar->add_menu( array(
			'id'    => 'wql_addons_menu',
			'title' => __('Add-ons','woocommerce'),
			'href'  => admin_url('admin.php?page=wc-addons'),
			'parent'=> 'wql_quick_links_menu'
		));		
	}
}

// Check if WooCommerce is active
function wql_is_woocommerce_active(){
	$active_plugins = (array) get_option( 'active_plugins', array() );
	if ( is_multisite() )
		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
}