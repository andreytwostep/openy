<?php
/**
 * @file
 * Contains \Drupal\ygs_popups\Plugin\Block\LocationPopupLink.
 */

namespace Drupal\ygs_popups\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ygs_alters\AnonymousStartSession;

/**
 * Block with popup link.
 *
 * @Block(
 *   id = "location_popup_link_block",
 *   admin_label = @Translation("YGS location popup link"),
 *   category = @Translation("Custom")
 * )
 */
class LocationPopupLink extends BlockBase {
  use AnonymousStartSession;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'filter' => 'all',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['filter'] = array(
      '#type' => 'select',
      '#title' => t('Locations filter'),
      '#options' => array(
        'all' => t('Show all locations'),
        'by_class' => t('Show locations by class'),
      ),
      '#default_value' => $config['filter'],
    );

    return $form;
  }

  /**
   * В субмите мы лишь сохраняем наши данные.
   *
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['filter'] = $form_state->getValue('filter');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $this->anonymousSessionStart();
    $nid = 0;
    if ($config['filter'] == 'by_class') {
      $node = \Drupal::routeMatch()->getParameter('node');
      if ($node && $node->getType() == 'class') {
        $nid = $node->id();
      }
    }

    $block = [
      '#lazy_builder' => array(
        // @see \Drupal\ygs_popups\PopupLinkGenerator
        'ygs_popups.popup_link_generator:generateLink',
        array($nid),
      ),
      '#create_placeholder' => TRUE,
    ];
    return $block;
  }

}
