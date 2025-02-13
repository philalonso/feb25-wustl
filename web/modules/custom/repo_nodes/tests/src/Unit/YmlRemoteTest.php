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
   * Test that the help text returns as expected.
   *
   * @covers YmlRemote::validateHelpText
   * @test
   */
//  public function testValidateHelpText(): void {
//    self::assertEquals('https://anything.anything/anything/anything.yml (or http or yaml)', $this->ymlRemote->validateHelpText(), 'Help text does not match.');
//  }

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
   * @param string $test_string
   *   The string to test.
   * @param bool $expected
   *   The expected result.
   *
   * @dataProvider validateProvider
   * @covers YmlRemote::validate
   * @test
   */
  public function testValidate(string $test_string, bool $expected): void {
    self::assertEquals($expected, $this->ymlRemote->validate($test_string),
    "Validation of '$test_string' does not return '$expected'.");
  }

  /**
   * Test that a repo can be read properly.
   *
   * @covers ::getRepo
   * @test
   */
  public function testGetRepo(): void {
    $file_path = __DIR__ . '/../../assets/english-dept-repo.yml';
    $repo = $this->ymlRemote->getRepo($file_path);
    $machine_name = array_key_first($repo);
    self::assertEquals('english-dept-repo', $machine_name, "The expected machine name does not match what was provided: '$machine_name'.");
    $repo = reset($repo);
    self::assertEquals('The English Department Repository', $repo['label'], "The expected label does not match what was provided: '{$repo['label']}'.");
    self::assertEquals('This is the repository for the English Department.', $repo['description'], "The expected description does not match what was provided: '{$repo['description']}'.'");
    // self::assertEquals('yml_remote', $repo['source'], "The expected source does not match what was provided: '{$repo['source']}'.");
    self::assertEquals('6', $repo['num_open_issues'], "The expected number of open issues does not match what was provided: '{$repo['num_open_issues']}'.");
    self::assertEquals($file_path, $repo['url'], "The expected URL does not match what was provided: '{$repo['url']}'.");
  }



  /**
   * Tests something.
   */
  public function testSomething(): void {
    self::assertTrue(TRUE, 'This is TRUE!');
  }

}
