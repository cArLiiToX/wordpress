<?php
/* ------------------------------ */
/* INSTALL/UNINSTALL */
/* ------------------------------ */

// Add settings on activate.

add_action('admin_init', 'plugin_install');

function plugin_install() {

    fn_update_ticker();
    add_option("btc_ticker", $value = $tickArr, '', $autoload = 'yes');
    register_setting('wp_ticker', 'wp_ticker_options');
    register_setting('btc_ticker_options', 'btc_ticker_options');
}

// Unregister settings on deactivate.

add_action('admin_init', 'plugin_unininstall');

function plugin_unininstall() {
    unregister_setting('wp_ticker_options', 'wp_ticker_options');
    unregister_setting('btc_ticker_options', 'btc_ticker_options');
}


add_action('admin_menu', 'create_bitcoin_ticker_admin');

function create_bitcoin_ticker_admin() {
    $mypage = add_options_page("MercadoBitcoin Ticker Options", "MercadoBitcoin", 10, "mercadobitcoin_ticker_settings_page", "bitcoin_settings_html");
}

add_action('admin_init', 'add_ticker_options');

function add_ticker_options() {
    // feed settings
    add_settings_section('ticker_section', 'Ticker Settings', 'sctn_ticker', 'mercadobitcoin_ticker_settings_page');
    add_settings_field('plugin_radio_color', 'Text Color', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "text"));
    add_settings_field('plugin_radio_background', 'Background', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "background"));
    add_settings_field('plugin_radio_default_exchange', 'Default Exchange', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "exchange_default"));
    add_settings_field('plugin_radio_exchanges', 'Exchanges', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "exchanges"));
    add_settings_field('plugin_radio_size', 'Size', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "size"));
    add_settings_field('plugin_radio_extra', 'Show bid/ask', 'set_radio', 'mercadobitcoin_ticker_settings_page', 'ticker_section', $args = array("name" => "extra_options"));
}

function sctn_ticker_template() {
    echo "<p>Choose the template you want for your widget.</p>";
}

function set_radio($args) {
    // var_dump($args);
    $options = get_option('btc_ticker_options');

    $items = array('on', 'off');
    $textColor = array("text1"=>'Marron', "text2"=>'Naranja', "text3"=>'Verde', "text4"=>'Rojo', "text5"=>'Azul', "default"=>'Default');
    $background = array("bg0"=>'Blanco', "bg1"=>'Azul Claro', "bg2"=>'Naranja', "bg3"=>'Verde', "bg4"=>'Rojo', "bg5"=>'Azul Oscuro', "default"=>'Default');
    $exchanges = array("coindesk"=>'Coindesk', "coinbase"=>'Coinbase', "bitstamp"=>'Bitstamp');
    $large = array("large"=>'Large', "medium"=>'Medium', "small"=>'Small', "xsmall"=>'XSMALL');

   
    foreach ($args as $thefield) {
        switch ($thefield) {
            case 'extra_options':
                 foreach ($items as $key=>$item) {
                    $checked = ($options['extra_options'] == $key) ? ' checked="checked" ' : '';
                    echo "<label>"
                    . "<input " . $checked . " value='$key' name='btc_ticker_options[extra_options]' type='radio' /> $item "
                    . "</label><br />";
                }
                break;
            case 'text':
                foreach ($textColor as $key=>$item) {
                    $checked = ($options['color'] == $key) ? ' checked="checked" ' : '';
                    echo "<label>"
                    . "<input " . $checked . " value='$key' name='btc_ticker_options[color]' type='radio' /> $item "
                    . "</label><br />";
                }
                break;
            case 'background':
                foreach ($background as $key=>$item) {
                    $checked = ($options['background'] == $key) ? ' checked="checked" ' : '';
                    echo "<label>"
                    . "<input " . $checked . " value='$key' name='btc_ticker_options[background]' type='radio' /> $item "
                    . "</label><br />";
                }
                break;
            case 'exchange_default':
                foreach ($exchanges as $key =>$item) {
                    $checked = ($options['default_exchanges'] == $key) ? ' checked="checked" ' : '';
                    echo "<label>"
                    . "<input " . $checked . " value='$key' name='btc_ticker_options[default_exchanges]' type='radio' /> $item "
                    . "</label><br />";
                }
                break;
            case 'exchanges':
                ?> 
    <style>
        .form-table th {
            width: 117px;
        }
    </style>
                <table>
                <?php
                foreach ($exchanges as $key => $item) {
                    $checked = ($options['exchanges'] == $item) ? ' checked="checked" ' : '';
                    echo "<tr><td style='text-align: right;'> $item </td>";
                    foreach ($items as $key => $value) {
                        echo '<td style="padding-left: 5px;padding-right: 5px;"><label>';
                        $checked = ($options[$item] == $value) ? ' checked="checked" ' : '';
                        echo "<input " . $checked . " value='$value' name='btc_ticker_options[$item]' type='radio' /> $value";
                        echo '</label></td>';
                    }
                    echo '</tr>';
                }
                ?>
                </table>

                <?php
                break;
            case 'size':
                foreach ($large as $key => $item) {
                    $checked = ($options['large'] == $key) ? ' checked="checked" ' : '';
                    echo "<label>"
                    . "<input " . $checked . " value='$key' name='btc_ticker_options[large]' type='radio' /> $item "
                    . "</label><br />";
                }
                break;
        }
    }
}



add_action('update_ticker', 'fn_update_ticker');

function fn_update_ticker() {
  
}

// Widgetise the plugin for sidebar.

function widget_tickerPlugin($args) {

    extract($args);
    echo $before_widget;
    echo $before_title;
    echo $after_title;
    tickerWidget();
    echo $after_widget;
}

function tickerWidget_init() {
    register_sidebar_widget(__('MercadoBitcoin Widget'), 'widget_tickerPlugin');
}

add_action("plugins_loaded", "tickerWidget_init");
?>
