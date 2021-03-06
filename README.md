# Stream text editor

## Console based application

The text editor is made by an interview task.

Tested with Winodws CMD.
Please, do not use the app with Windows Git Bash.

### Used technologies
* PHP7.4,
* PHPUnit unit and integration tests.

INSTALLATION and CONFIGURATION
------------

### Install via Composer

1. Install PHP7.4.
	* Publish php folder (or ignition file only) for global loading on your local PC.
2. Clone the the repo.
3. Next - execute command `composer install` in project's main folder.

DOCUMENTATION
-------------

- [Configuration parameters](https://github.com/koredalin/text-editor/blob/master/Docs/config-params.md)

- [Commands](https://github.com/koredalin/text-editor/blob/master/Docs/commands.md)

TESTING
-------

Steps to be reproduced to start the tests.

1. Open git bash.
2. Go to project's folder.
3. You can run the tests with `./vendor/bin/phpunit tests` command into the project folder.

Provided tests for:

- `App\Models\InputArguments` unit tests.
- `App\Models\InputFileManager` integration tests.
- `App\Services\TextEditorService` integration tests.

NOTES:
------

- Make tests on Development server only.
- Used php final classes only. No interfaces used in this app yet. Generally - there is no need from interfaces for entities and app services.
	[More Info](https://matthiasnoback.nl/2018/08/when-to-add-an-interface-to-a-class/#for-everything-else%3A-stick-to-a-%60final%60-class).
- I think that there is no need of mocked objects for this task yet. If it goes more complicated - there could have one.
- What could be done more:
	- Dependency injection files loading.
	- When the list of commands and configuration parameters grows up.. - We can make Open-Close (SOLID) principle refactoring of:
		- `App\Models\InputArguments::setConfigurationParameters(): void {}`,
		- `App\Models\InputArguments::setCommandParameters(array $commandParameters): void {}`.