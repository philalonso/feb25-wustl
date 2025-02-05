<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\RepoNodes;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\repo_nodes\Annotation\RepoNodes;

/**
 * RepoNodes plugin manager.
 */
final class RepoNodesPluginManager extends DefaultPluginManager {

  /**
   * Constructs RepoNodesPluginManager object.
   *
   * @param \Traversable<mixed> $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler interface.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/RepoNodes',
      $namespaces,
      $module_handler,
      'RepoNodesInterface::class',
      'RepoNodes::class',
    );
    $this->alterInfo('repo_nodes_info');
    $this->setCacheBackend($cache_backend, 'repo_nodes_plugins');
  }

}
