<?php
/**
 * MissingPackageException.php
 *
 * @copyright (c) 2013 The Nerdery
 * @license MIT <http://opensource.org/licenses/MIT>
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
