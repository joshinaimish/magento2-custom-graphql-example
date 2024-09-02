<?php
namespace Nxtech\CustomGraphql\Model\Resolver;

use Nxtech\CustomGraphql\Model\ResourceModel\Products\Collection;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetAllProducts implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @param Collection $collection
     */
    public function __construct(
        private Collection $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {

        try {

            $collection = $this->collection->getProductCollection();
            if (!$collection->count()) {
                return [];
            }

            $dckapProductsCollection['allProducts'] = [];
            foreach ($collection as $item) {
                $productId = $item->getEntityId();
                $product = $this->collection->getProduct($productId);
                $dckapProductsCollection['allProducts'][$item["entity_id"]]['entity_id'] = $productId;
                $dckapProductsCollection['allProducts'][$item["entity_id"]]['name'] = $product->getName();
                $dckapProductsCollection['allProducts'][$item["entity_id"]]['description'] = $product->getDescription();
            }

        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }

        return $dckapProductsCollection;
    }
}