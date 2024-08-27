<?php

/**
 * Copyright © Elgentos B.V.. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\HyvaCheckoutOnePageWithLoginStep\Model\Checkout\EntityFormModifier;

use Hyva\Checkout\Model\Form\EntityFormInterface;
use Hyva\Checkout\Model\Form\EntityFormModifierInterface;

class SafeAddressInAddressBookModifier implements EntityFormModifierInterface
{
    public function apply(EntityFormInterface $form): EntityFormInterface
    {
        $form->registerModificationListener(
            'saveAddressCheckboxModifier',
            'form:action:create',
            [$this, 'saveAddressCheckboxModifier']
        );

        return $form;
    }

    public function saveAddressCheckboxModifier(EntityFormInterface $form): void
    {
        $addressSaveCheckbox = $form->getField('save');
        $addressSaveCheckbox->setValue(true);
        // Dit komt niet door in de template voor een of andere reden
        $addressSaveCheckbox->hide();
    }
}
