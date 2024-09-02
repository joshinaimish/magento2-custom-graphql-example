<?php
namespace Nxtech\CustomGraphql\Model\ResourceModel\Products;

class Collection
{
    public function __construct(
        protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        protected \Magento\Catalog\Api\ProductRepositoryInterface $product
    ) {
    }

    public function getProductCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(15); // fetching only 3 products
        return $collection;
    }
    public function getProduct($productId)
    {
        return $this->product->getById($productId);
    }
}
