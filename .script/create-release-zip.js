const fs = require( 'fs' );
const archiver = require( 'archiver' );
const log = require( 'log-beautify' );
const release = require( './release.json' );

function setMainFileVersion() {
	if ( fs.existsSync( config.rootPath + config.mainFile ) ) {
		fs.readFile( config.rootPath + config.mainFile, 'utf8', function( err, data ) {
			if ( err ) {
				return console.error( err );
			}
			const result = data.replace( /\WP_Titan_\(\d+\_\d+)/, config.version );

			fs.writeFile( config.rootPath + config.mainFile, result, 'utf8', function( err ) {
				if ( err ) {
					return console.error( err );
				}
			});
		});
	}
}

function setPackageVersion( path ) {
	if ( path && fs.existsSync( path ) ) {
		const json = require( path );
		json.version = config.version;
		fs.writeFile( path, JSON.stringify( json, null, 2 ), 'utf8', function( err ) {
			if ( err ) {
				return console.error( err );
			}
		});
	}
}

function createArchive() {
	const output = fs.createWriteStream( config.rootPath + config.name + '.zip' );
	const archive = archiver( 'zip', {});

	output.on( 'close', function() {
		console.log( '\n' );
		log.success_( '"' + config.name + '.zip" released under version ' + config.version + ' to the root folder.' );
		console.log( '\n' )
	});

	archive.on( 'error', function( err ) {
		throw err;
	});

	archive.pipe( output );

	let directories = config.directories;
	for ( let i = 0; i < directories.length; i++ ) {
		archive.directory( config.rootPath + directories[i], config.name + '/' + directories[i], null );
	}

	let files = config.files;
	for ( let i = 0; i < files.length; i++ ) {
		archive.file( config.rootPath + files[i], { name: config.name + '/' + files[i] });
	}

	archive.finalize();
}

setMainFileVersion();
setPackageVersion( config.rootPath + config.packageJson );
setPackageVersion( config.rootPath + config.composerJson );
createArchive();
