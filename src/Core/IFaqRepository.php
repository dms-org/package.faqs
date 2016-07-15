<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Core;

use Dms\Core\Exception;
use Dms\Core\Model\ICriteria;
use Dms\Core\Model\ISpecification;
use Dms\Core\Persistence\IRepository;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IFaqRepository extends IRepository
{
    /**
     * {@inheritDoc}
     *
     * @return Faq[]
     */
    public function getAll() : array;

    /**
     * {@inheritDoc}
     *
     * @return Faq
     */
    public function get($id);

    /**
     * {@inheritDoc}
     *
     * @return Faq[]
     */
    public function getAllById(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return Faq|null
     */
    public function tryGet($id);

    /**
     * {@inheritDoc}
     *
     * @return Faq[]
     */
    public function tryGetAll(array $ids) : array;

    /**
     * {@inheritDoc}
     *
     * @return Faq[]
     */
    public function matching(ICriteria $criteria) : array;

    /**
     * {@inheritDoc}
     *
     * @return Faq[]
     */
    public function satisfying(ISpecification $specification) : array;

    /**
     * @param Faq $faq
     * @param int $newIndex
     *
     * @return void
     */
    public function reorderDisplay(Faq $faq, int $newIndex);
}
