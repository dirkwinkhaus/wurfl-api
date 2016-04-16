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
 * @author Steve Kamerman
 */
/**
 * User Agent Normalizer - removes locale information from user agent
 */
class WURFL_Request_UserAgentNormalizer_Generic_TransferEncoding implements WURFL_Request_UserAgentNormalizer_Interface
{
    public function normalize($userAgent)
    {
        return str_replace(',gzip(gfe)', '', $userAgent);
    }
}
