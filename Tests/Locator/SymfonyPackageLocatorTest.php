<?php
/**
 * SymfonyPackageLocatorTest.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Test\Locator;

use Nerdery\DocumentationBundle\Entity\Package;
use Nerdery\DocumentationBundle\Locator\SymfonyPackageLocator;

/**
 * SymfonyPackageLocatorTest
 *
 * Tests for the Symfony specific package locator
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class SymfonyPackageLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Package Provider
     *
     * Provides data for testing package validity.
     *
     * @return array
     */
    public function packageProvider()
    {
        $bundlePackage = new Package(
            'Mock-Package-Bundle',
            '@MockBundle/mock-package/test.md'
        );
        $bundleExpectedBase = '/full/path/to/mock/bundle/mock-package';
        $bundleExpectedIndex = '/full/path/to/mock/bundle/mock-package/test.md';

        $explicitPackage = new Package(
            'Mock-Explicit-Package',
            '/some/explicit/path/test.md'
        );
        $explicitExpectedBase = '/some/explicit/path';
        $explicitExpectedIndex = '/some/explicit/path/test.md';

        $kernel = $this->getMockKernel();
        $locator = new SymfonyPackageLocator($kernel);

        return [
            [$locator, $bundlePackage, $bundleExpectedBase, $bundleExpectedIndex],
            [$locator, $explicitPackage, $explicitExpectedBase, $explicitExpectedIndex],
        ];
    }

    /**
     * Test Symfony Package Resolution
     *
     * Tests the package locator with support for bundle `@` notation syntax as
     * well as explicit syntax (should work for both)
     *
     * @dataProvider packageProvider
     * @param SymfonyPackageLocator $packageLocator Package Locator to test
     * @param Package $package Package data to use in test
     * @param string $expectedBase expected base output from locator
     * @param string $expectedIndex expected index output from locator
     */
    public function testSymfonyPackageResolution(
        SymfonyPackageLocator $packageLocator,
        Package $package,
        $expectedBase,
        $expectedIndex
    ) {
        $base = $packageLocator->getBasePath($package);
        $this->assertEquals($expectedBase, $base);

        $index = $packageLocator->getIndexFilePath($package);
        $this->assertEquals($expectedIndex, $index);
    }

    /**
     * Get Mock Kernel
     *
     * Provides a kernel instance that mocks the `locateResource` method
     * providing a full path to the resource
     *
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    protected final function getMockKernel()
    {
        $mockKernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $mockKernel->expects($this->any())
        ->method('locateResource')
        ->with('@MockBundle/mock-package/test.md')
        ->will(
            $this->returnValue('/full/path/to/mock/bundle/mock-package/test.md')
        );

        return $mockKernel;
    }
}
