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
 * @category   Gc_Application
 * @package    Config
 * @subpackage Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace Config\Controller;

use Gc\Mvc\Controller\Action,
    Gc\User,
    Gc\User\Role,
    Gc\User\Role\Rule,
    Config\Form\Role as RoleForm;

/**
 * Role controller
 *
 * @category   Gc_Application
 * @package    Config
 * @subpackage Controller
 */
class RoleController extends Action
{
    /**
     * Contains information about acl
     *
     * @var array $_aclPage
     */
    protected $_aclPage = array('resource' => 'Config', 'permission' => 'role');

    /**
     * List all roles
     *
     * @return \Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $roles = new Role\Collection();
        $roles->init();
        return array('roles' => $roles->getRoles());
    }

    /**
     * Create role
     *
     * @return \Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = new RoleForm();
        $form->initPermissions();
        $form->setAttribute('action', $this->url()->fromRoute('userRoleCreate'));

        if($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost()->toArray();
            $form->setData($post);
            if($form->isValid())
            {
                $role_model = new Role\Model();
                $role_model->addData($form->getInputFilter()->getValues());
                $role_model->save();

                $this->flashMessenger()->setNamespace('success')->addMessage('Role saved!');
                return $this->redirect()->toRoute('userRoleEdit', array('id' => $role_id));
            }

            $this->flashMessenger()->setNamespace('error')->addMessage('Role can not saved!');
            $this->useFlashMessenger();
        }

        return array('form' => $form);
    }

    /**
     * Delete role
     *
     * @return \Zend\View\Model\ViewModel|array
     */
    public function deleteAction()
    {
        $role = Role\Model::fromId($this->getRouteMatch()->getParam('id'));
        if(empty($role))
        {
            if($role->delete())
            {
                return $this->returnJson(array('success' => TRUE, 'message' => 'Role deleted!'));
            }
        }

        return $this->returnJson(array('success' => FALSE, 'message' => 'Role does not exists!'));
    }

    /**
     * Edit role
     *
     * @return \Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $role_id = $this->getRouteMatch()->getParam('id');

        $role_model = Role\Model::fromId($role_id);

        $form = new RoleForm();
        $form->initPermissions($role_model->getUserPermissions());
        $form->setAttribute('action', $this->url()->fromRoute('userRoleEdit', array('id' => $role_id)));
        $form->loadValues($role_model);
        if($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost()->toArray();
            $form->setData($post);
            if($form->isValid())
            {
                $role_model->addData($form->getInputFilter()->getValues());
                $role_model->save();

                $this->flashMessenger()->setNamespace('success')->addMessage('Role saved!');
                return $this->redirect()->toRoute('userRoleEdit', array('id' => $role_id));
            }

            $this->flashMessenger()->setNamespace('error')->addMessage('Role can not saved!');
            $this->useFlashMessenger();
        }

        return array('form' => $form);
    }
}
