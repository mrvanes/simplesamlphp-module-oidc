<?php

/*
 * This file is part of the simplesamlphp-module-oidc.
 *
 * Copyright (C) 2018 by the Spanish Research and Academic Network.
 *
 * This code was developed by Universidad de Córdoba (UCO https://www.uco.es)
 * for the RedIRIS SIR service (SIR: http://www.rediris.es/sir)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleSAML\Module\oidc\Form\Controls;

use Nette\Forms\Controls\CsrfProtection as BaseCsrfProtection;
use Nette\InvalidStateException;
use Nette\Utils\Random;
use SimpleSAML\Session;

class CsrfProtection extends BaseCsrfProtection
{
    public const PROTECTION = 'SimpleSAML\Module\oidc\Form\Controls\CsrfProtection::validateCsrf';

    protected $sspSession;

    public function __construct($errorMessage)
    {
        // Instead of calling CsrfProtection parent class constructor, go to it's parent (HiddenField), and call
        // its constructor. This is to avoid setting a Nette session in CsrfProtection parent, and use the SSP one.
        $hiddentFieldParent = get_parent_class(get_parent_class($this));

        if (! is_string($hiddentFieldParent)) {
            throw new InvalidStateException('CsrfProtection initialization error');
        }

        $hiddentFieldParent::__construct();

        $this->setOmitted()
            ->setRequired()
            ->addRule(self::PROTECTION, $errorMessage);

        $this->sspSession = Session::getSessionFromRequest();
    }

    public function getToken(): string
    {
        $token = $this->sspSession->getData('form_csrf', 'token');

        if (!$token) {
            $token = Random::generate();
            $this->sspSession->setData('form_csrf', 'token', $token);
        }

        return $token ^ $this->sspSession->getSessionId();
    }
}
