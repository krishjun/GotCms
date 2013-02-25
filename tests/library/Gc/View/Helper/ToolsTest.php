<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\View\Helper;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:08.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class ToolsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tools
     *
     * @return void
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = new Tools;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
    }

    /**
     * Test
     *
     * @covers Gc\View\Helper\Tools::__invoke
     *
     * @return void
     */
    public function testUnserialize()
    {
        $this->assertEquals('string', $this->object->__invoke('unserialize', 's:6:"string";'));
    }

    /**
     * Test
     *
     * @covers Gc\View\Helper\Tools::__invoke
     *
     * @return void
     */
    public function testSerialize()
    {
        $this->assertEquals('s:6:"string";', $this->object->__invoke('serialize', 'string'));
    }

    /**
     * Test
     *
     * @covers Gc\View\Helper\Tools::__invoke
     *
     * @return void
     */
    public function testDebug()
    {
        $result   = $this->object->__invoke('debug', 'string');
        $result   = str_replace(array(PHP_EOL, "\n"), '_', $result);
        $expected = '<pre>string</pre>';
        $this->assertEquals($expected, $result);
    }

    /**
     * Test
     *
     * @covers Gc\View\Helper\Tools::__invoke
     *
     * @return void
     */
    public function testIsSerialized()
    {
        $this->assertTrue($this->object->__invoke('is_serialized', 's:6:"string";'));
    }

    /**
     * Test
     *
     * @covers Gc\View\Helper\Tools::__invoke
     *
     * @return void
     */
    public function testCamelCase()
    {
        $this->assertEquals('StringToCamelCase', $this->object->__invoke('camelCase', 'String to camel case'));
    }
}
