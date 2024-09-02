<?php
namespace Nxtech\CustomGraphql\Model\Resolver;

use Nxtech\CustomGraphql\Model\ResourceModel\Products\Collection;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetProductsById implements \Magento\Framework\GraphQl\Query\ResolverInterface
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

            if (!isset($args['id'])) {
                throw new GraphQlInputException(__("Id is required field."));
            }
            $productId = $args['id'];
            $product = $this->collection->getProduct($productId);
            $productData = [];


            $productData = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "description" => $product->getDescription(),
            ];


        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }

        return $productData;
    }
}