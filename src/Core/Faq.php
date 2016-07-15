<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Core;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Web\Html;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;
use Dms\Core\Util\IClock;

/**
 * The FAQ entity
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Faq extends Entity
{
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const ORDER_TO_DISPLAY = 'orderToDisplay';
    const UPDATED_AT = 'updatedAt';
    const CREATED_AT = 'createdAt';

    /**
     * @var string
     */
    public $question;

    /**
     * @var Html
     */
    public $answer;

    /**
     * @var int
     */
    public $orderToDisplay;

    /**
     * @var DateTime
     */
    public $updatedAt;

    /**
     * @var DateTime
     */
    public $createdAt;

    /**
     * Faq constructor.
     *
     * @param IClock $clock
     * @param string $question
     * @param Html   $answer
     */
    public function __construct(IClock $clock, string $question, Html $answer)
    {
        parent::__construct();

        $this->question  = $question;
        $this->answer    = $answer;
        $this->updatedAt = new DateTime($clock->utcNow());
        $this->createdAt = new DateTime($clock->utcNow());
    }

    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        $class->property($this->question)->asString();

        $class->property($this->answer)->asObject(Html::class);

        $class->property($this->orderToDisplay)->asInt();

        $class->property($this->updatedAt)->asObject(DateTime::class);
        
        $class->property($this->createdAt)->asObject(DateTime::class);
    }
}