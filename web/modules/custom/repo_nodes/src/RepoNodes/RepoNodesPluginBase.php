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

  /**
   * {@inheritDoc}
   */
  public function validate(string $uri): bool {
    return FALSE;
  }

  /**
   * Build an array of a single repository's metadata.
   *
   * @param string $machine_name
   *   The machine name.
   * @param string $label
   *   The friendly name of the repository.
   * @param string|null $description
   *   The repository description.
   * @param int $num_open_issues
   *   The number of open issues for the repository.
   * @param string $url
   *   The url for the repository as entered by the Drupal user.
   *
   * @return array<string, array<string, string|int>>
   *   The repository metadata in a common format.
   */
  protected function mapToCommonFormat(string $machine_name, string $label, string|null $description, int $num_open_issues, string $url): array {
    $repo_info[$machine_name] = [
      'label' => $label,
      'description' => $description,
      'num_open_issues' => $num_open_issues,
      'source' => $this->getPluginId(),
      'url' => $url,
    ];
    return $repo_info;
  }

}
