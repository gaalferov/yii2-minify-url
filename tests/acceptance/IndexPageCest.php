<?php
class IndexPageCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testUrlField(AcceptanceTester $I)
    {
        $I->see('Paste your original URL here');

    }
    public function testIncorrectUrl(AcceptanceTester $I)
    {
        $I->fillField('NixShortUrls[long_url]', 'http://notcorrecturlrrrrrrr.asd');
        $I->click('Shorten URL');
        $I->see('Something is wrong with your URL');
    }
    public function testCorrectUrl(AcceptanceTester $I)
    {
        $I->fillField('NixShortUrls[long_url]', 'http://codeception.com');
        $I->click('Shorten URL');
        $I->see('http://codeception.com');
    }
}