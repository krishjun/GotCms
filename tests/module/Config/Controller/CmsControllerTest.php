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
 * @package  ZfModules
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Config\Controller;

use Gc\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-15 at 23:51:00.
 *
 * @group    ZfModules
 * @category Gc_Tests
 * @package  ZfModules
 */
class CmsControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->init();
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testEditGeneralAction()
    {
        $this->dispatch('/admin/config/general');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/general');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testEditSystemAction()
    {
        $this->dispatch('/admin/config/system');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/system');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testEditServerAction()
    {
        $this->dispatch('/admin/config/server');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/server');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testEditAction()
    {
        $this->dispatch(
            '/admin/config/server',
            'POST',
            array(
                'locale' => 'fr_FR',
                'mail_from' => 'pierre.rambaud86@gmail.com',
                'mail_from_name' => 'Pierre Rambaud',
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/server');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testEditActionWithInvalidForm()
    {
        $this->dispatch(
            '/admin/config/server',
            'POST',
            array(
            )
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/server');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testUpdateAction()
    {
        $this->dispatch('/admin/config/update');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/cms-update');
    }

    /**
     * Test
     *
     * @covers Config\Controller\CmsController
     *
     * @return void
     */
    public function testUpdateActionWithWrongAdapter()
    {
        $this->dispatch(
            '/admin/config/update',
            'POST',
            array(
                'adapter' => 'fake'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('CmsController');
        $this->assertControllerClass('CmsController');
        $this->assertMatchedRouteName('config/cms-update');
    }
}
