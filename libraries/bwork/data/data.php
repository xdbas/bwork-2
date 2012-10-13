<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Data
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * @interface
 * @package Bwork
 * @subpackage Bwork_Data
 * @version v 0.1
 */
namespace Bwork\Data;
interface Data
{

    /**
     * This is the main method and should always return an instance of self
     *
     * @return self
     */
    public function db();
    
}