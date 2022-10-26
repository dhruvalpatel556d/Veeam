<?php
/**
 * HelloWorld Special page.
 *
 * @file
 */

namespace MediaWiki\Extension\Example;

class SpecialHelloWorld extends \SpecialPage {

	/**
	 * Initialize the special page.
	 */
	public function __construct() {
		// A special page should at least have a name.
		// We do this by calling the parent class (the SpecialPage class)
		// constructor method with the name as first and only parameter.
		parent::__construct( 'HelloWorld' );
	}

	/**
	 * Shows the page to the user.
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:HelloWorld/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'example-helloworld' ) );

		// Parses message from .i18n.php as wikitext and adds it to the
		// page output.
       // $out->addWikimsg( 'examples-hello_world', $this->getRandomName() );


        $out->addHTML( 'USD to CZK<span id="usd" ></span><br>');
        $out->addHTML( 'euro-to-czk<span id="euro" ></span><br>');
        $out->addHTML( 'gbp-to-czk<span id="gbp" ></span>');

	}

	/** @inheritDoc */
	protected function getGroupName() {
		return 'other';
	}
    public function getRandomName() {
        $ar = ['John', 'Mary', 'James', 'William'];
        return $ar[array_rand($ar)];
    }
    public function getcurrencyExchange($currency){
        $req_url = 'https://v6.exchangerate-api.com/v6/7788a2ed6d51727fcf762c36/latest/'.$currency;
        $response_json = file_get_contents($req_url);

// Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

                // Decoding
                $response = json_decode($response_json);

                // Check for success
                if('success' === $response->result) {

                    // YOUR APPLICATION CODE HERE, e.g.
                    $base_price = 1; // Your price in USD
                    return round(($base_price * $response->conversion_rates->CZK), 2);

                }

            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }

        }
    }
}
