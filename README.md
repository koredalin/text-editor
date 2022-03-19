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

1. Clone the the repo.
2. Next - execute command `composer install` in main folder.
3. Make a database with the [SQL dump file]


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

I think that there is no need of mocked objects for this task yet. If it goes more complicated - there could have one.

**NOTES:**
- Make tests on Development server only.
- Used php final classes only. No interfaces used in this app yet. Generally - there is no need from interfaces for entities and app services. This is my general point of view.