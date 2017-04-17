
curl -XPOST localhost:9200/test -d '{
    "settings" : {
        "number_of_shards" : 1
    },
    "mappings" : {
        "type1" : {
            "properties" : {
                "field1" : { "type" : "string", "index" : "not_analyzed" }
            }
        }
    }
}'


// 索引名称/类型/id(es存储数据文档id)/文章内容
curl -XPUT 'http://localhost:9200/aqie_shop/products/1' -d '{
    "productid":1,
    "title":"这是一个文章标题",
    "descr":"这是一个商品描述"
}'

curl -XPUT "http://localhost:9200/aqie_shop/products/1?pretty" -d '{"productid":1,"title":"这是一个文章标题","descr":"这是一个商品描述"}'