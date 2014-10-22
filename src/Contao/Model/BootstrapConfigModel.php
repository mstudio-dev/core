<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Core\Contao\Model;

/**
 * Class BootstrapConfigModel
 * @package Netzmacht\Bootstrap\Contao\Model
 * @property int    id
 * @property string type
 * @property bool   delete
 */
class BootstrapConfigModel extends \Model
{
    /**
     * @var string
     */
    protected static $strTable = 'tl_bootstrap_config';

    /**
     * Find all published configurations which belongs to a theme
     *
     * @param int   $themeId
     * @param array $options
     *
     * @return \Model\Collection|null
     */
    public static function findPublishedByTheme($themeId, array $options=array(), $ignoreGlobal=true)
    {
        if (!isset($options['order'])) {
            $options['order'] = 'sorting';
        }

        return static::findBy(
            array('published=?', 'pid=?', 'global=?'),
            array(true, $themeId, $ignoreGlobal),
            $options
        );
    }

    /**
     * Find all published configurations which belongs to the global scope
     *
     * @param array $options
     *
     * @return \Model\Collection|null
     */
    public static function findGlobalPublished(array $options=array())
    {
        if (!isset($options['order'])) {
            $options['order'] = 'sorting';
        }

        return static::findBy(
            array('published=?', 'global=?'),
            array(true, true),
            $options
        );
    }
} 