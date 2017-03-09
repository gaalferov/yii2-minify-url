<?php

/**
 * Class IndexPageCest
 */
class IndexPageCest
{
  /**
   * @param AcceptanceTester $I
   * @before
   */
  public function _before(AcceptanceTester $I, \Codeception\Scenario $scenario)
  {
    $I->amOnPage('/');
    if ($scenario->current('browser') === 'phantomjs') {
      $I->maximizeWindow();
    }
  }

  protected function SetLang(AcceptanceTester $I)
  {
    $I->sendAjaxPostRequest('/lang', array('language' => 'en'));
  }

  /**
   * @param AcceptanceTester $I
   * @before  setAffiliateCookie
   */
  public function testUrlField(AcceptanceTester $I)
  {
    $I->see('Paste your original URL here');
  }

  /**
   * @param AcceptanceTester $I
   */
  public function testIncorrectUrl(AcceptanceTester $I)
  {
    $I->fillField('NixShortUrls[long_url]', 'http://notcorrecturlrrrrrrr.asd');
    $I->click('Shorten URL');
    $I->see('Something is wrong with your URL');
  }

  /**
   * @param AcceptanceTester $I
   */
  public function testCorrectUrl(AcceptanceTester $I)
  {
    $I->fillField('NixShortUrls[long_url]', 'http://codeception.com');
    $I->click('Shorten URL');
    $I->see('http://codeception.com');
  }
}