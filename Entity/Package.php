<?php
/**
 * Package.php
 *
 * @copyright (c) 2013 The Nerdery
 * @license MIT <http://opensource.org/licenses/MIT>
 */

namespace Nerdery\DocumentationBundle\Entity;

/**
 * Package
 *
 * Package is an entity containing the data for a single configured section in
 * which documentation may be found.
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class Package
{
    /**
     * @var string The package index location path
     */
    private $title;

    /**
     * @var string The package title / name
     */
    private $index;

    /**
     * Construct a new Package
     *
     * @param string $title The package title / name
     * @param string $index The package index location path
     */
    public function __construct($title = '', $index = '.')
    {
        $this->title = $title;
        $this->index = $index;
    }

    /**
     * @param string $index The package index location path
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return string The package index location path
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $title The package title / name
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string The package title / name
     */
    public function getTitle()
    {
        return $this->title;
    }
}
