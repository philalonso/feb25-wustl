<?php

declare(strict_types=1);

namespace Drupal\hello_wustl\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Hello, WUStL! routes.
 */
final class HelloWustlController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke($name): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Hello, @name!',['@name' => $name]),
    ];

    return $build;
  }

}
