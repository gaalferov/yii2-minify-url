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

  /**
   * @param AcceptanceTester $I
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
    $I->waitForElementVisible('.site-error', 5);
    $I->see('Bad Request', 'h1');
  }

  /**
   * @param AcceptanceTester $I
   */
  public function testCorrectUrl(AcceptanceTester $I)
  {
    $I->fillField('NixShortUrls[long_url]', 'http://codeception.com');
    $I->click('Shorten URL');
    $I->waitForElementVisible('.alert-success', 5);
    $I->see('Congratulation! You are created new short url.');
  }
}