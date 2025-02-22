<?php

declare(strict_types=1);

namespace Drupal\repo_nodes\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Repo Nodes settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'repo_nodes_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['repo_nodes.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    // Get the current config.
    $repos_config = $this->config('repo_nodes.settings')
    ->get('repo_plugins') ?? [];
    $form['repo_plugins'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Repository plugins'),
      '#options' => [
        'yml_remote' => $this->t('Yml remote'),
        'github' => $this->t('GitHub'),
      ],
      '#default_value' => $repos_config,
    ];
    $form['#config-target'] = 'repo_nodes.settings:repo_plugins';
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if ($form_state->getValue('example') === 'wrong') {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('The value is not correct.'),
    //     );
    //   }
    // @end code
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('repo_nodes.settings')
      ->set('repo_plugins', $form_state->getValue('repo_plugins'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
