<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Paste your long URL here');
$I->amOnPage('/');
$I->fillField('NixShortUrls[long_url]', 'http://codeception.com');
$I->click('Shorten URL');
$I->see('http://codeception.com');