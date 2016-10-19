<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace ContaoBootstrap\Core\Subscriber;

use ContaoBootstrap\Core\Config\TypeManager;
use ContaoBootstrap\Core\Contao\Model\BootstrapConfigModel;
use ContaoBootstrap\Core\Event\InitializeEnvironmentEvent;
use ContaoBootstrap\Core\Event\InitializeLayoutEvent;
use ContaoBootstrap\Core\Util\Contao;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConfigSubscriber handles config loading from the database.
 *
 * @package ContaoBootstrap\Core\Subscriber
 */
class ConfigSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            InitializeEnvironmentEvent::NAME => 'loadGlobalConfig',
            InitializeLayoutEvent::NAME      => 'loadThemeConfig',
        );
    }

    /**
     * Load global configurations from database.
     *
     * @return void
     */
    public function loadGlobalConfig()
    {
        // prevent that database is loaded before user object
        Contao::intializeObjectStack();

        if (!\Database::getInstance()->tableExists('tl_bootstrap_config')) {
            return;
        }

        $collection = BootstrapConfigModel::findGlobalPublished();
        $this->getTypeManager()->buildConfig($collection);
    }

    /**
     * Load theme configuration from database.
     *
     * @param InitializeLayoutEvent $event InitializeLayout event.
     *
     * @return void
     *
     * @internal param Config $config
     */
    public function loadThemeConfig(InitializeLayoutEvent $event)
    {
        $themeId    = $event->getLayoutModel()->pid;
        $collection = BootstrapConfigModel::findPublishedByTheme($themeId);

        $this->getTypeManager()->buildConfig($collection);
    }

    /**
     * Get type manager.
     *
     * @return TypeManager
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function getTypeManager()
    {
        return $GLOBALS['container']['bootstrap.config-type-manager'];
    }
}
