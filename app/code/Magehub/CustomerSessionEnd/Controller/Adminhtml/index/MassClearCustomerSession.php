<?php
/**
 * Copyright © Magehub. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magehub\CustomerSessionEnd\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassAssignGroup
 */
class MassClearCustomerSession extends \Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction
{
    protected $sessionModel;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magehub\CustomerSessionEnd\Model\Session $sessionModel
    ) {
        parent::__construct($context, $filter, $collectionFactory);
        $this->sessionModel = $sessionModel;
    }

    /**
     * Customer mass assign group action
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $customer_ids = $collection->getAllIds();
        $deleted_session_count = $this->sessionModel->customerSessionEnd($customer_ids);

        $this->messageManager->addSuccess(__('Total of %1 session(s) have been cleared', $deleted_session_count));
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
