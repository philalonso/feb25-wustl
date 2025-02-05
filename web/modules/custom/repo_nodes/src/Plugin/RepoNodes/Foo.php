<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\Plugin\RepoNodes;

use Drupal\repo_nodes\RepoNodes\RepoNodesPluginBase;

/**
 * Plugin implementation of the repo_nodes.
 *
 * @RepoNodes(
 *   id = "foo",
 *   label = @Translation("Foo"),
 *   description = @Translation("Foo description.")
 * )
 */
final class Foo extends RepoNodesPluginBase {

}
