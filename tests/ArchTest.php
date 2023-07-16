<?php
/*
 * Copyright (c) 2023.  LF Backend Developer Assessment by Josie Noli Darang.
 */

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
