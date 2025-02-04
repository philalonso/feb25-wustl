<?php

declare(strict_types=1);

namespace Drupal\Tests\repo_nodes\Functional;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\repo_nodes\Traits\RepositoryContentTypeTrait;

/**
 * Test description.
 *
 * @group repo_nodes
 */
final class AddYmlRepoTest extends BrowserTestBase {
  use RepositoryContentTypeTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'repo_nodes',
    'user',
    'node',
    'link',
    ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Set up the test here.
    $config = $this->config('repo_nodes.settings');
    $config->set('repo_plugins', ['yml_remote' => 'yml_remote']);
    $config->save();

    // Create and login as a Drupal user with permission to access the
    // Repo Nodes settings page. User ID is 2 because UID=1 is created by
    // web/core/lib/Drupal/Core/Test/FunctionalTestSetupTrait::initUserSession().
    // This root user can be access through $this->rootUser.
    $admin_user = $this->drupalCreateUser(['configure repo nodes']);
    $this->drupalLogin($admin_user);

    $this->createRepositoryContentType();

    FieldStorageConfig::create([
      'field_name' => 'field_repository_url',
      'type' => 'link',
      'entity_type' => 'user',
      'cardinality' => -1,
    ])->save();
    FieldConfig::create([
      'field_name' => 'field_repository_url',
      'entity_type' => 'user',
      'bundle' => 'user',
      'label' => 'Repository URL',
    ])->save();

    // Ensure that the new Repository URL field is visible in the existing
    // user entity form mode.
    /** @var \Drupal\Core\Entity\EntityDisplayRepository $entity_display_repository  */
    $entity_display_repository = \Drupal::service('entity_display.repository');
    $entity_display_repository->getFormDisplay('user', 'user', 'default')
      ->setComponent('field_repository_url', ['type' => 'link_default'])
      ->save();

  }

  /**
   * Test callback.
   */
  public function testSomething(): void {
    $admin_user = $this->drupalCreateUser(['administer site configuration']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('/admin/config/system/site-information');
    $this->assertSession()->elementExists('xpath', '//h1[text() = "Basic site settings"]');
  }

}
