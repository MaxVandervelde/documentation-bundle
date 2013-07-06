<?php
/**
 * PackageRouter.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Router;

use Nerdery\DocumentationBundle\Collection\AbstractCollection;
use Nerdery\DocumentationBundle\Router\FileNotFoundException;
use Nerdery\DocumentationBundle\Router\MissingPackageException;
use Nerdery\DocumentationBundle\Locator\PackageLocatorInterface;

/**
 * PackageRouter
 *
 * Service that is used for resolving URI paths into the filesystem path for a
 * given documentation file
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class PackageRouter
{
    /**
     * @var PackageLocatorInterface The service used for converting package
     *     paths into system paths
     */
    private $packageLocator;

    /**
     * @var AbstractCollection The Collection of documentation packages available
     *     to the system
     */
    private $availablePackages;

    /**
     * Constructor
     *
     * @param PackageLocatorInterface $packageLocator The service used for
     *     converting package paths into system paths
     * @param AbstractCollection $availablePackages The Collection of
     *     documentation packages available to the system
     */
    public function __construct(
        PackageLocatorInterface $packageLocator,
        AbstractCollection $availablePackages
    ) {
        $this->packageLocator = $packageLocator;
        $this->availablePackages = $availablePackages;
    }

    /**
     * Get Document
     *
     * Gets the documentation file location in the filesystem for a URI path
     *
     * @param $route The URI path requested
     * @return string The documentation file path
     * @throws MissingPackageException When the package specified by the URI
     *     does not exist or is not configured/loaded in the system properly
     * @throws FileNotFoundException When the individual file could not be
     *     located exactly.
     */
    public function getDocument($route)
    {
        $pathArray = explode('/', $route);
        $packageName = array_shift($pathArray);
        $relativePath = implode('/', $pathArray);

        if (false === $this->availablePackages->offsetExists($packageName)) {
            throw new MissingPackageException($packageName);
        }

        $package = $this->availablePackages->offsetGet($packageName);
        $basePath = $this->packageLocator->getBasePath($package);
        $fullPath = rtrim($basePath . '/' . $relativePath, '/');

        if ($basePath === $fullPath) {
            $indexPath = $this->packageLocator->getIndexFilePath($package);
            $recoverPathName = $packageName . '/' . basename($indexPath);

            throw new FileNotFoundException($fullPath, $recoverPathName);
        }

        if (is_dir($fullPath)) {
            throw new FileNotFoundException($fullPath);
        }

        if (false === file_exists($fullPath)) {
            throw new FileNotFoundException($fullPath);
        }

        return $fullPath;
    }
}
