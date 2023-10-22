const dotenv = require( 'dotenv' ).config();
const FtpDeploy = require( 'ftp-deploy' );
const path = require( 'path' );
const ftp = new FtpDeploy();
const release = require( '../release.json' );

ftp.deploy( {
		host: process.env.FTP_DEV_HOST,
		port: 21,
		user: process.env.FTP_DEV_NAME,
		password: process.env.FTP_DEV_PWD,
		localRoot: path.dirname(__dirname),
		remoteRoot: process.env.FTP_DEV_DIR,
		include: release.directories.map(
			( dir ) => dir + '/*'
		).concat(release.files),
		exclude: [ 'node_modules/**', 'src/**' ],
		deleteRemote: false,
		forcePasv: true,
		sftp: false,
	} )
	.then( ( res ) => console.log( 'Deployment to dev is complete:', res ) )
	.catch( ( err ) => console.log( err ) );
