<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Cms;

use Dms\Core\ICms;
use Dms\Core\Ioc\IIocContainer;
use Dms\Core\Package\Definition\PackageDefinition;
use Dms\Core\Package\Package;
use Dms\Package\Faq\Core\IFaqRepository;
use Dms\Package\Faq\Persistence\DbFaqRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqPackage extends Package
{
    /**
     * @param ICms $cms
     *
     * @return void
     */
    public static function boot(ICms $cms)
    {
        $cms->getIocContainer()->bind(IIocContainer::SCOPE_SINGLETON, IFaqRepository::class, DbFaqRepository::class);
    }

    /**
     * Defines the structure of this cms package.
     *
     * @param PackageDefinition $package
     *
     * @return void
     */
    protected function define(PackageDefinition $package)
    {
        $package->name('faqs');

        $package->metadata([
            'icon' => 'question-circle-o',
        ]);

        $package->modules([
            'faqs' => FaqModule::class,
        ]);
    }
}