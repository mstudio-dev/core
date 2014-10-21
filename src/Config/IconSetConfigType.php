<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Core\Config;

use Netzmacht\Bootstrap\Contao\Model\BootstrapConfigModel;
use Netzmacht\Bootstrap\Core\Config;

class IconSetConfigType implements ConfigType
{
    /**
     * @param Config $config
     * @param BootstrapConfigModel $model
     * @return mixed
     */
    public function buildConfig(Config $config, BootstrapConfigModel $model)
    {
        $key = 'icons.sets.' . $model->icons_name;

        if ($model->delete) {
            $config->remove($key);
            return;
        }

        $value = array(
            'stylesheet' => $this->getStylesheets($model),
            'template'   => $model->icons_template,
            'path'       => $model->icons_path,
        );

        $config->set($key, $value);
    }

    /**
     * @param $key
     * @param Config $config
     * @param BootstrapConfigModel $model
     */
    public function extractConfig($key, Config $config, BootstrapConfigModel $model)
    {
        if ($config->has($key)) {
            $config = $config->get($key);

            $keys = explode('.', $key);

            $model->name           = end($keys);
            $model->icons_template = $config['template'];
            $model->icons_paths    = implode("\n", (array) $config['paths']);
            $model->icons_path     = $config['path'];
            $model->icons_source   = 'paths';
        }
    }

    /**
     * @param BootstrapConfigModel $model
     * @return array
     */
    private function getStylesheets(BootstrapConfigModel $model)
    {
        if ($model->icons_stylesheet_source == 'files') {
            $fileIds = deserialize($model->icons_stylesheet_files);
            $files   = \FilesModel::findMultipleByIds($fileIds);

            return $files->fetchEach('path');
        }

        return explode("\n", $model->icons_stylesheet_paths);
    }
}