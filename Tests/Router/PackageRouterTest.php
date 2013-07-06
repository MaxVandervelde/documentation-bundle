<?php
/**
 * PackageRouterTest.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Test\Router;

use Nerdery\DocumentationBundle\Entity\Package;
use Nerdery\DocumentationBundle\Router\PackageRouter;
use Nerdery\DocumentationBundle\Router\FileNotFoundException;
use Nerdery\DocumentationBundle\Locator\PackageLocatorInterface;
use Nerdery\DocumentationBundle\Collection\AbstractCollection;

/**
 * PackageRouterTest
 *
 * Unit Tests for the package router class
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
class PackageRouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Functional Package Router Provider
     *
     * Data provider class that sets up a router for testing, where the router
     * dependencies are mocked and expected to work properly.
     *
     * @return array test arguments
     */
    public function functionalPackageRouterProvider()
    {
        $router = new PackageRouter(
            $this->getMockLocator(),
            $this->getFoundPackageCollection()
        );

        return array(
            array($router),
        );
    }

    /**
     * Disfunctional Package Router Provider
     *
     * Data provider class that sets up a router for testing, where the router
     * dependencies will be asked to find a package that does not properly
     * exist.
     *
     * @return array test arguments
     */
    public function disfunctionalPackageRouterProvider()
    {
        $router = new PackageRouter(
            $this->getMockLocator(),
            $this->getNotFoundPackageCollection()
        );

        return array(
            array($router),
        );
    }

    /**
     * Test getDocument
     *
     * @param Router $router A router to test
     * @dataProvider functionalPackageRouterProvider
     */
    public function testGetDocument($router)
    {
        $indexPath = $router->getDocument('mock-package/index.md');
        $this->assertEquals(
            $this->getFixturePackageLocation() . '/index.md',
            $indexPath
        );

        $subPath = $router->getDocument('mock-package/sub-dir/test.md');
        $this->assertEquals(
            $this->getFixturePackageLocation() . '/sub-dir/test.md',
            $subPath
        );
    }

    /**
     * Test Missing File Failure
     *
     * @param Router $router A router to test
     * @dataProvider functionalPackageRouterProvider
     * @expectedException \Nerdery\DocumentationBundle\Router\FileNotFoundException
     */
    public function testMissingFileFailure($router)
    {
        $router->getDocument('mock-package/non-existant/file.md');
    }

    /**
     * Test Missing Package Failure
     *
     * @param Router $router A router to test
     * @dataProvider disfunctionalPackageRouterProvider
     * @expectedException \Nerdery\DocumentationBundle\Router\MissingPackageException
     */
    public function testMissingPackageFailure($router)
    {
        $router->getDocument('missing-package/index.md');
    }

    /**
     * Test Index Recovery
     *
     * @param Router $router A router to test
     * @dataProvider functionalPackageRouterProvider
     */
    public function testIndexRecovery($router)
    {
        try {
            $router->getDocument('mock-package/index.md');
        } catch(FileNotFoundException $fileNotFouneException) {
            $this->assertTrue($fileNotFouneException->isRecoverable());
            $this->assertEquals(
                $this->getFixturePackageLocation() . '/index.md',
                $fileNotFouneException->getRecoverFile()
            );
        }
    }

    /**
     * Get Mock Locator
     *
     * @return PackageLocatorInterface A package locator mock object
     */
    protected final function getMockLocator()
    {
        $mockLocator = $this->getMock('Nerdery\DocumentationBundle\Locator\PackageLocatorInterface');

        $mockLocator->expects($this->any())
            ->method('getBasePath')
            ->will(
                $this->returnValue(
                    $this->getFixturePackageLocation()
                )
            );

        $mockLocator->expects($this->any())
            ->method('getIndexPath')
            ->will(
                $this->returnValue(
                    $this->getFixturePackageLocation() . '/index.md'
                )
            );

        return $mockLocator;
    }

    /**
     * Get Found Package Collection
     *
     * A mock package collection that is used when the package is expected to be
     * found and working properly
     *
     * @return AbstractCollection A mock package location construct
     */
    protected final function getFoundPackageCollection()
    {
        $mockCollection = $this->getMock('Nerdery\DocumentationBundle\Collection\AbstractCollection');

        $mockCollection->expects($this->any())
            ->method('offsetExists')
            ->with('mock-package')
            ->will(
                $this->returnValue(true)
            );

        $mockCollection->expects($this->any())
        ->method('offsetGet')
        ->with('mock-package')
        ->will(
            $this->returnValue(
                new Package(
                    'Test Package',
                    $this->getFixturePackageLocation() . '/index.md'
                )
            )
        );

        return $mockCollection;
    }

    /**
     * Get Not Found Package Collection
     *
     * A mock package collection that mocks the state of a package that could
     * not be found
     *
     * @return AbstractCollection A mock package location construct
     */
    protected final function getNotFoundPackageCollection()
    {
        $mockCollection = $this->getMock('Nerdery\DocumentationBundle\Collection\AbstractCollection');

        $mockCollection->expects($this->any())
            ->method('offsetExists')
            ->with('missing-package')
            ->will(
                $this->returnValue(false)
            );

        $mockCollection->expects($this->any())
        ->method('offsetGet')
        ->will(
            $this->throwException(new \Exception('Should not reach this!'))
        );

        return $mockCollection;
    }

    /**
     * Get Fixture Package Location
     *
     * @return string The fully qualified path of the mock package fixture
     */
    private function getFixturePackageLocation()
    {
        return dirname(__FILE__) . '/../_fixture/mock-package';
    }
}
