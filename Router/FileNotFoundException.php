<?php
/**
 * FileNotFoundException.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Router;

use RuntimeException;

/**
 * FileNotFoundException
 *
 * Thrown when a given documentation file could not be located
 *
 * @author Maxwell Vandervelde <Maxwell.Vandervelde@nerdery.com>
 */
class FileNotFoundException extends RuntimeException
{
    /**
     * @var string The file path that was expected but not found
     */
    private $missingFile;

    /**
     * @var string A path that can be used as an alternative to the file in an
     *     attempt to recover
     */
    private $recoverFile;

    /**
     * Constructor
     *
     * @param string $missingFile The file path that was expected but not found
     * @param null $recoverFile A path that can be used as an alternative to the
     *     file in an attempt to recover
     */
    public function __construct(
        $missingFile,
        $recoverFile = null
    ) {
        parent::__construct('Failed to find file at: ' . $missingFile);

        $this->missingFile = $missingFile;
        $this->recoverFile = $recoverFile;
    }

    /**
     * Get Missing File
     *
     * @return string The file path that was expected but not found
     */
    public final function getMissingFile()
    {
        return $this->missingFile;
    }

    /**
     * Is Recoverable
     *
     * @return bool Whether or not the exception has a recovery path option
     */
    public final function isRecoverable()
    {
        return null !== $this->recoverFile;
    }

    /**
     * Get Recover File
     *
     * @return string A path that can be used as an alternative to the file in
     *     an attempt to recover
     */
    public final function getRecoverFile()
    {
        return $this->recoverFile;
    }
}
