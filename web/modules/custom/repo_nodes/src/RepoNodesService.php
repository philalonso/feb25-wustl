<?php

declare(strict_types=1);

namespace Drupal\repo_nodes;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Service description.
 */
final class RepoNodesService {
  /**
   * Constructs a RepoNodes object.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $pluginManagerRepoNodes
   *   The plugin manager interface.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory interface.
   */
  public function __construct(
    protected PluginManagerInterface $pluginManagerRepoNodes,
    protected ConfigFactoryInterface $configFactory
  ) {}

  /**
   * Get help text from enabled plugins.
   *
   * @return string
   *   Concatenated help strings.
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getValidatorHelpText(): string {
    $repository_plugins = [];
    // Get the enabled list of our plugins from the Drupal config system.
    // Use the Null Coalesce Operator in case no repos are enabled.
    $repository_plugin_ids = $this->configFactory->get('repo_nodes.settings')->get('repository_plugins') ?? [];
    foreach ($repository_plugin_ids as $repository_plugin_id) {
      if (!empty($repository_plugin_id)) {
        $repository_plugins[] = $this->pluginManagerRepoNodes->createInstance($repository_plugin_id);
      }
    }

    $help = [];

    /** @var \Drupal\repo_nodes\RepoNodes\RepoNodesInterface $repository_plugin */
    foreach ($repository_plugins as $repository_plugin) {
      $help[] = $repository_plugin->validateHelpText();
    }

    return implode(' ', $help);
  }

}
