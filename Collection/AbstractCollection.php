<?php
/**
 * AbstractCollection.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\Collection;

use Countable;
use ArrayAccess;
use IteratorAggregate;

/**
 * AbstractCollection
 *
 * @author Maxwell Vandervelde <Max@MaxVandervelde.com>
 */
abstract class AbstractCollection
    implements Countable, ArrayAccess, IteratorAggregate
{
}
