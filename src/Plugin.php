<?php

namespace Wpuse\Mixer;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface, EventSubscriberInterface
{

    const CALLBACK_PRIORITY = 1000;

    /** @var Installer */
    private Installer $installer;

    /**
     * @param Composer $composer 项目的 composer 文件 对应的类
     * @param IOInterface $io
     * @return void
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }

    /**
     * @param Composer $composer
     * @param IOInterface $io
     * @return void
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_UPDATE => [
                'onPostPackage', self::CALLBACK_PRIORITY
            ],
            PackageEvents::POST_PACKAGE_INSTALL => [
                'onPostPackage', self::CALLBACK_PRIORITY
            ],
        ];
    }

    /**
     *
     * @param PackageEvent $event
     * @return void
     */
    public function onPostPackage(PackageEvent $event)
    {
        $rootPackage = $event->getComposer()->getPackage();
        /** @var UpdateOperation|InstallOperation $operation */
        $operation = $event->getOperation();
        if ($operation instanceof UpdateOperation) {
            /** @var Package $installedPackage */
            $installedPackage = $operation->getTargetPackage();
        } else {
            /** @var Package $installedPackage */
            $installedPackage = $operation->getPackage();
        }
//       @todo 写个脚本实现
//        if (!$event->isDevMode()) {
//            $installedPackagePath = $this->installer->getInstallPath($installedPackage);
//            var_dump($installedPackagePath);
//            exec("rm -rf " . $installedPackagePath . '.git');
//        }
    }
}
