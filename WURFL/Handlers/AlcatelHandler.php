<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 *
 * @category   WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license     GNU Affero General Public License
 */

/**
 * AlcatelUserAgentHandler
 *
 *
 * @category   WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license     GNU Affero General Public License
 */
class WURFL_Handlers_AlcatelHandler extends WURFL_Handlers_Handler
{
    protected $prefix = 'ALCATEL';

    public function canHandle($userAgent)
    {
        if (WURFL_Handlers_Utils::isDesktopBrowser($userAgent)) {
            return false;
        }

        return WURFL_Handlers_Utils::checkIfStartsWithCaseInsensitive($userAgent, 'alcatel');
    }

    public function applyConclusiveMatch($userAgent)
    {
        $tolerance = WURFL_Handlers_Utils::firstSlash($userAgent);

        return $this->getDeviceIDFromRIS($userAgent, $tolerance);
    }
}
