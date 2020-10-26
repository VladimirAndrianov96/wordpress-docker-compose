<?php
/**
 * @package Currency Plug
 * @version 1.0.0
 */
/*
Plugin Name: Currency widget
Plugin URI: None
Description: Simple Currency widget which shows the exchange rates in relation to RUB.
Author: Sergey Silaev
Version: 1.0.0
*/

function get_exchange_rate() {
	$ex_rate = get_transient( 'ex_rate' );

	if (false === $ex_rate) {
		$obj = wp_remote_get( 'https://www.cbr-xml-daily.ru/daily_json.js' );
		$ex_rate = wp_remote_retrieve_body( $obj );
		set_transient( 'ex_rate', $ex_rate, 2 * HOUR_IN_SECONDS );
	}

	return json_decode( $ex_rate );
}

function wporg_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'wporg_dashboard_widget',
        esc_html__( 'Current exchange rates', 'wporg' ),
        'wporg_dashboard_widget_render'
    );
}

function wporg_dashboard_widget_render() {
	$json = get_exchange_rate();

	$usd = $json->{"Valute"}->{"USD"}->{"Value"};
	$eur = $json->{"Valute"}->{"EUR"}->{"Value"};
	$gbp = $json->{"Valute"}->{"GBP"}->{"Value"};
	$cad = $json->{"Valute"}->{"CAD"}->{"Value"};

	printf( '<p><span class="currency usd">$ (USD): <strong>%s / RUB</strong></span>,
				<span class="currency gbp">£ (GBP): <strong>%s / RUB</strong></span>
			</p>', $usd, $eur);

	printf( '<p><span class="currency eur">€ (EUR): <strong>%s / RUB</strong></span>,
				<span class="currency cad">$ (CAD): <strong>%s / RUB</strong></span>
			</p>', $gbp, $cad);
}

function currency_plug_css() {
	echo "
	<style type='text/css'>
	.currency {
		color:#444;
		margin:2px 0;
		font-size:15px;
		line-height:1.44;
	}
	.usd strong {
		color:green;
	}
	.eur strong {
		color:blue;
	}
	.gbp strong {
		color:purple;
	}
	.cad strong {
		color:red;
	}
	</style>
	";
}

add_action( 'admin_head', 'currency_plug_css' );

add_action( 'wp_dashboard_setup', 'wporg_add_dashboard_widgets' );
