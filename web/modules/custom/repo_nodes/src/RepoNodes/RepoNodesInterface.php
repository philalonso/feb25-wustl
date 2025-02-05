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

  /**
   * URL validator.
   *
   * @param string $uri
   *  The URI to validate.
   *
   * @return bool
   *   Returns TRUE if the validation passes.
   */
  public function validate(string $uri) : bool;

  /**
   * Returns help text for the plugin's URL required pattern.
   *
   * @return string
   *   The help text string.
   */
  public function validateHelpText() : string;

  /**
   * Queries the repository source for info about a repository.
   *
   * @param string $uri
   *   The URI of the repo.
   *
   * @return array<string, array<string, string|int>>
   *   The metadata of each repository.
   */
  public function getRepo(string $uri) : array;

}
