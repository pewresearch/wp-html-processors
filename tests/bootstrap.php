<?php
/**
 * PHPUnit bootstrap: loads Composer autoloader and the WordPress test suite.
 *
 * @package pewresearch/wp-html-processors
 */

declare(strict_types=1);

$project_root = dirname( __DIR__ );

require_once $project_root . '/vendor/autoload.php';

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$tmpdir = getenv( 'TMPDIR' );
	if ( false === $tmpdir || '' === $tmpdir ) {
		$tmpdir = sys_get_temp_dir();
	}
	$_tests_dir = rtrim( $tmpdir, '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite -- CLI bootstrap, not WordPress runtime.
	fwrite(
		STDERR,
		"WordPress test library not found.\nRun: bash bin/install-wp-tests.sh wordpress_test root <password> 127.0.0.1 latest\n"
	);
	exit( 1 );
}

// Give access to tests_add_filter(), etc.
require_once $_tests_dir . '/includes/functions.php';

// Boot WordPress test environment (requires MySQL for a full install).
require $_tests_dir . '/includes/bootstrap.php';
