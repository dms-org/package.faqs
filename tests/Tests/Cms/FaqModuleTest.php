<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Tests\Cms;

use Dms\Common\Structure\Web\Html;
use Dms\Core\Auth\IPermission;
use Dms\Core\Auth\Permission;
use Dms\Core\Common\Crud\ICrudModule;
use Dms\Core\Model\IMutableObjectSet;
use Dms\Core\Persistence\ArrayRepository;
use Dms\Core\Tests\Common\Crud\Modules\CrudModuleTest;
use Dms\Core\Tests\Module\Mock\MockAuthSystem;
use Dms\Core\Util\DateTimeClock;
use Dms\Package\Faq\Cms\FaqModule;
use Dms\Package\Faq\Core\Faq;
use Dms\Package\Faq\Core\IFaqRepository;

/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqModuleTest extends CrudModuleTest
{
    /**
     * @return IMutableObjectSet
     */
    protected function buildRepositoryDataSource() : IMutableObjectSet
    {
        return new class(Faq::collection()) extends ArrayRepository implements IFaqRepository
        {
            public function reorderDisplay(Faq $faq, int $newIndex)
            {

            }
        };
    }

    /**
     * @param IMutableObjectSet $dataSource
     * @param MockAuthSystem    $authSystem
     *
     * @return ICrudModule
     */
    protected function buildCrudModule(IMutableObjectSet $dataSource, MockAuthSystem $authSystem) : ICrudModule
    {
        return new FaqModule($dataSource, $authSystem, new DateTimeClock());
    }

    /**
     * @return string
     */
    protected function expectedName()
    {
        return 'faqs';
    }

    /**
     * @return IPermission[]
     */
    protected function expectedReadModulePermissions()
    {
        return [
            Permission::named(ICrudModule::EDIT_PERMISSION),
            Permission::named(ICrudModule::CREATE_PERMISSION),
            Permission::named(ICrudModule::REMOVE_PERMISSION),
        ];
    }

    /**
     * @return IPermission[]
     */
    protected function expectedReadModuleRequiredPermissions()
    {
        return [
            Permission::named(ICrudModule::VIEW_PERMISSION),
        ];
    }

    public function testCreate()
    {
        $this->module->getCreateAction()->run([
            'question' => 'Some question',
            'answer'   => 'Some answer',
        ]);

        $this->assertCount(1, $this->dataSource);

        /** @var Faq $faq */
        $faq = $this->dataSource->get(1);

        $this->assertEquals('Some question', $faq->question);
        $this->assertEquals('Some answer', $faq->answer->asString());
    }

    public function testEdit()
    {
        $faq = new Faq(new DateTimeClock(), 'Some question', new Html('Some answer'));
        $this->dataSource->save($faq);

        $this->module->getEditAction()->run([
            'object'  => 1,
            'question' => 'Another question',
            'answer'   => 'Another answer',
        ]);

        $this->assertCount(1, $this->dataSource);

        /** @var Faq $faq */
        $faq = $this->dataSource->get(1);

        $this->assertEquals('Another question', $faq->question);
        $this->assertEquals('Another answer', $faq->answer->asString());
    }
}