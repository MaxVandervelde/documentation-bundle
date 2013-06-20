<?php
/**
 * LocatorInterface.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Locator;

use Nerdery\DocumentationBundle\Entity\Package;

/**
 * LocatorInterface
 *
 * A service that can be used for locating the qualified system paths to the
 * file asset needed to display as documentation for a given package
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
interface PackageLocatorInterface
{
    /**
     * Get Base Path
     *
     * Gets the base path of the package
     *
     * @param Package $package The package to get the base path of
     * @return string The base path of the package
     */
    public function getBasePath(Package $package);

    /**
     * Get Index File Path
     *
     * @param Package $package The package to get the base path of
     * @return string
     */
    public function getIndexFilePath(Package $package);
}
