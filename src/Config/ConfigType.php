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

interface ConfigType
{
    /**
     * @param Config $config
     * @param BootstrapConfigModel $model
     */
    public function buildConfig(Config $config, BootstrapConfigModel $model);

    /**
     * @param $key
     * @param Config $config
     * @param BootstrapConfigModel $model
     */
    public function extractConfig($key, Config $config, BootstrapConfigModel $model);

} 