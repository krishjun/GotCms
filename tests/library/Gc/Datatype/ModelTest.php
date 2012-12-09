<?php
namespace Gc\Datatype;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:10.
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Model
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = Model::fromArray(array(
            'name' => 'ModelTest',
            'prevalue_value' => '',
            'description' => 'ModelTest',
            'model' => 'ModelTest',
        ));
        $this->_object->save();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->_object->delete();
        unset($this->_object);
    }

    /**
     * @covers Gc\Datatype\Model::setPrevalueValue
     */
    public function testSetPrevalueValue()
    {
        $this->_object->setPrevalueValue('s:11:"string test";');
        $this->assertEquals('string test', $this->_object->getPrevalueValue());
        $this->_object->setPrevalueValue(array('array test'));
        $this->assertEquals(array('array test'), $this->_object->getPrevalueValue());
    }

    /**
     * @covers Gc\Datatype\Model::fromArray
     */
    public function testFromArray()
    {
        $this->assertInstanceOf('Gc\Datatype\Model', $this->_object->fromArray(array(
            'name' => 'ModelTest',
            'prevalue_value' => '',
            'description' => 'ModelTest',
            'model' => 'ModelTest',
        )));
    }

    /**
     * @covers Gc\Datatype\Model::fromId
     */
    public function testFromId()
    {

        $this->assertInstanceOf('Gc\Datatype\Model', Model::fromId($this->_object->getId()));
        $this->assertFalse(Model::fromId('undefined id'));
    }

    /**
     * @covers Gc\Datatype\Model::save
     */
    public function testSave()
    {
        $model = $this->_object->fromArray(array(
            'name' => 'ModelTest',
            'prevalue_value' => '',
            'description' => 'ModelTest',
            'model' => 'ModelTest',
        ));
        $this->assertTrue(is_numeric($model->save()));
        //Test update
        $this->assertTrue(is_numeric($model->save()));
        $model->delete();
    }

    /**
     * @covers Gc\Datatype\Model::save
     */
    public function testSaveWithWrongValues()
    {
        $this->setExpectedException('Gc\Exception');
        $model = $this->_object->fromArray(array(
            'name' => 'ModelTest',
            'prevalue_value' => '',
            'description' => 'ModelTest',
        ));
        $this->assertFalse($model->save());
    }

    /**
     * @covers Gc\Datatype\Model::delete
     */
    public function testDelete()
    {
        $this->assertTrue($this->_object->delete());
    }

    /**
     * @covers Gc\Datatype\Model::delete
     */
    public function testDeleteWithoutId()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * @covers Gc\Datatype\Model::savePrevalueEditor
     */
    public function testSavePrevalueEditor()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers Gc\Datatype\Model::saveEditor
     */
    public function testSaveEditor()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers Gc\Datatype\Model::loadPrevalueEditor
     */
    public function testLoadPrevalueEditor()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers Gc\Datatype\Model::loadEditorx
     */
    public function testLoadEditor()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * @covers Gc\Datatype\Model::loadDatatypex
     */
    public function testLoadDatatype()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
