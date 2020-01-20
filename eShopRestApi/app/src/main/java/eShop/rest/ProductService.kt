package eShop.rest

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

object ProductService {
    interface RestApi {

        companion object {
            const val URL = "http://10.0.2.2:8080/netbeans/eShop/"
            //const val URL = "https://localhost/netbeans/eShop/"
        }

        @GET("json/bazaInit.php")
        fun getAll(): Call<List<Product>>

        @DELETE("json/bazaInit.php?product_id={product_id}")
        fun delete(@Path("product_id") product_id: Int): Call<Void>

        @GET("json/bazaInit.php")
        fun get(@Query("product_id") product_id: Int): Call<Product>

        @FormUrlEncoded
        @POST("json/bazaInit.php")
        fun insert(@Field("name") name: String,
                   @Field("price") price: Int,
                   @Field("active") active: Int,
                   @Field("description") description: String): Call<Void>

        @FormUrlEncoded
        @PUT("json/bazaInit.php?product_id={product_id}")
        fun update(@Path("product_id") product_id: Int,
                   @Field("name") name: String,
                   @Field("price") price: Int,
                   @Field("active") active: Int,
                   @Field("description") description: String): Call<Void>




    }

    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}