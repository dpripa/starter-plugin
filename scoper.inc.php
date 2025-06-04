<?php
use Isolated\Symfony\Component\Finder\Finder;

return array(
	'prefix'  => 'StarterPlugin',
	'finders' => array(
		Finder::create()
			->files()
			->ignoreVCS( true )
			->name( '*.php' )
			->notName( '/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/' )
			->in( 'vendor/omgpress/omgcore' )
			->append( array( 'vendor/omgpress/omgcore/composer.json' ) ),
		Finder::create()
			->append( array( 'composer.json' ) ),
	),
);
