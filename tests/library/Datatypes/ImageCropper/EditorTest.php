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
 * @package  Datatypes
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Datatypes\ImageCropper;

use Gc\Datatype\Model as DatatypeModel;
use Gc\Document\Model as DocumentModel;
use Gc\DocumentType\Model as DocumentTypeModel;
use Gc\Layout\Model as LayoutModel;
use Gc\Property\Model as PropertyModel;
use Gc\User\Model as UserModel;
use Gc\Tab\Model as TabModel;
use Gc\View\Model as ViewModel;
use Gc\Media\File;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:42:12.
 *
 * @group Datatypes
 * @category Gc_Tests
 * @package  Datatypes
 */
class EditorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Editor
     *
     * @return void
     */
    protected $object;

    /**
     * @var DatatypeModel
     *
     * @return void
     */
    protected $datatype;

    /**
     * @var PropertyModel
     *
     * @return void
     */
    protected $property;

    /**
     * @var ViewModel
     *
     * @return void
     */
    protected $view;

    /**
     * @var LayoutModel
     *
     * @return void
     */
    protected $layout;

    /**
     * @var TabModel
     *
     * @return void
     */
    protected $tab;

    /**
     * @var UserModel
     *
     * @return void
     */
    protected $user;

    /**
     * @var DocumentTypeModel
     *
     * @return void
     */
     protected $documentType;

    /**
     * @var DocumentModel
     *
     * @return void
     */
     protected $document;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->view = ViewModel::fromArray(
            array(
                'name' => 'View Name',
                'identifier' => 'View identifier',
                'description' => 'View Description',
                'content' => 'View Content'
            )
        );
        $this->view->save();

        $this->layout = LayoutModel::fromArray(
            array(
                'name' => 'Layout Name',
                'identifier' => 'Layout identifier',
                'description' => 'Layout Description',
                'content' => 'Layout Content'
            )
        );
        $this->layout->save();

        $this->user = UserModel::fromArray(
            array(
                'lastname' => 'User test',
                'firstname' => 'User test',
                'email' => 'pierre.rambaud86@gmail.com',
                'login' => 'test',
                'user_acl_role_id' => 1,
            )
        );
        $this->user->setPassword('test');
        $this->user->save();

        $this->documentType = DocumentTypeModel::fromArray(
            array(
                'name' => 'Document Type Name',
                'description' => 'Document Type description',
                'icon_id' => 1,
                'defaultview_id' => $this->view->getId(),
                'user_id' => $this->user->getId(),
            )
        );
        $this->documentType->save();

        $this->datatype = DatatypeModel::fromArray(
            array(
                'name' => 'ImageCropperTest',
                'prevalue_value' => '',
                'model' => 'ImageCropper',
            )
        );
        $this->datatype->save();

        $this->tab = TabModel::fromArray(
            array(
                'name' => 'TabTest',
                'description' => 'TabTest',
                'sort_order' => 1,
                'document_type_id' => $this->documentType->getId(),
            )
        );
        $this->tab->save();

        $this->property = PropertyModel::fromArray(
            array(
                'name' => 'DatatypeTest',
                'identifier' => 'DatatypeTest',
                'description' => 'DatatypeTest',
                'required' => false,
                'sort_order' => 1,
                'tab_id' => $this->tab->getId(),
                'datatype_id' => $this->datatype->getId(),
            )
        );

        $this->property->save();

        $this->document = DocumentModel::fromArray(
            array(
                'name' => 'jQueryFileUploadTest',
                'url_key' => '/jqueryfileupload-test',
                'status' => DocumentModel::STATUS_ENABLE,
                'sort_order' => 1,
                'show_in_nav' => false,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => 0,
            )
        );
        $this->document->save();
        $datatype = new Datatype();
        $datatype->load($this->datatype, $this->document->getId());
        $this->object = $datatype->getEditor($this->property);

        $this->object->setConfig(
            array(
                'background' => '#FFFFFF',
                'resize_option' => 'auto',
                'mime_list' => array(
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                ),
                'size' => array(
                    array (
                        'name' => '223x112',
                        'width' => '223',
                        'height' => '112',
                    ),
                    array (
                        'name' => '600x300',
                        'width' => '600',
                        'height' => '300',
                    ),
                ),
            )
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        $_FILES = array();
        $_POST  = array();
        $this->datatype->delete();
        $this->document->delete();
        $this->documentType->delete();
        $this->layout->delete();
        $this->property->delete();
        $this->tab->delete();
        $this->user->delete();
        $this->view->delete();

        unset($this->datatype);
        unset($this->document);
        unset($this->documentType);
        unset($this->layout);
        unset($this->property);
        unset($this->tab);
        unset($this->user);
        unset($this->view);
        unset($this->object);
    }

    /**
     * Test
     *
     * @covers Datatypes\ImageCropper\Editor
     *
     * @return void
     */
    public function testSave()
    {
        $_FILES = array(
            $this->object->getName() => array(
                'name' => __DIR__ . '/_files/test.jpg',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => __DIR__ . '/_files/test.jpg',
                'error' => 0
            )
        );

        $this->object->save();
        $this->assertInternalType('string', $this->object->getValue());
        $this->removeDirectories();
    }

    /**
     * Test
     *
     * @covers Datatypes\ImageCropper\Editor
     *
     * @return void
     */
    public function testSaveWithBmp()
    {
        copy(__DIR__ . '/_files/test-source.bmp', __DIR__ . '/_files/test.bmp');
        $_FILES = array(
            $this->object->getName() => array(
                'name' => __DIR__ . '/_files/test.bmp',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => __DIR__ . '/_files/test.bmp',
                'error' => 0
            )
        );

        $this->object->save();
        $this->assertInternalType('string', $this->object->getValue());
        $this->removeDirectories();
    }

    /**
     * Test
     *
     * @covers Datatypes\ImageCropper\Editor
     *
     * @return void
     */
    public function testSaveWithEmptyFilesVar()
    {
        $data = serialize(
            array(
                'original' => array(
                    'value' => '/media/files/test/test.jpg',
                    'width' => 10,
                    'height' => 10,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                ), '223x112' => array(
                    'value' => '/media/files/test/test-223x112.jpg',
                    'width' => 223,
                    'height' => 112,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                    'x' => 0,
                    'y' => 0,
                ),
                '800x600' => array(
                    'value' => '/media/files/test/test.jpg',
                    'width' => 223,
                    'height' => 112,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                    'x' => 0,
                    'y' => 0,
                ),
            )
        );
        $this->object->getRequest()->getPost()->set($this->object->getName() . '-hidden', $data);

        $this->object->save();
        $this->assertInternalType('string', $this->object->getValue());
    }

    /**
     * Test
     *
     * @covers Datatypes\ImageCropper\Editor
     *
     * @return void
     */
    public function testLoad()
    {
        $data = serialize(
            array(
                'original' => array(
                    'value' => '/media/files/test/test.jpg',
                    'width' => 10,
                    'height' => 10,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                ), '223x112' => array(
                    'value' => '/media/files/test/test-223x112.jpg',
                    'width' => 223,
                    'height' => 112,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                    'x' => 0,
                    'y' => 0,
                ),
                '800x600' => array(
                    'value' => '/media/files/test/test.jpg',
                    'width' => 223,
                    'height' => 112,
                    'html' => 2,
                    'mime' => 'image/jpeg',
                    'x' => 0,
                    'y' => 0,
                ),
            )
        );

        $this->object->setValue($data);
        $this->assertInternalType('array', $this->object->load());
    }

    /**
     * Remove directories
     *
     * @return mixed
     */
    protected function removeDirectories()
    {
        $file = new File();
        $file->load($this->property, $this->document);
        $dir = $file->getPath() . $file->getDirectory();
        if (is_dir($dir)) {
            $data = glob($dir . '/*');
            foreach ($data as $file) {
                unlink($file);
            }

            $tmpDir = $dir;
            while ($tmpDir != GC_MEDIA_PATH . '/files') {
                rmdir($tmpDir);
                $tmpDir = realpath(dirname($tmpDir));
            }
        }
    }
}
