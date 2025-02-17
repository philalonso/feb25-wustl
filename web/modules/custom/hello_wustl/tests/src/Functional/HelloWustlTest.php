<?php

declare(strict_types=1);

namespace Drupal\Tests\hello_wustl\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the availability of the Hello, WUStL! page.
 *
 * @group hello_wustl
 */
final class HelloWustlTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['hello_wustl'];

  /**
   * Create a test user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $testUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Tests that the page says hello to WUStL.
   */
  public function testHelloWustlPage(): void {
    // Create and login as an admin user.
    $this->testUser = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($this->testUser);

    $this->drupalGet('/hello-wustl');
    $this->assertSession()->statusCodeEquals(200);

    // Test that the page title is correct.
    $this->assertSession()->pageTextContains('Hello, WUStL!');

    // Test that the "name" argument works.
    $this->drupalGet('/hello-wustl/phil');
    $this->assertSession()->statusCodeEquals(200);

    // Test that the page title is correct.
    $this->assertSession()->pageTextContains('Hello, phil!');
  }

}
