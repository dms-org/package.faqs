<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Cms;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Field;
use Dms\Core\Auth\IAuthSystem;
use Dms\Core\Common\Crud\CrudModule;
use Dms\Core\Common\Crud\Definition\CrudModuleDefinition;
use Dms\Core\Common\Crud\Definition\Form\CrudFormDefinition;
use Dms\Core\Common\Crud\Definition\Table\SummaryTableDefinition;
use Dms\Core\Util\IClock;
use Dms\Package\Faq\Core\Faq;
use Dms\Package\Faq\Core\IFaqRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqModule extends CrudModule
{
    /**
     * @var IFaqRepository
     */
    protected $dataSource;

    /**
     * @var IClock
     */
    private $clock;

    public function __construct(IFaqRepository $dataSource, IAuthSystem $authSystem, IClock $clock)
    {
        $this->clock = $clock;
        parent::__construct($dataSource, $authSystem);
    }

    /**
     * Defines the structure of this module.
     *
     * @param CrudModuleDefinition $module
     */
    protected function defineCrudModule(CrudModuleDefinition $module)
    {
        $module->name('faqs');

        $module->metadata([
            'icon' => 'question-circle',
        ]);

        $module->labelObjects()->fromProperty(Faq::QUESTION);

        $module->crudForm(function (CrudFormDefinition $form) {
            $form->section('Details', [
                $form->field(
                    Field::create('question', 'Question')->string()->required()
                )->bindToProperty(Faq::QUESTION),
                //
                $form->field(
                    Field::create('answer', 'Answer')->html()->required()
                )->bindToProperty(Faq::ANSWER),
            ]);

            if ($form->isCreateForm()) {
                $form->onSubmit(function (Faq $faq) {
                    $faq->updatedAt = new DateTime($this->clock->utcNow());
                    $faq->createdAt = new DateTime($this->clock->utcNow());
                });
            } else {
                $form->continueSection([
                    $form->field(
                        Field::create('updated_at', 'Updated At')->dateTime()->required()->readonly()
                    )->bindToProperty(Faq::UPDATED_AT),
                    //
                    $form->field(
                        Field::create('created_at', 'Created At')->dateTime()->required()->readonly()
                    )->bindToProperty(Faq::CREATED_AT),
                ]);

                $form->onSubmit(function (Faq $faq) {
                    $faq->updatedAt = new DateTime($this->clock->utcNow());
                });
            }
        });

        $module->removeAction()->deleteFromDataSource();

        $module->summaryTable(function (SummaryTableDefinition $table) {
            $table->mapProperty(Faq::QUESTION)->to(Field::create('question', 'Question')->string());
            $table->mapProperty(Faq::CREATED_AT)->to(Field::create('created_at', 'Created At')->dateTime());
            $table->mapProperty(Faq::ORDER_TO_DISPLAY)->hidden()->to(Field::create('order', 'Order')->int());

            $table->view('all', 'All')
                ->asDefault()
                ->loadAll()
                ->orderByAsc('order')
                ->withReorder(function (Faq $faq, int $newIndex) {
                    $this->dataSource->reorderDisplay($faq, $newIndex);
                });
        });
    }
}