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
 * @category    Gc
 * @package     Library
 * @subpackage  DocumentType
 * @author      Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license     GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link        http://www.got-cms.com
 */

namespace Gc\DocumentType;

use Gc\Db\AbstractTable,
    Gc\User,
    Gc\Tab,
    Gc\View,
    Zend\Db\Sql,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Predicate\Expression;
/**
 * Model for Document Type
 */
class Model extends AbstractTable
{
    /**
     * Table name
     * @var string
     */
    protected $_name = 'document_type';

    /**
     * List of view id
     * @var integer
     */
    protected $_views = array();

    /**
     * Get user model
     * @return \Gc\Model\user
     */
    public function getUser()
    {
        if($this->getData('user') === NULL AND $this->getUserId() != NULL)
        {
            $this->setData('user', User\Model::fromId($this->getUserId()));
        }

        return $this->getData('user');
    }

    /**
     * Add view
     * @param integer $view_id
     * @return \Gc\DocumentType\Model
     */
    public function addView($view_id)
    {
        $this->_views[] = $view_id;
        return $this;
    }

    /**
     * Add views
     * @param array $views
     * @return \Gc\DocumentType\Model
     */
    public function addViews(array $views)
    {
        if(!empty($views))
        {
            $this->_views += $views;
        }

        return $this;
    }

    /**
     * Get Tabs
     * @return \Gc\Tab\Collection
     */
    public function getTabs()
    {
        if($this->getData('tabs') === NULL )
        {
            $tabs_collection = new Tab\Collection();
            $tabs_collection->load($this->getId());

            $this->setData('tabs', $tabs_collection->getTabs());
        }

        return $this->getData('tabs');
    }

    /**
     * Get available views
     * @return array of \Gc\View\Collection
     */
    public function getAvailableViews()
    {
        if($this->getData('available_views') === NULL)
        {
            $views_collection = new View\Collection();
            $views_collection->init($this->getId());

            $this->setData('available_views', $views_collection);
        }

        return $this->getData('available_views');
    }

    /**
     * Get dependencies
     * @return array
     */
    public function getDependencies()
    {
        $dependencies = $this->getData('dependencies');
        if(empty($dependencies))
        {
            $select = new Sql\Select();
            $select->from(array('dtd' => 'document_type_dependency'))
            ->columns(array('children_id'))
            ->where->equalTo('parent_id', $this->getId());
            $rows = $this->fetchAll($select);

            $result = array();
            foreach($rows as $row)
            {
                $result[] = $row['children_id'];
            }

            $this->setData('dependencies', $result);
        }

        return $this->getData('dependencies');
    }

    /**
     * Save document type model
     * @return integer
     */
    public function save()
    {
        $this->events()->trigger(__CLASS__, 'beforeSave', NULL, array('object' => $this));
        $array_save = array(
            'name' => $this->getName(),
            'updated_at' => new Expression('NOW()'),
            'description' => $this->getDescription(),
            'icon_id' => $this->getIconId(),
            'default_view_id' => $this->getDefaultViewId(),
            'user_id' => $this->getUserId(),
        );

        try
        {
            $id = $this->getId();
            if(empty($id))
            {
                $array_save['created_at'] = new Expression('NOW()');
                $this->insert($array_save);
                $this->setId($this->getLastInsertId());
            }
            else
            {
                $this->update($array_save, array('id' => (int)$this->getId()));
            }

            if(!empty($this->_views))
            {
                $delete = new Sql\Delete();
                $delete->from('document_type_view');
                $delete->where(array('document_type_id' => (int)$this->getId()));
                $this->execute($delete);
                foreach($this->_views as $view_id)
                {
                    if(empty($view_id))
                    {
                        continue;
                    }

                    $insert = new Sql\Insert();
                    $insert->into('document_type_view')
                        ->values(array('document_type_id' => $this->getId(), 'view_id' => $view_id));
                    $this->execute($insert);
                }
            }

            $delete = new Sql\Delete();
            $delete->from('document_type_dependency');
            $delete->where->equalTo('parent_id', (int)$this->getId());
            $this->execute($delete);
            $dependencies = $this->getDependencies();
            if(!empty($dependencies))
            {
                foreach($dependencies as $children_id)
                {
                    $insert = new Sql\Insert();
                    $insert->into('document_type_dependency')
                        ->values(array('parent_id' => $this->getId(), 'children_id' => $children_id));
                    $this->execute($insert);
                }
            }

            $this->events()->trigger(__CLASS__, 'afterSave', NULL, array('object' => $this));

            return $this->getId();
        }
        catch(\Exception $e)
        {
            throw new \Gc\Exception($e->getMessage(), $e->getCode(), $e);
        }

        $this->events()->trigger(__CLASS__, 'afterSaveFailed', NULL, array('object' => $this));

        return FALSE;
    }

    /**
     * Delete document type model
     * @return boolean
     */
    public function delete()
    {
        $this->events()->trigger(__CLASS__, 'beforeDelete', NULL, array('object' => $this));
        $document_type_id = $this->getId();
        if(!empty($document_type_id))
        {
            $tab_collection = new Tab\Collection();
            $tab_collection->load($document_type_id);
            $tab_collection->delete();
            $table = new TableGateway('document_type_view', $this->getAdapter());
            $result = $table->delete(array('document_type_id' => (int)$document_type_id));
            parent::delete(array('id' => $document_type_id));
            $this->events()->trigger(__CLASS__, 'afterDelete', NULL, array('object' => $this));
            unset($this);

            return TRUE;
        }

        $this->events()->trigger(__CLASS__, 'afterDeleteFailed', NULL, array('object' => $this));

        return FALSE;
    }

    /**
     * Get model from array
     * @param array $array
     * @return \Gc\DocumentType\Model
     */
    static function fromArray(array $array)
    {
        $document_type_table = new Model();
        $document_type_table->setData($array);

        return $document_type_table;
    }

    /**
     * Get model from id
     * @param integer $document_type_id
     * @return \Gc\DocumentType\Model
     */
    static function fromId($document_type_id)
    {
        $document_type_table = new Model();
        $row = $document_type_table->select(array('id' => (int)$document_type_id));
        $current = $row->current();
        if(!empty($current))
        {
            return $document_type_table->setData((array)$current);
        }
        else
        {
            return FALSE;
        }
    }
}
