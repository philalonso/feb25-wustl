<?php

declare(strict_types=1);

namespace Drupal\Tests\repo_nodes\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\repo_nodes\Traits\RepositoryContentTypeTrait;
use Drupal\user\UserInterface;

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
  ];

  /**
   * The authenticated user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected UserInterface $authenticatedUser;

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

    $this->authenticatedUser = $this->drupalCreateUser(['access content']);

    // $this->createRepositoryContentType();

    //    FieldStorageConfig::create([
    //      'field_name' => 'field_repository_url',
    //      'type' => 'link',
    //      'entity_type' => 'user',
    //      'cardinality' => -1,
    //    ])->save();
    //    FieldConfig::create([
    //      'field_name' => 'field_repository_url',
    //      'entity_type' => 'user',
    //      'bundle' => 'user',
    //      'label' => 'Repository URL',
    //    ])->save();

    // Ensure that the new Repository URL field is visible in the existing
    // user entity form mode.
    /** @var \Drupal\Core\Entity\EntityDisplayRepository $entity_display_repository */
    $entity_display_repository = \Drupal::service('entity_display.repository');
    $entity_display_repository->getFormDisplay('user', 'user', 'default')
      ->setComponent('field_repository_url', ['type' => 'link_default'])
      ->save();
  }

  /**
   * Test that the settings page works as expected.
   *
   * This tests that an admin user can access the settings page, select a
   * plugin to enable, and submit the page successfully.
   *
   * @return void
   *   Returns nothing.
   *
   * @test
   */
  public function testSettingsPage(): void {
    // Get a handle on the browsing session.
    $session = $this->assertSession();

    // Navigate to the Repo Nodes Settings page and confirm it's reachable.
    $this->drupalGet('admin/config/services/repositories');

    // Confirm that the page loads without error.
    $session->statusCodeEquals(200);

    // Set the value of form elements to be submitted.
    $edit = ['edit-repo-plugins-yml-remote' => 'yml_remote'];

    // Submit the form.
    $this->submitForm($edit, 'Save configuration');
    $session->statusCodeEquals(200);

    // Ensure the confirmation message appears.
    $session->responseContains('The configuration options have been saved.');

    $session->checkboxChecked('edit-repo-plugins-yml-remote');
    $session->checkboxNotChecked('edit-repo-plugins-github');
  }

  /**
   * Test that the settings page cannot be reached without permission.
   *
   * @return void
   *   Returns nothing.
   *
   * @test
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function testUnprivilegedSettingsPage(): void {
    $session = $this->assertSession();
    $this->drupalLogin($this->authenticatedUser);
    $this->drupalGet('/admin/config/services/repositories');
    // Test to ensure that the page loads without error.
    // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    $session->statusCodeEquals(403);
  }



/**
 * Test that a yml repo can be added to a user profile.
 *
 * This tests that a yml-based repo can be added to a user's profile and that
 * a repository node is successfully created upon saving the profile.
 *
 * @test
 */
public function testAddYmlRepo(): void {
  $this->drupalLogin($this->authenticatedUser);

  // Get a handle on the browsing session.
  $session = $this->assertSession();

  // Navigate to the user profile edit page.
  $this->drupalGet('/user/' . $this->authenticatedUser->id() . '/edit');
  $session->statusCodeEquals(200);

  // Get the full path of the .yml file.
  /** @var \Drupal\Core\Extension\ModuleHandlerInterface $module_handler */
  $module_handler = \Drupal::service('module_handler');
  $module = $module_handler->getModule('repo_nodes');
  $module_full_path = \Drupal::request()->getUri() . $module->getPath();

  // Populate the edit array for the user profile form.
  $edit = ['field_repository_url[0][uri]' => $module_full_path . '/tests/assets/english-dept-repo.yml'];

  // Submit the form.
  $this->submitForm($edit, 'Save');
  $session->statusCodeEquals(200);
  //Ensure the confirmation message appears.
  $session->responseContains('The changes have been saved.');

  // We can't check for the following message unless we also have the future
  // Repo Notifications module created and enabled.
  // $session->responseContains('The repo named <em class="placeholder">The English Dept Repo</em> has been created.
  // Find the new repository node.
  $query = \Drupal::entityQuery('node');
  $query->condition('type', 'repository');
  $results = $query->accessCheck(FALSE)->execute();
  $session->assert(count($results) === 1, 'Either 0 or 1 repository nodes were found.');

  $entity_type_manager = \Drupal::entityTypeManager();
  $node_storage = $entity_type_manager->getStorage('node');
  /** @var \Drupal\node\NodeInterface $node */
  $node = $node_storage->load(reset($results));

  $session->assert($node->field_machine_name->value == 'english-dept-repo', 'Machine name does not match.');
  $session->assert($node->field_description->value == 'This is the repository for the English Department.', 'Description does not match.');
  $session->assert($node->field_number_of_issues->value == '6', 'Number of issues does not match.');
  $session->assert($node->title->value == 'The English Department Repository', 'Title does not match.');
  $session->assert($node->field_source->value == 'yml_remote', 'Source does not match.');
}
}
