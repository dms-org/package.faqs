<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Persistence;

use Dms\Core\Persistence\Db\Connection\IConnection;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Persistence\DbRepository;
use Dms\Package\Faq\Core\Faq;
use Dms\Package\Faq\Core\IFaqRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DbFaqRepository extends DbRepository implements IFaqRepository
{
    public function __construct(IConnection $connection, IOrm $orm)
    {
        parent::__construct($connection, $orm->getEntityMapper(Faq::class));
    }

    /**
     * @param Faq $faq
     * @param int $newIndex
     *
     * @return void
     */
    public function reorderDisplay(Faq $faq, int $newIndex)
    {
        $this->reorder('order_to_display')
            ->withPrimaryKey($faq->getId())
            ->toNewIndex($newIndex)
            ->executeOn($this->connection);

        $faq->orderToDisplay = $newIndex;
    }
}