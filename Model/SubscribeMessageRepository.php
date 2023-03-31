<?php
/**
 * SubscribeMessage entity resource model
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\WeChat\Api\Data\SubscribeMessageInterface;
use AlbertMage\WeChat\Api\Data\SubscribeMessageInterfaceFactory;
use AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterfaceFactory;
use AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage;
use AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage\CollectionFactory;

/**
 * SubscribeMessage repository.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessageRepository implements \AlbertMage\WeChat\Api\SubscribeMessageRepositoryInterface
{

    /**
     * @var \AlbertMage\WeChat\Model\SubscribeMessageFactory
     */
    protected $subscribeMessageFactory;

    /**
     * @var \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage
     */
    protected $subscribeMessageResourceModel;

    /**
     * @var \AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterfaceFactory
     */
    protected $subscribeMessageSearchResultsFactory;

    /**
     * @var \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage\CollectionFactory
     */
    protected $subscribeMessageCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \AlbertMage\WeChat\Model\SubscribeMessageFactory $subscribeMessageFactory
     * @param \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage $subscribeMessageResourceModel
     * @param \AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterfaceFactory $subscribeMessageSearchResultsFactory
     * @param \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage\CollectionFactory $subscribeMessageCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\WeChat\Model\SubscribeMessageFactory $subscribeMessageFactory,
        \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage $subscribeMessageResourceModel,
        \AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterfaceFactory $subscribeMessageSearchResultsFactory,
        \AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage\CollectionFactory $subscribeMessageCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->subscribeMessageFactory = $subscribeMessageFactory;
        $this->subscribeMessageResourceModel = $subscribeMessageResourceModel;
        $this->subscribeMessageSearchResultsFactory = $subscribeMessageSearchResultsFactory;
        $this->subscribeMessageCollectionFactory = $subscribeMessageCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(\AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage)
    {
        $this->subscribeMessageResourceModel->save($subscribeMessage);
        return $subscribeMessage;
    }

    /**
     * @inheritDoc
     */
    public function delete(\AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage)
    {
        $this->subscribeMessageResourceModel->delete($subscribeMessage);
        return $subscribeMessage;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $subscribeMessage = $this->subscribeMessageInterfaceFactory->create()->load($id, 'id');
        if (!$subscribeMessage->getId()) {
            throw new NoSuchEntityException(
                __("The sms message that was requested doesn't exist.")
            );
        }
        return $subscribeMessage;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->subscribeMessageCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = $collection->getItems();

        /** @var \AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterface $searchResults */
        $searchResults = $this->subscribeMessageSearchResultsFactory->create();
        $searchResults->setItems($items);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessage|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByOpenIdAndTemplateId($openId, $templateId)
    {
        /** @var Collection $collection */
        $collection = $this->subscribeMessageCollectionFactory->create();
        $collection->addFieldToFilter('openid', ['eq' => $openId]);
        $collection->addFieldToFilter('template_id', ['eq' => $templateId]);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return null;
    }
}
