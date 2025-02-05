<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\RepoNodes;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for repo_nodes plugins.
 */
abstract class RepoNodesPluginBase extends PluginBase implements RepoNodesInterface {

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
