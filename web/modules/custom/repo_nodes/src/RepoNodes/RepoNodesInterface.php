<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\RepoNodes;

/**
 * Interface for repo_nodes plugins.
 */
interface RepoNodesInterface {

  /**
   * Returns the translated plugin label.
   */
  public function label(): string;

}
