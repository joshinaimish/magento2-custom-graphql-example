# magento2-custom-graphql-example
magento2-custom-graphql-example


#run below command in Altair Graphql Chrome Tool
query{
  getAllProductsCollection{
    allProducts{
      entity_id
      name
      description
    }
  }
}
# Pass your Product Id instead of "3"
query{
  getProductsById(id:3){
    id
    name
    description
  }
}