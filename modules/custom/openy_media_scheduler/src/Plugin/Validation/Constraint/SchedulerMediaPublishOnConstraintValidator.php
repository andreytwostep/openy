<?php

namespace Drupal\openy_schedules\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the SchedulerMediaPublishOn constraint.
 */
class SchedulerMediaPublishOnConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($entity, Constraint $constraint) {
    $publish_on = $entity->value;
    $default_publish_past_date = \Drupal::config('scheduler.settings')->get('default_publish_past_date');
    $type = \Drupal::entityTypeManager()->getStorage('media_bundle')->load($entity->getEntity()->bundle());
    $scheduler_publish_past_date = $type->getThirdPartySetting('scheduler', 'publish_past_date', $default_publish_past_date);

    if ($publish_on && $scheduler_publish_past_date == 'error' && $publish_on < REQUEST_TIME) {
      $this->context->buildViolation($constraint->messagePublishOnDateNotInFuture)
        ->atPath('publish_ons')
        ->addViolation();
    }
  }

}
