<?php


namespace app\commands;


use app\components\Logger;
use yii\console\Controller;
use yii\helpers\FileHelper;

class UnitTestController extends Controller
{

    public function actionBuildMdFile()
    {
        $result = [
            '#codeception',
            '',
            '```bash',
        ];

        $codeceptionRootDirs = [
            'tests/api',
            'tests/front'
        ];
        $codeceptionCmd = 'php vendor/bin/codecept run ';
        $phpunitCmd = 'php vendor/bin/phpunit --configuration=tests/phpunit/phpunit.xml ';

        foreach ($codeceptionRootDirs as $codeceptionRootDir) {
            $files = FileHelper::findFiles($codeceptionRootDir);
            foreach ($files as $file) {
                $result[] = $codeceptionCmd . $file . ' --debug';
            }
        }

        $result[] = '```';
        $result[] = '';
        $result[] = '#phpunit';
        $result[] = '';
        $result[] = '```bash';

        $files = FileHelper::findFiles('tests/phpunit/functional');

        foreach ($files as $file) {
            $result[] = $phpunitCmd . $file . ' --debug';
        }
        $result[] = '```';

        $filename = 'tests.md';

        file_put_contents($filename, implode("\n", $result) . "\n");
        Logger::success($filename . ' done');
    }

}