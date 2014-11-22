<?php
function bitcoin_settings_html() {
    ?>
    <h2>MercadoBitcoin Settings Page</h2>
    <h3>If you like this plugin please donate BTC: 1Bk7K4YcD7Lmv4ZZiTmXcTMEqDdAdU7z4F</h3>
    <?php
    $tickObj = get_option('btc_ticker');
    ?>
    <div>
        <form action="options.php" method="post">
            <?php settings_fields('btc_ticker_options'); ?>
    <?php do_settings_sections('mercadobitcoin_ticker_settings_page'); ?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </p>
        </form>

    </div>
    <?php
}
?>