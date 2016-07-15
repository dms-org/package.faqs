<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Persistence;

use Dms\Common\Structure\DateTime\Persistence\DateTimeMapper;
use Dms\Common\Structure\Web\Persistence\HtmlMapper;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\EntityMapper;
use Dms\Package\Faq\Core\Faq;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqMapper extends EntityMapper
{
    /**
     * Defines the entity mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(Faq::class);
        $map->toTable('faqs');

        $map->idToPrimaryKey('id');

        $map->property(Faq::QUESTION)->to('question')->asVarchar(255);
        
        $map->embedded(Faq::ANSWER)
            ->using(new HtmlMapper('answer'));
        
        $map->property(Faq::ORDER_TO_DISPLAY)->to('order_to_display')->asInt();
        
        $map->embedded(Faq::UPDATED_AT)
            ->using(new DateTimeMapper('updated_at'));
        
        $map->embedded(Faq::CREATED_AT)
            ->using(new DateTimeMapper('created_at'));

        $map->hook()->saveOrderIndexTo('order_to_display');
    }
}