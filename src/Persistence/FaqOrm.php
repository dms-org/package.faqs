<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;
use Dms\Package\Faq\Core\Faq;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->entities([
            Faq::class => FaqMapper::class,
        ]);
    }
}