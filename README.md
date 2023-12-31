# WordPress Development Environment
Welcome to the efficient environment for WordPress development.

### Requirements
- `PHP >=7.2.0`
- `NVM`

### CLI
You can find all available commands in the `Makefile`. Have a nice initialization!\
__NOTE:__ the `.env` file must be defined and contain the required parameters (use the `.env.example` file as reference).

### GitHub Actions
Before using workflows, you should define `secret` variables in the project repository settings ([docs](https://docs.github.com/en/actions/security-guides/using-secrets-in-github-actions)).
- For `deploy-to-prod`:
	- `PROD_FTP_HOST`;
	- `PROD_FTP_PATH`;
	- `PROD_FTP_NAME`;
	- `PROD_FTP_PWD`.
- For `deploy-to-stag`:
	- `STAG_FTP_HOST`;
	- `STAG_FTP_PATH`;
	- `STAG_FTP_NAME`;
	- `STAG_FTP_PWD`.

`create-release-zip` doesn't require additional variables and after execution will output a zip archive as [an artifact](https://docs.github.com/en/actions/using-workflows/storing-workflow-data-as-artifacts).

### release.json
This file contains a list of directories and files that should be included in the release, it's used when executing the `create-release-zip` and `deploy-to-dev` commands.
