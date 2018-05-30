<?php

/**
 * @file
 * Administration forms for the Scheduler module.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Helper function for the real hook_form_node_type_form_alter().
 *
 * @see openy_media_scheduler_form_node_type_form_alter()
 */
function _openy_media_scheduler_form_node_type_form_alter(array &$form, FormStateInterface $form_state) {
  module_load_include('inc', 'scheduler', 'scheduler.admin');
  if (function_exists('_scheduler_form_node_type_form_alter')) {
    _scheduler_form_node_type_form_alter($form, $form_state);
    if (($key = array_search('scheduler_form_node_type_form_builder', $form['#entity_builders'])) !== FALSE) {
      unset($form['#entity_builders'][$key]);
    }
    $form['#entity_builders'][] = 'openy_media_scheduler_form_node_type_form_builder';
  }
}

/**
 * Entity builder for the media type form with scheduler options.
 */
function openy_media_scheduler_form_node_type_form_builder($entity_type, $type, &$form, FormStateInterface $form_state) {
  $type->setThirdPartySetting('scheduler', 'expand_fieldset', $form_state->getValue('scheduler_expand_fieldset'));
  $type->setThirdPartySetting('scheduler', 'fields_display_mode', $form_state->getValue('scheduler_fields_display_mode'));
  $type->setThirdPartySetting('scheduler', 'publish_enable', $form_state->getValue('scheduler_publish_enable'));
  $type->setThirdPartySetting('scheduler', 'publish_past_date', $form_state->getValue('scheduler_publish_past_date'));
  $type->setThirdPartySetting('scheduler', 'publish_required', $form_state->getValue('scheduler_publish_required'));
  $type->setThirdPartySetting('scheduler', 'publish_revision', $form_state->getValue('scheduler_publish_revision'));
  $type->setThirdPartySetting('scheduler', 'publish_touch', $form_state->getValue('scheduler_publish_touch'));
  $type->setThirdPartySetting('scheduler', 'unpublish_enable', $form_state->getValue('scheduler_unpublish_enable'));
  $type->setThirdPartySetting('scheduler', 'unpublish_required', $form_state->getValue('scheduler_unpublish_required'));
  $type->setThirdPartySetting('scheduler', 'unpublish_revision', $form_state->getValue('scheduler_unpublish_revision'));
}
