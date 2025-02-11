<?php

declare(strict_types=1);

namespace Drupal\Tests\repo_nodes\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\repo_nodes\RepoNodes\RepoNodesPluginManager;

/**
 * Test description.
 *
 * @group repo_nodes
 */
final class RepoNodesPluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['repo_nodes'];


  /**
   * The test Plugin manager.
   *
   * @var \Drupal\repo_nodes\RepoNodes\RepoNodesPluginManager
   */
  protected RepoNodesPluginManager $manager;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Mock necessary services here.
    $this->manager = $this->container->get('plugin.manager.repo_nodes');

  }

  /**
   * Test creating an instance of the .yml Remote plugin.
   *
   * @test
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function testYmlRemoteInstance(): void {
    /** @var \Drupal\repo_nodes\RepoNodes\RepoNodesPluginBase $yml_remote_instance */
    $yml_remote_instance = $this->manager->createInstance('yml_remote');
    $plugin_def = $yml_remote_instance->getPluginDefinition();
    $this->assertInstanceOf('Drupal\repo_nodes\Plugin\RepoNodes\YmlRemote', $yml_remote_instance, 'Plugin type does not match.');
    $this->assertInstanceOf('Drupal\repo_nodes\RepoNodes\RepoNodesPluginBase', $yml_remote_instance, 'Plugin parent class type does not match.');
    $this->assertArrayHasKey('label', $plugin_def, 'The "Label" array key does not exist.');
    $this->assertTrue($plugin_def['label'] == 'Remote .yml file', 'The "Label" array value does not match.');
  }

}
