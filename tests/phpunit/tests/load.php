<?php

namespace Kraftner\KraftnerWpTorroFormsDateSelect\Tests;

use awsmug\Torro_Forms\Tests\Unit_Test_Case;
use Kraftner\KraftnerWpTorroFormsDateSelect\Extension;

class Tests_Load extends Unit_Test_Case {

	public function test_extension_loaded() {
		$instance = torro()->extensions()->get( 'kraftner_wp_torro_forms_date_select' );

		$this->assertInstanceOf( Extension::class, $instance );
	}

	/**
	 * @expectedIncorrectUsage awsmug\Torro_Forms\Components\Extensions::register()
	 */
	public function test_kraftner_wp_torro_forms_date_select_load() {
		// This must error because the extension will already be registered.
		$result = kraftner_wp_torro_forms_date_select_load( torro() );

		$this->assertWPError( $result );
	}
}
