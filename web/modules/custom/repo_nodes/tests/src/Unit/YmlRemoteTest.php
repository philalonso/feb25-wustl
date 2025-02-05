<?php

declare(strict_types=1);

namespace Drupal\Tests\repo_nodes\Unit;

use Drupal\repo_nodes\Plugin\RepoNodes\YmlRemote;
use Drupal\Tests\UnitTestCase;

/**
 * Test description.
 *
 * @group repo_nodes
 */
final class YmlRemoteTest extends UnitTestCase {

  /**
   * The .yml Remote plugin.
   *
   * @var \Drupal\repo_nodes\Plugin\RepoNodes\YmlRemote
   */
  protected YmlRemote $ymlRemote;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->ymlRemote = new YmlRemote([], '', []);
  }

  /**
   * Test that the help text retuns as expected.
   *
   * @covers YmlRemote::validateHelpText
   * @test
   */
  public function testValidateHelpText(): void {
    self::assertEquals('https://anything.anything/anything/anything.yml (or http or yaml)', $this->ymlRemote->validateHelpText(), 'Help text does not match.');
  }

  /**
   * Data provider for testValidate().
   *
   * @return array<int, array<int, string|bool>>
   *   The values to test and their expected result.
   */
  public function validateProvider(): array {
    return [
      [
        'A test string',
        FALSE,
      ],
      [
        'http://www.mysite.com/anything.yml',
        TRUE,
      ],
      [
        'https://www.mysite.com/anything.yml',
        TRUE,
      ],
      [
        'https://www.mysite.com/anything.yaml',
        TRUE,
      ],
      [
        '/var/www/html/anything.yaml',
        FALSE,
      ],
      [
        'https://www.mysite.com/some%20directory/anything.yml',
        TRUE,
      ],
      [
        'https://www.my-site.com/some%20directory/anything.yaml',
        TRUE,
      ],
      [
        'https://localhost/some%20directory/anything.yaml',
        TRUE,
      ],
      [
        'https://dev.www.mysite.com/anything.yml',
        TRUE,
      ],
      [
        'http://3000.com/my-repository.yml',
        TRUE,
      ],
    ];
  }

  /**
   * Test that the URL validator works.
   *
   * @covers YmlRemote::validate
   * @test
   */



  /**
   * Tests something.
   */
  public function testSomething(): void {
    self::assertTrue(TRUE, 'This is TRUE!');
  }

}
