<?php

use ElaborateCode\JigsawLocalization\Strategies\File;

it('gets correct project root path', function () {
    $root_folder = new File;

    $this->assertEquals($root_folder->getProjectRoot(), realpath(__DIR__.'./../../'));
});

it('gets correct tests folder path', function () {
    $tests_folder = (string) new File('tests');

    $this->assertEquals($tests_folder, realpath(__DIR__.'./../'));

    $tests_folder = new File('/tests');

    $this->assertEquals((string) $tests_folder, realpath(__DIR__.'./../'));

    $tests_folder = new File('\tests');

    $this->assertEquals($tests_folder->getPath(), realpath(__DIR__.'./../'));
});

it('throws an exception when relative path is invalid', function () {
    new File('i want some fruits');
})->throws(\Exception::class, "Invalid relative path. Can't get absolute path from 'i want some fruits'!");

it('scans directories', function () {
    $dir = new File();

    $this->assertContains(realpath(__DIR__.'./../../tests'), $dir->getDirectoryContent());
    $this->assertContains(realpath(__DIR__.'./../../vendor'), $dir->getDirectoryContent());
});

it('throws an exception for calling getDirectoryContent on a file', function () {
    $file = new File('composer.json');

    $file->getDirectoryContent();
})->throws(\Exception::class);
