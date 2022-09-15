<?php

use ElaborateCode\JigsawLocalization\Helpers\Folder;

it('gets correct project root path', function () {
    $root_folder = new Folder;

    $this->assertEquals($root_folder->getProjectRoot(), realpath(__DIR__ . './../../'));
});

it('gets correct tests folder path', function () {
    $tests_folder = (string) new Folder('tests');

    $this->assertEquals($tests_folder, realpath(__DIR__ . './../'));

    $tests_folder = new Folder('/tests');

    $this->assertEquals((string) $tests_folder, realpath(__DIR__ . './../'));

    $tests_folder = new Folder('\tests');

    $this->assertEquals($tests_folder->getPath(), realpath(__DIR__ . './../'));
});
