const fs = require( 'fs' );
const path = require('path');
const archiver = require( 'archiver' );
const log = require( 'log-beautify' );
const release = require( '../release.json' );
const name = path.basename(path.dirname(__dirname));
const output = fs.createWriteStream( './release/' + name + '.zip' );
const archive = archiver( 'zip', {});

output.on( 'close', function() {
	console.log( '\n' );
	log.success_( '"' + name + '.zip" saved to the "./release" folder.' );
	console.log( '\n' )
});

archive.on( 'error', function( err ) {
	throw err;
});

archive.pipe( output );

let directories = release.directories;
for ( let i = 0; i < directories.length; i++ ) {
	archive.directory( '../' + directories[i], name + '/' + directories[i], null );
}

let files = release.files;
for ( let i = 0; i < files.length; i++ ) {
	archive.file( '../' + files[i], { name: name + '/' + files[i] });
}

archive.finalize();
