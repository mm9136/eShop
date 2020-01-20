package eShop.rest

import java.io.Serializable

data class Product(

        var product_id: Int = 0,
        var name: String = "",
        var price: Int = 0,
        var active: Int = 0,
        var description: String = "") : Serializable
