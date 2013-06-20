<?php
/**
 * MissingPackageException.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Router;

use RuntimeException;

/**
 * MissingPackageException
 *
 * Exception thrown when a package ID is configured or attempted to resolve but
 * cannot be found
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class MissingPackageException extends RuntimeException
{
    public function __construct($packageName)
    {
        parent::__construct('Could not find package with key: ' . $packageName);
    }
}
