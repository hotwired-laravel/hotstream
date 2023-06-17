<?php

use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Tests\Fixtures;

uses(Fixtures\WithTeamsFeature::class);

test('has team feature can be determined when team is enabled', function () {
    $this->assertTrue(Hotstream::hasTeamFeatures());
    $this->assertTrue(Hotstream::userHasTeamFeatures(new Fixtures\User));
    $this->assertFalse(Hotstream::userHasTeamFeatures(new Fixtures\Admin));
});
