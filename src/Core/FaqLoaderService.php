<?php declare(strict_types = 1);

namespace Dms\Package\Faq\Core;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FaqLoaderService
{
    /**
     * @var IFaqRepository
     */
    protected $repository;

    /**
     * FaqLoaderService constructor.
     *
     * @param IFaqRepository $repository
     */
    public function __construct(IFaqRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Loads the FAQ's
     *
     * @return Faq[]
     */
    public function loadFaqs() : array
    {
        return $this->repository->matching(
            $this->repository->criteria()
                ->orderByAsc(Faq::ORDER_TO_DISPLAY)
        );
    }
}