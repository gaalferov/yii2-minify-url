<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Add new url');
$I->amOnPage('/');
$I->fillField('NixShortUrls[long_url]', 'http://codeception.com');
$I->click('Shorten URL');
$I->see('http://codeception.com');