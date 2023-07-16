<?php
/*
 * Copyright (c) 2023.  LF Backend Developer Assessment by Josie Noli Darang.
 */

namespace MarJose123\BackendDeveloperAssessmentComponent;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BackendDeveloperAssessmentComponentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('backenddeveloperassessmentcomponent')
            ->hasRoute('api');
    }
}
