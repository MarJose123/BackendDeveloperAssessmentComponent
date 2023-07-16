<?php

namespace MarJose123\BackendDeveloperAssessmentComponent\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MarJose123\BackendDeveloperAssessmentComponent\BackendDeveloperAssessmentComponent
 */
class BackendDeveloperAssessmentComponent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MarJose123\BackendDeveloperAssessmentComponent\BackendDeveloperAssessmentComponent::class;
    }
}
