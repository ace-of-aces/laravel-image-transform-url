<?php

arch('it will not use debugging functions')
    ->expect(['dd', 'dump'])
    ->each->not->toBeUsed();
