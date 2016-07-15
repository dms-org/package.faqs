<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Tests\Core;

use Dms\Common\Structure\Web\Html;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Persistence\ArrayRepository;
use Dms\Core\Util\DateTimeClock;
use Dms\Package\Faq\Core\Faq;
use Dms\Package\Faq\Core\FaqLoaderService;
use Dms\Package\Faq\Core\IFaqRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqLoaderServiceTest extends CmsTestCase
{
    /**
     * @var IFaqRepository
     */
    protected $repo;

    /**
     * @var FaqLoaderService
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();

        $faq1                 = new Faq(new DateTimeClock(), 'question #1', new Html('question #1'));
        $faq1->orderToDisplay = 1;

        $faq2                 = new Faq(new DateTimeClock(), 'question #2', new Html('question #2'));
        $faq2->orderToDisplay = 2;

        $faqs = Faq::collection([$faq1, $faq2,]);

        $this->repo = new class($faqs) extends ArrayRepository implements IFaqRepository
        {
            public function reorderDisplay(Faq $faq, int $newIndex)
            {

            }
        };

        $this->service = new FaqLoaderService(            $this->repo        );
    }

    public function testLoadFaqs()
    {
        $faqs = $this->service->loadFaqs();

        $this->assertSame('question #1', $faqs[0]->question);
        $this->assertSame('question #2', $faqs[1]->question);
    }
}