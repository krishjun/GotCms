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
 * @category   Gc_Library
 * @package    Modules
 * @subpackage Blog\Model
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace Blog\Plugin;

use Gc\Module\AbstractPlugin;
use Blog;

/**
 * Blog comment table
 *
 * @category   Gc_Library
 * @package    Modules
 * @subpackage Blog\Model
 */
class CommentList extends AbstractPlugin
{
    /**
     * Form
     *
     * @var \Blog\Form\Comment
     */
    protected $form;

    /**
     * Invoke form
     *
     * @return void
     */
    public function __invoke()
    {
        $commentTable = new Blog\Model\Comment();
        $document     = $this->getServiceLocator()
            ->get('Zend\View\Renderer\PhpRenderer')
            ->plugin('CurrentDocument');
        $comments     = $commentTable->getList($document()->getId());

        return $this->addPath(__DIR__ . '/../views')->render(
            'plugin/comment-list.phtml',
            array(
                'comments' => $comments,
            )
        );
    }
}
