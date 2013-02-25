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

namespace Gc\Layout;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:10.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Model
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
        $this->object = new Model;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::init
     *
     * @return void
     */
    public function testInit()
    {
        $this->object->init(1);
        $this->assertEquals(1, $this->object->getId());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::fromArray
     *
     * @return void
     */
    public function testFromArray()
    {
        $array = array(
            'id' => 1,
            'name' => 'String',
            'identifier' => 'string',
            'description' => 'Description',
            'content' => 'Content',
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $model = $this->object->fromArray($array);
        $this->assertEquals(1, $model->getId());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::fromId
     *
     * @return void
     */
    public function testFromId()
    {
        $array = array(
            'name' => 'String',
            'identifier' => 'string',
            'description' => 'Description',
            'content' => 'Content',
        );
        $model = $this->object->fromArray($array);
        $model->save();
        $id = $model->getId();

        $model = $this->object->fromId($id);
        $this->assertEquals('string', $model->getIdentifier());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::fromId
     *
     * @return void
     */
    public function testFromFakeId()
    {
        $model = $this->object->fromId(10000);
        $this->assertFalse($model);
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::fromIdentifier
     *
     * @return void
     */
    public function testFromIdentifier()
    {
        $array = array(
            'name' => 'Test Identifier',
            'identifier' => 'test-identifier',
            'description' => 'Description',
            'content' => 'Content',
        );
        $model = $this->object->fromArray($array);
        $model->save();

        $model = $this->object->fromIdentifier('test-identifier');
        $this->assertEquals('Test Identifier', $model->getName());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::fromIdentifier
     *
     * @return void
     */
    public function testFromFakeIdentifier()
    {
        $model = $this->object->fromIdentifier('fake-identifier');
        $this->assertFalse($model);
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::save
     *
     * @return void
     */
    public function testSave()
    {
        $array = array(
            'name' => 'Test Identifier',
            'identifier' => 'test-save-identifier',
            'description' => 'Description',
            'content' => 'Content',
        );

        $model = $this->object->fromArray($array);
        $model->save();
        //Save again for code coverage
        $model->save();
        $this->assertTrue((bool) $model->getId());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::save
     *
     * @return void
     */
    public function testSaveWithWrongValues()
    {
        $this->setExpectedException('Gc\Exception');
        $model = $this->object->fromArray(
            array(
                'name' => null,
                'identifier' => null,
                'description' => null,
                'content' => null,
            )
        );
        $this->assertFalse($model->save());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::delete
     *
     * @return void
     */
    public function testDelete()
    {
        $array = array(
            'name' => 'Test Identifier',
            'identifier' => 'test-delete-identifier',
            'description' => 'Description',
            'content' => 'Content',
        );
        $model = $this->object->fromArray($array);
        $model->save();

        $this->assertTrue($model->delete());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::delete
     *
     * @return void
     */
    public function testDeleteWithoutId()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * Test
     *
     * @covers Gc\Layout\Model::delete
     *
     * @return void
     */
    public function testDeleteWithWrongId()
    {
        $this->setExpectedException('Gc\Exception');
        $model = new Model();
        $model->setId('undefined');
        $this->assertFalse($model->delete());
    }
}
