<?php
/**
 * SymfonyPackageLocator.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Locator;

use Nerdery\DocumentationBundle\Entity\Package;

use Symfony\Component\HttpKernel\Kernel;

/**
 * Symfony Package Locator
 *
 * Locates packages using the Symfony kernel resource locator.
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class SymfonyPackageLocator implements PackageLocatorInterface
{
    /**
     * @var Kernel The HTTP Kernel Instance
     */
    private $kernel;

    /**
     * Construct a new Package Locator
     *
     * @param Kernel $kernel The HTTP Kernel instance
     */
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get Base Path
     *
     * Gets the base path of the package based on the index directory
     *
     * @param Package $package The package to get the base path of
     * @return string The base path of the package
     */
    public final function getBasePath(Package $package)
    {
        $indexPath = $this->getIndexFilePath($package);

        $basePath = dirname($indexPath);

        return $basePath;
    }

    /**
     * Get Index File Path
     *
     * @param Package $package The package to get the base path of
     * @return string
     */
    public final function getIndexFilePath(Package $package)
    {
        $index = $package->getIndex();

        if ('@' === $index[0] && false !== strpos($index, '/')) {
            $indexPath = $this->kernel->locateResource($index);
            return $indexPath;
        }

        return $index;
    }
}
