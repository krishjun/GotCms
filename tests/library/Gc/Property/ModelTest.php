<?php
namespace Gc\Property;

use Gc\Datatype\Model as DatatypeModel,
    Gc\Document\Model as DocumentModel,
    Gc\DocumentType\Model as DocumentTypeModel,
    Gc\Layout\Model as LayoutModel,
    Gc\User\Model as UserModel,
    Gc\View\Model as ViewModel,
    Gc\Tab\Model as TabModel;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:11.
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
     * @var ViewModel
     */
    protected $_view;

    /**
     * @var LayoutModel
     */
    protected $_layout;

    /**
     * @var UserModel
     */
    protected $_user;

    /**
     * @var DocumentTypeModel
     */
    protected $_documentType;

    /**
     * @var TabModel
     */
    protected $_tab;

    /**
     * @var DatatypeModel
     */
    protected $_datatype;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_view = ViewModel::fromArray(array(
            'name' => 'View Name',
            'identifier' => 'View identifier',
            'description' => 'View Description',
            'content' => 'View Content'
        ));
        $this->_view->save();

        $this->_layout = LayoutModel::fromArray(array(
            'name' => 'Layout Name',
            'identifier' => 'Layout identifier',
            'description' => 'Layout Description',
            'content' => 'Layout Content'
        ));
        $this->_layout->save();

        $this->_user = UserModel::fromArray(array(
            'lastname' => 'User test',
            'firstname' => 'User test',
            'email' => 'test@test.com',
            'login' => 'test',
            'user_acl_role_id' => 1,
        ));
        $this->_user->setPassword('test');
        $this->_user->save();

        $this->_documentType = DocumentTypeModel::fromArray(array(
            'name' => 'Document Type Name',
            'description' => 'Document Type description',
            'icon_id' => 1,
            'default_view_id' => $this->_view->getId(),
            'user_id' => $this->_user->getId(),
        ));
        $this->_documentType->save();

        $this->_tab = TabModel::fromArray(array(
            'name' => 'TabTest',
            'description' => 'TabTest',
            'sort_order' => 1,
            'document_type_id' => $this->_documentType->getId(),
        ));
        $this->_tab->save();

        $this->_datatype = DatatypeModel::fromArray(array(
            'name' => 'BooleanTest',
            'prevalue_value' => '',
            'model' => 'Boolean',
        ));
        $this->_datatype->save();

        $this->_object = Model::fromArray(array(
            'name' => 'DatatypeTest',
            'identifier' => 'DatatypeTest',
            'description' => 'DatatypeTest',
            'required' => FALSE,
            'sort_order' => 1,
            'tab_id' => $this->_tab->getId(),
            'datatype_id' => $this->_datatype->getId(),
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
        $this->_datatype->delete();
        $this->_tab->delete();
        $this->_documentType->delete();
        $this->_user->delete();
        $this->_layout->delete();
        $this->_view->delete();
        unset($this->_datatype);
        unset($this->_tab);
        unset($this->_documentType);
        unset($this->_user);
        unset($this->_layout);
        unset($this->_view);
        unset($this->_object);
    }

    /**
     * @covers Gc\Property\Model::isRequired
     */
    public function testIsRequired()
    {
        $this->assertFalse($this->_object->isRequired());
        $this->assertInstanceOf('Gc\Property\Model', $this->_object->isRequired(TRUE));
        $this->assertTrue($this->_object->isRequired());
        $this->assertInstanceOf('Gc\Property\Model', $this->_object->isRequired(FALSE));
        $this->assertFalse($this->_object->isRequired());
    }

    /**
     * @covers Gc\Property\Model::setValue
     * @covers Gc\Property\Model::loadValue
     */
    public function testSetValue()
    {
        $this->assertInstanceOf('Gc\Property\Model', $this->_object->setValue('string'));
    }

    /**
     * @covers Gc\Property\Model::loadValue
     */
    public function testLoadValue()
    {
        $this->assertInstanceOf('Gc\Property\Model', $this->_object->loadValue());
    }

    /**
     * @covers Gc\Property\Model::getValue
     * @covers Gc\Property\Model::loadValue
     */
    public function testGetValue()
    {
        $this->assertEquals('', $this->_object->getValue());
        $this->_object->setValue('string');
        $this->assertEquals('string', $this->_object->getValue());
    }

    /**
     * @covers Gc\Property\Model::getValueModel
     */
    public function testGetValueModel()
    {
        $this->assertInstanceOf('Gc\Property\Value\Model', $this->_object->getValueModel());
    }

    /**
     * @covers Gc\Property\Model::saveValue
     */
    public function testSaveValue()
    {
        $document_model = DocumentModel::fromArray(array(
            'name' => 'DocumentTest',
            'url_key' => 'document-test',
            'status' => DocumentModel::STATUS_ENABLE,
            'sort_order' => 1,
            'show_in_nav' => TRUE,
            'user_id' => $this->_user->getId(),
            'document_type_id' => $this->_documentType->getId(),
            'view_id' => $this->_view->getId(),
            'layout_id' => $this->_layout->getId(),
            'parent_id' => 0,
        ));
        $document_model->save();
        $this->_object->setDocumentId($document_model->getId());
        $this->assertTrue($this->_object->saveValue());
        $this->_object->isRequired(TRUE);
        $this->assertFalse($this->_object->saveValue());
    }

    /**
     * @covers Gc\Property\Model::save
     */
    public function testSave()
    {
        $this->assertTrue(is_numeric($this->_object->save()));
    }

    /**
     * @covers Gc\Property\Model::save
     */
    public function testSaveWithWrongValues()
    {
        $this->setExpectedException('Gc\Exception');
        $this->_object->setIdentifier(NULL);
        $this->assertFalse($this->_object->save());
    }

    /**
     * @covers Gc\Property\Model::delete
     */
    public function testDelete()
    {
        $this->assertTrue($this->_object->delete());
    }

    /**
     * @covers Gc\Property\Model::delete
     */
    public function testDeleteWithNoId()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * @covers Gc\Property\Model::fromArray
     */
    public function testFromArray()
    {
        $model = Model::fromArray(array(
            'name' => 'DatatypeTest',
            'identifier' => 'DatatypeTest',
            'description' => 'DatatypeTest',
            'required' => FALSE,
            'sort_order' => 1,
            'tab_id' => $this->_tab->getId(),
            'datatype_id' => $this->_datatype->getId(),
        ));
        $this->assertInstanceOf('Gc\Property\Model', $model);
    }

    /**
     * @covers Gc\Property\Model::fromId
     */
    public function testFromId()
    {
        $this->assertInstanceOf('Gc\Property\Model', Model::fromId($this->_object->getId()));
    }

    /**
     * @covers Gc\Property\Model::fromId
     */
    public function testFromWithWrongId()
    {
        $this->assertFalse(Model::fromId('undefined'));
    }

    /**
     * @covers Gc\Property\Model::fromIdentifier
     */
    public function testFromIdentifierWithNoDocumentId()
    {
        $this->assertFalse(Model::fromIdentifier($this->_object->getIdentifier(), 0));
    }

    /**
     * @covers Gc\Property\Model::fromIdentifier
     */
    public function testFromIdentifier()
    {
        $document_model = DocumentModel::fromArray(array(
            'name' => 'DocumentTest',
            'url_key' => 'document-test',
            'status' => DocumentModel::STATUS_ENABLE,
            'sort_order' => 1,
            'show_in_nav' => TRUE,
            'user_id' => $this->_user->getId(),
            'document_type_id' => $this->_documentType->getId(),
            'view_id' => $this->_view->getId(),
            'layout_id' => $this->_layout->getId(),
            'parent_id' => 0,
        ));
        $document_model->save();
        $this->assertInstanceOf('Gc\Property\Model', Model::fromIdentifier($this->_object->getIdentifier(), $document_model->getId()));
    }
}