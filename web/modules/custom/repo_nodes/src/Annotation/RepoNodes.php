<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines repo_nodes annotation object.
 *
 * @Annotation
 */
final class RepoNodes extends Plugin {

  /**
   * The plugin ID.
   */
  public readonly string $id;

  /**
   * The human-readable name of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $label;

  /**
   * The description of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $description;

  /**
   * The help text for repository URLs.
   *
   * @ingroup plugin_translatable.
   */
  public readonly string $url_help_text;

}
