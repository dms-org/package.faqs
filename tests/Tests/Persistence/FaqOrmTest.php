<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Tests\Persistence;

use Dms\Common\Structure\Web\Html;
use Dms\Core\Exception\NotImplementedException;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;
use Dms\Core\Util\IClock;
use Dms\Package\Faq\Core\Faq;
use Dms\Package\Faq\Persistence\FaqOrm;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqOrmTest extends DbIntegrationTest
{

    /**
     * @return IOrm
     */
    protected function loadOrm()
    {
        return new FaqOrm();
    }

    public function testSaveAndLoad()
    {
        $clock = new class implements IClock
        {
            public function now() : \DateTimeImmutable
            {
                throw new NotImplementedException;
            }

            public function utcNow() : \DateTimeImmutable
            {
                return new \DateTimeImmutable('2000-01-01 00:00:00');
            }
        };

        $enquiry = new Faq($clock, 'Some question', new Html('Some answer'));
        $this->repo->save($enquiry);

        $this->assertDatabaseDataSameAs([
            'faqs' => [
                [
                    'id'               => 1,
                    'question'         => 'Some question',
                    'answer'           => 'Some answer',
                    'order_to_display' => 1,
                    'updated_at'       => '2000-01-01 00:00:00',
                    'created_at'       => '2000-01-01 00:00:00',
                ],
            ],
        ]);

        $this->assertEquals($enquiry, $this->repo->get(1));
    }
}