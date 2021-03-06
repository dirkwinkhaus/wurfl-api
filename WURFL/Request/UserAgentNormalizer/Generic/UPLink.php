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
 * @category   WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license     GNU Affero General Public License
 * @author   Fantayeneh Asres Gizaw
 */
/**
 * User Agent Normalizer - removes UP.Link garbage from user agent
 */
class WURFL_Request_UserAgentNormalizer_Generic_UPLink implements WURFL_Request_UserAgentNormalizer_Interface
{
    /**
     * This method remove the "UP.Link" substring from user agent string.
     *
     * @param  string $userAgent
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        $index = strpos($userAgent, 'UP.Link');
        if ($index !== false) {
            return substr($userAgent, 0, $index);
        }

        return $userAgent;
    }
}
