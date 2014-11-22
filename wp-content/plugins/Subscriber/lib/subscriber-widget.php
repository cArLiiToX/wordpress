<?php
function tickerWidget() {
    $tickObj = get_option('btc_ticker');
    $options = get_option('btc_ticker_options');
    $chosenArr = array();
    $url = plugins_url();
    
    if ($options) {
        $chosenArr = array();
        $coindesk = (isset($options['Coindesk']) && $options['Coindesk']=='on')?('coindesk'):FALSE;
        $coinbase = (isset($options['Coinbase']) && $options['Coinbase']=='on')?('coinbase'):FALSE;
        $bitstamp = (isset($options['Bitstamp']) && $options['Bitstamp']=='on')?('bitstamp'):FALSE;
        if($coindesk){
             array_push($chosenArr, $coindesk);
        }
        if($coinbase){
            array_push($chosenArr, $coinbase);
        }
       
        if($bitstamp){
            array_push($chosenArr, $bitstamp);
        }
        ?>
        <script src="http://www.mercado-bitcoin.com.ar/plugin/mercadobitcoin.js"></script>
        <div id="mercado-bitcoin" data-extra="<?php echo (isset($options['extra_options']) && ($options['extra_options'] == '1'))?'off':'on';?>" data-exchanges="<?php echo implode(',', $chosenArr);?>" data-textcolor="<?php echo isset($options['color'])?$options['color']:'text3';?>" data-background="<?php echo $options['background']?>" data-font="comic-sans-ms" data-size="<?php echo isset($options['large'])?$options['large']:'large';?>" data-defaultexchange="<?php echo isset($options['default_exchanges'])?$options['default_exchanges']:'coinbase';?>" ></div>
        <?php
    } else {
        echo "<div style='color:red;'>Oops! You have not configured your plugin to display any tickers. Please choose which ticker to display in the <b>Wordpress Admin -> Settings -> Bitcoin Ticker Settings Page<b></div><br>";
    }
}
?>
